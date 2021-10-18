<?php
date_default_timezone_set("Europe/Vienna");

// firebase
define('FIREBASE_APIKEY','AIzaSyDk9nnVONr5ClrvWg4RsgZL33RN0oS7LbQ');
define('FIREBASE_AUTHDOMAIN','fuehrung-demo.firebaseapp.com');
define('FIREBASE_DATABASEURL','https://fuehrung-demo.firebaseio.com');
define('FIREBASE_PROJECT_ID','fuehrung-demo');
define('FIREBASE_STORAGEBUCKET','fuehrung-demo.appspot.com');
define('FIREBASE_MESSAGINGSENDERID','885156528587');
define('FIREBASE_APPID','1:885156528587:web:6877f52b0f79a339e7364e');

//school
define('ADMIN_PW',"demo1234");
define('SCHOOLNAME','Demoschule');
define('TITLE','Schulführungen Demo Anmeldung');
define('SCHOOL_INFOTEXT','Schüler und Schülerinnen führen in Kleingruppen durchs Schulhaus');
define('SCHOOL_NOTICE','Diese Demoseite zeigt, wie die Elternansicht aussieht. Für die Administrative Ansicht klicken Sie <a href="/schuladministration.php?password=demo1234">hier</a>. Die eingetragenen Daten sind Zufallsgeneriert.');
define('SCHOOL_CONTACT','');
define('PAGE_URL','https://demo.fuehrungen.haschek.solutions');
define('PAGE_HEADER_IMG','/imgs/bg18-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/card-h.jpg');
define('PAGE_HEADER_CARD2','/imgs/card-h.jpg');

define('EVENT_DATE','2021/2022');
define('APPOINTMENT_MINUTES',10);
define('APPOINTMENT_TOMINUTE',20);
define('EVENT_MAXRES_PER_TIMESLOT',3);
define('PLATFORM_ONLINE_FROM',strtotime("12.10-2020"));
define('PLATFORM_ONLINE_TO',strtotime("14-01-2029")-1);
define('RESERVATION_EXPIRE_SECONDS',3600);

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:demo');

//fields
function getFields(){
    return array(
        'person1'=>     array('type'=>'input','mandatory'=>true,'text'=>'Name 1. Person',   'hint'=>'Name der zum Besuch angemeldeten Person'),
        'person2'=>     array('type'=>'input','mandatory'=>false,'text'=>'Name 2. Person',  'hint'=>'Name der zweiten Person'),
        'phone'=>       array('type'=>'input','mandatory'=>true,'text'=>'Telefonnummer' ,   'hint'=>'Handy oder Festnetz für etwaige Kontaktaufnahme'),
        'email'=>       array('type'=>'input','mandatory'=>true,'text'=>'Email Adresse')
    );}

//timeslots
function getDayData()
{
    $days = [];

    $days[] = array(
        'timeslots'=>getCustomTimeslots('09:00','11:50'),
        'tag' => 'Freitag, 12. Nov. 2021'
    );

    $days[] = array(
        'timeslots'=>getCustomTimeslots('09:00','11:50'),
        'tag' => 'Freitag, 10. Dez. 2021'
    );

    $days[] = array(
        'timeslots'=>getCustomTimeslots('09:00','11:50'),
        'tag' => 'Freitag, 14. Jän. 2022'
    );

    $days[] = array(
        'timeslots'=>getCustomTimeslots('09:00','11:50'),
        'tag' => 'Freitag, 21. Jän. 2022'
    );

    $days[] = array(
        'timeslots'=>getCustomTimeslots('09:00','11:50'),
        'tag' => 'Freitag, 28. Jän. 2022'
    );

    return $days;
}