<?php
// basic path definitions
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('DOMAIN', $_SERVER['HTTP_HOST']);

//load composer stuff
require ROOT . '/lib/vendor/autoload.php';
require ROOT . '/lib/functions.php';
if (!file_exists(ROOT . '/../inc/configs/' . DOMAIN . '.config.inc.php'))
    die(json_encode(array('code' => -1, 'reason' => 'Invalid URL', 'dom' => DOMAIN)));
require_once(ROOT . '/../inc/configs/' . DOMAIN . '.config.inc.php');

//prepare firebase
use Kreait\Firebase;
use Firebase\Auth\Token\Exception\InvalidToken;

//timezone to UTC (+0)
date_default_timezone_set('Europe/Vienna');

// error reporting
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
ini_set('display_errors', 'Off');

$r = connectRedis();

$url = explode('/', ltrim($_GET['url'], '/'));
array_shift($url);

$token = $_SERVER['HTTP_FIREBASE_TOKEN']; // can be firebase token or firebase user id!

switch ($url[0]) {

    case 'deleteappointment':
        if (!$token || !$r->get(REDIS_PRESTRING.":users:$token:exists"))
            $ret = array('code' => -1, 'reason' => 'Not logged in');
        else
        {
            $appointment = $r->get(REDIS_PRESTRING.":users:$token:appointment");
            if($appointment)
            {
                $daytime = str_replace(';',':',$appointment);
                $r->decr(REDIS_PRESTRING.":timeslots:$daytime");
                $r->del(REDIS_PRESTRING.":users:$token:appointment");
            }
            
            if($url[1]=='admin')
                addToLog("[$token] Deleted by Admin");
            else
                addToLog("[$token] Deleted their appointment");
            $ret = array('code' => 0);
        }

    break;

    case 'choosetimeslot':
        if (!$token || !$r->get(REDIS_PRESTRING.":users:$token:exists"))
            $ret = array('code' => -1, 'reason' => 'Not logged in');
        else
        {
            $day = $url[1];
            $timeslot = $url[2];
            $dd = getDayData();

            if($r->get(REDIS_PRESTRING.":users:$token:appointment"))
            {
                addToLog("[$token] Tried to register day $day at $timeslot but they already had an appointment");
                $ret = array('code' => -1, 'reason' => 'Sie haben bereits einen Termin gebucht! Wenn sie ihn ändern möchten, löschen Sie zunächst den bestehenden Termin');
            }
            else if(in_array($timeslot,$dd[$day]['timeslots']))
            {
                $reg = $r->get(REDIS_PRESTRING.":timeslots:$day:$timeslot");
                if($reg >=EVENT_MAXRES_PER_TIMESLOT)
                {
                    addToLog("[$token] Tried to register day $day at $timeslot but this timeslot is already full");
                    $ret = array('code' => -1, 'reason' => 'Dieser Termin ist leider bereits ausgebucht');
                }
                else
                {
                    $r->set(REDIS_PRESTRING.":users:$token:appointment","$day;$timeslot");
                    $r->incr(REDIS_PRESTRING.":timeslots:$day:$timeslot");
                    addToLog("[$token] Successfully chose $day at $timeslot");
                    $ret = array('code' => 0, 'data' => array(
                        'chosentimeslot' => array('day'=>$day,'time'=>$timeslot)
                    ));
                }
            }
            else
            {
                $ret = array('code' => -1, 'reason' => 'Ungültige Zeit ausgewählt');
            }
        }
    break;

    case 'gettimeslotdata':
        if (!$token || !$r->get(REDIS_PRESTRING.":users:$token:exists"))
            $ret = array('code' => -1, 'reason' => 'Not logged in');
        else
        {
            $o = array();
            $dd = getDayData();
            foreach($dd as $day=>$data)
            {
                $slots = $data['timeslots'];
                foreach($slots as $time)
                {
                    $exists = $r->get(REDIS_PRESTRING.":timeslots:$day:$time");
                    $o[$day][$time] = $exists;
                }
            }

            $ret = array('code' => 0, 'data' => array(
                'timeslotdata' => $o,
                'userappointment' => $r->get(REDIS_PRESTRING.":users:$token:appointment")
            ));
        }
    break;

    case 'saveuserinfo':
        if (!$token)
            $ret = array('code' => -1, 'reason' => 'Not logged in');
        else
        {
            if($r->get(REDIS_PRESTRING.":users:$token:exists"))
            {
                $data = json_decode(file_get_contents("php://input"),true);
                $fields = getFields();

                foreach($fields as $field => $fd)
                {
                    $r->set(REDIS_PRESTRING.":users:$token:$field",$data['fields'][$field]);
                }
                addToLog("[$token] Changed their settings");
                $ret = array('code' => 0,'fields'=>getUserFields($token));
            }
            else
            {
                $ret = array('code' => -1, 'reason' => 'Unbekannter Benutzer');
            }
        }
        
    break;
    
    case 'getuserinfo':
        if (!$token)
            $ret = array('code' => -1, 'reason' => 'Not logged in');
        else
            $ret = firebasecheck($token);
    break;

    case 'getpageinfo':
        $ret = array('code' => 0, 'data' => array(
            'firebaseconfig' => array(
                'apiKey' => FIREBASE_APIKEY,
                'authDomain' => FIREBASE_AUTHDOMAIN,
                'databaseURL' => FIREBASE_DATABASEURL,
                'projectId' => FIREBASE_PROJECT_ID,
                'storageBucket' => FIREBASE_STORAGEBUCKET,
                'messagingSenderId' => FIREBASE_MESSAGINGSENDERID,
                'appId' => FIREBASE_APPID
            ),
            'USER_FIELDS' => getFields(),
            'TIMESLOTS' => getDayData(),
            'SCHOOLNAME' => SCHOOLNAME,
            'TITLE' => TITLE,
            'SCHOOL_INFOTEXT' => SCHOOL_INFOTEXT,
            'SCHOOL_NOTICE' => (defined('SCHOOL_NOTICE')?SCHOOL_NOTICE:''),
            'SCHOOL_CONTACT' => SCHOOL_CONTACT,
            'PAGE_URL' => PAGE_URL,
            'PAGE_HEADER_IMG' => PAGE_HEADER_IMG,
            'PAGE_HEADER_CARD1' => PAGE_HEADER_CARD1,
            'PAGE_HEADER_CARD2' => PAGE_HEADER_CARD2,
            'EVENT_DATE' => EVENT_DATE,
            'EVENT_MAXRES_PER_TIMESLOT' => EVENT_MAXRES_PER_TIMESLOT,
            'PLATFORM_ONLINE_FROM' => PLATFORM_ONLINE_FROM,
            'PLATFORM_ONLINE_FROM_STRING'=>date("d.m.y H:i",PLATFORM_ONLINE_FROM),
            'PLATFORM_ONLINE_TO' => PLATFORM_ONLINE_TO,
            'PLATFORM_ONLINE_NOW' => ((time() >= PLATFORM_ONLINE_FROM && time() < PLATFORM_ONLINE_TO)?true:false),
            'PLATFORM_OPENS_IN' => ( time() < PLATFORM_ONLINE_FROM ?(PLATFORM_ONLINE_FROM - time()):false),
            'PLATFORM_CLOSES_IN' => ( time() < PLATFORM_ONLINE_TO ?(PLATFORM_ONLINE_TO - time()):false),
            'SLOTS_STATS'=>getFreeSlotsCount()
        ));
        break;

    default:
        $ret = array('code' => -1, 'reason' => 'Not implemented', 'url'=>$url);
}


header('Content-Type: application/json');
echo json_encode($ret, JSON_FORCE_OBJECT);