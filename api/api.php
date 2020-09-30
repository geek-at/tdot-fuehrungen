<?php
// basic path definitions
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('DOMAIN', $_SERVER['SERVER_NAME']);

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

$url = explode('/', ltrim(parse_url($_GET['url'], PHP_URL_PATH), '/'));
array_shift($url);

$token = $_SERVER['HTTP_FIREBASE_TOKEN']; // can be firebase token or firebase user id!

switch ($url[0]) {
    case 'saveuserinfo':
        if (!$token)
            $ret = array('code' => -1, 'reason' => 'Not logged in');
        else
        {
            if($r->get(REDIS_PRESTRING.":$token:exists"))
            {
                $data = json_decode(file_get_contents("php://input"),true);
                $fields = getFields();

                foreach($fields as $field => $fd)
                {
                    $r->set(REDIS_PRESTRING.":$token:$field",$data['fields'][$field]);
                }
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
            'SCHOOL_INFOTEXT' => SCHOOL_INFOTEXT,
            'SCHOOL_CONTACT' => SCHOOL_CONTACT,
            'PAGE_URL' => PAGE_URL,
            'PAGE_HEADER_IMG' => PAGE_HEADER_IMG,
            'EVENT_DATE' => EVENT_DATE,
            'EVENT_MAXRES_PER_TIMESLOT' => EVENT_MAXRES_PER_TIMESLOT,
            'PLATFORM_ONLINE_FROM' => PLATFORM_ONLINE_FROM,
            'PLATFORM_ONLINE_FROM_STRING'=>date("d.m.y H:i",PLATFORM_ONLINE_FROM),
            'PLATFORM_ONLINE_TO' => PLATFORM_ONLINE_TO,
            'PLATFORM_ONLINE_NOW' => ((time() >= PLATFORM_ONLINE_FROM && time() < PLATFORM_ONLINE_TO)?true:false),
            'PLATFORM_OPENS_IN' => ( time() < PLATFORM_ONLINE_FROM ?(PLATFORM_ONLINE_FROM - time()):false),
            'PLATFORM_CLOSES_IN' => ( time() < PLATFORM_ONLINE_TO ?(PLATFORM_ONLINE_TO - time()):false)
        ));
        break;

    default:
        $ret = array('code' => -1, 'reason' => 'Not implemented');
}


header('Content-Type: application/json');
echo json_encode($ret);