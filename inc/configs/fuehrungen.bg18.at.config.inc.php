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
define('SCHOOL_INFOTEXT','Schüler und Schülerinnen des BG18 Klostergasse führen in Kleingruppen durchs Schulhaus.<br/><strong class="font-weight-bold">Wir bitten um Pünktlichkeit</strong>, da es sonst zu organisatorischen Problemen kommt.<br/>Für das Betreten des Schulhauses ist ein 3G-Nachweis erforderlich und für Erwachsene sind FFP2 Masken; für Kinder MNS Schutz erforderlich');
define('SCHOOL_CONTACT','');
define('PAGE_URL','https://fuehrungen.bg18.at');
define('PAGE_HEADER_IMG','/imgs/bg18-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/card-h.jpg');
define('PAGE_HEADER_CARD2','/imgs/card-h.jpg');

define('EVENT_DATE','2021/2022');
define('APPOINTMENT_MINUTES',10);
define('APPOINTMENT_TOMINUTE',20);
define('EVENT_MAXRES_PER_TIMESLOT',3);
define('PLATFORM_ONLINE_FROM',strtotime("12.10-2021"));
define('PLATFORM_ONLINE_TO',strtotime("14-01-2022")-1);
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

    return $days;
}