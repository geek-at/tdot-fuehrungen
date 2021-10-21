<?php
date_default_timezone_set("Europe/Vienna");

// firebase
define('FIREBASE_APIKEY','AIzaSyB1kA0I6ydP5ghqP7vvdxql8N8xX3qOyv4');
define('FIREBASE_AUTHDOMAIN','fuehrungen-brg1.firebaseapp.com');
define('FIREBASE_DATABASEURL','https://fuehrungen-brg1.firebaseio.com');
define('FIREBASE_PROJECT_ID','fuehrungen-brg1');
define('FIREBASE_STORAGEBUCKET','fuehrungen-brg1.appspot.com');
define('FIREBASE_MESSAGINGSENDERID','188612652034');
define('FIREBASE_APPID','1:188612652034:web:1616ad390829df03b2cb1b');

//school
define('ADMIN_PW',"GlkXtmDBPg");
define('SCHOOLNAME','Lise Meitner Realgymnasium');
define('TITLE','BRG1 Schottenbastei');
define('SCHOOL_INFOTEXT','Tag der Offenen Tür - Schüler/innen führen in Gruppen durch das Schulhaus.');
define('SCHOOL_CONTACT','');
//define('SCHOOL_NOTICE','');
define('PAGE_URL','https://fuehrungen.brg1.at');
define('PAGE_HEADER_IMG','/imgs/brg1-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/grg17-1.jpg');
define('PAGE_HEADER_CARD2','/imgs/grg17-2.jpg');

define('EVENT_DATE','23. Nov. 2021');
define('APPOINTMENT_MINUTES',20);
define('EVENT_MAXRES_PER_TIMESLOT',30);
define('PLATFORM_ONLINE_FROM',strtotime("20-10-2020"));
define('PLATFORM_ONLINE_TO',strtotime("22-11-2021"));
define('RESERVATION_EXPIRE_SECONDS',3600);

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:brg1');

//fields
function getFields(){
    return array(
        'person1'=>     array('type'=>'input','mandatory'=>true,'text'=>'Erwachsener 1',   'hint'=>'Name der zum Besuch angemeldeten Person'),
        'person2'=>     array('type'=>'input','mandatory'=>false,'text'=>'Erwachsener 2',  'hint'=>'Name der zweiten zum Besuch angemeldeten Person'),
        'person3'=>     array('type'=>'input','mandatory'=>false,'text'=>'Kind',  'hint'=>'Name des Kindes (Nur 1 Erwachsener + 1 Kind erlaubt)'),
        'phone'=>       array('type'=>'input','mandatory'=>true,'text'=>'Telefonnummer' ,   'hint'=>'Handy oder Festnetz für etwaige Kontaktaufnahme'),
        'email'=>       array('type'=>'input','mandatory'=>true,'text'=>'Email Adresse')
    );}

//timeslots
function getDayData()
{
    $days[] = array('timeslots'=>array(
        '09:00',
        '10:00',
        '11:00',
        '12:00'
    ),   'tag' => 'Dienstag, 23.11.2021');
    return $days;
}

