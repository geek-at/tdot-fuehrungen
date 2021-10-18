<?php
date_default_timezone_set("Europe/Vienna");

// firebase
define('FIREBASE_APIKEY','');
define('FIREBASE_AUTHDOMAIN','');
define('FIREBASE_DATABASEURL','');
define('FIREBASE_PROJECT_ID','');
define('FIREBASE_STORAGEBUCKET','');
define('FIREBASE_MESSAGINGSENDERID','');
define('FIREBASE_APPID','');

//school
define('SCHOOLNAME','');
define('SCHOOL_INFOTEXT','');
define('SCHOOL_CONTACT','');
define('PAGE_URL','');
define('PAGE_HEADER_IMG','');
define('APPOINTMENT_MINUTES',15);
define('EVENT_MAXRES_PER_TIMESLOT',8);
define('PLATFORM_ONLINE_FROM',strtotime("29-09-2020 17:58"));
define('PLATFORM_ONLINE_TO',strtotime("29-10-2020 17:34")-1);
define('RESERVATION_EXPIRE_SECONDS',3600);

//email
define('SMTP_HOST',"");
define('SMTP_USER',"");
define('SMTP_PW',"");
define('EMAIL_FROM', '');

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:schulname');

//fields
function getFields(){
    return array(
        'person1'=>     array('mandatory'=>true,'text'=>'Name 1. Person',   'hint'=>'Name der zum Besuch angemeldeten Person'),
        'person2'=>     array('mandatory'=>false,'text'=>'Name 2. Person',  'hint'=>'Name des Kindes (Nur 1 Erwachsener + 1 Kind erlaubt)'),
        'phone'=>       array('mandatory'=>true,'text'=>'Telefonnummer' ,   'hint'=>'Handy oder Festnetz für etwaige Kontaktaufnahme'),
        'email'=>       array('mandatory'=>true,'text'=>'Email Adresse')
    );}

//timeslots
function getDayData()
{
    $days[] = array('timeslots'=>getCustomTimeslots('15:00','18:15'),    'tag' => 'Mittwoch, 11.11.2020');
    $days[] = array('timeslots'=>getCustomTimeslots('15:00','18:15'),    'tag' => 'Donnerstag, 12.11.2020');
    return $days;
}