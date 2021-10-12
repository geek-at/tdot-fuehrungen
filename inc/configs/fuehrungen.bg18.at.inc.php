<?php


// firebase
define('FIREBASE_APIKEY','AIzaSyCSXGq6mj2QiEgmYpJklaFZ-fL4WZhQuBc');
define('FIREBASE_AUTHDOMAIN','bg18-tdot.firebaseapp.com');
define('FIREBASE_DATABASEURL','https://bg18-tdot.firebaseio.com');
define('FIREBASE_PROJECT_ID','bg18-tdot');
define('FIREBASE_STORAGEBUCKET','bg18-tdot.appspot.com');
define('FIREBASE_MESSAGINGSENDERID','376752977671');
define('FIREBASE_APPID','1:376752977671:web:97aa994e2e20b0a430b7a2');

//school
define('ADMIN_PW',"rGQzVDbBc");
define('SCHOOLNAME','BG18 Klostergasse');
define('TITLE','Schulführungen am BG18 Klostergasse');
define('SCHOOL_INFOTEXT','Schüler und Schülerinnen des BG18 Klostergasse führen in Kleingruppen durchs Schulhaus.<br/><strong class="font-weight-bold">Wir bitten um Pünktlichkeit</strong>, da es sonst zu organisatorischen Problemen kommt.');
define('SCHOOL_CONTACT','');
define('PAGE_URL','https://tdot.bg18.at');
define('PAGE_HEADER_IMG','/imgs/bg18-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/card-h.jpg');
define('PAGE_HEADER_CARD2','/imgs/card-h.jpg');

define('EVENT_DATE','16. März 2020');
define('APPOINTMENT_MINUTES',5);
define('APPOINTMENT_TOMINUTE',25);
define('EVENT_MAXRES_PER_TIMESLOT',1);
define('PLATFORM_ONLINE_FROM',strtotime("29-09-2020 17:58"));
define('PLATFORM_ONLINE_TO',strtotime("29-11-2020 17:34")-1);
define('RESERVATION_EXPIRE_SECONDS',3600);

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:bg18');

//fields
function getFields(){
    return array(
        'person1'=>     array('mandatory'=>true,'text'=>'Name 1. Person',   'hint'=>'Name der zum Besuch angemeldeten Person'),
        'person2'=>     array('mandatory'=>false,'text'=>'Name 2. Person',  'hint'=>'Name der zweiten Person'),
        'phone'=>       array('mandatory'=>true,'text'=>'Telefonnummer' ,   'hint'=>'Handy oder Festnetz für etwaige Kontaktaufnahme'),
        'email'=>       array('mandatory'=>true,'text'=>'Email Adresse')
    );}

//timeslots
function getDayData()
{
    $days[] = array(
        'timeslots'=>getCustomTimeslots('10:00','12:50'),
        'tag' => 'Dienstag, 01.12.2020'
    );

    $days[] = array(
        'timeslots'=>getCustomTimeslots('09:00','11:50'),
        'tag' => 'Freitag, 04.12.2020'
    );

    $days[] = array(
        'timeslots'=>getCustomTimeslots('09:00','11:50'),
        'tag' => 'Freitag, 11.12.2020'
    );

    $days[] = array(
        'timeslots'=>getCustomTimeslots('10:00','12:50'),
        'tag' => 'Dienstag, 15.12.2020'
    );

    $days[] = array(
        'timeslots'=>getCustomTimeslots('09:00','11:50'),
        'tag' => 'Freitag, 18.12.2020'
    );

    return $days;
}