<?php


// firebase
define('FIREBASE_APIKEY','AIzaSyDcVy4T0g-A_PqDvenN9rPy32cR4wI2Xbk');
define('FIREBASE_AUTHDOMAIN','parhamer-tdot.firebaseapp.com');
define('FIREBASE_DATABASEURL','https://parhamer-tdot.firebaseio.com');
define('FIREBASE_PROJECT_ID','parhamer-tdot');
define('FIREBASE_STORAGEBUCKET','parhamer-tdot.appspot.com');
define('FIREBASE_MESSAGINGSENDERID','764917948690');
define('FIREBASE_APPID','1:764917948690:web:5fe458a572d709de9213cb');

//school
define('ADMIN_PW',"7lfmcse0kx");
define('SCHOOLNAME','Discover Parhamer');
define('TITLE','Info Nachmittage am Parhamergymnasium');
define('SCHOOL_INFOTEXT','Schüler und Schülerinnen des Parhamergymnasiums führen am 16. November in Kleingruppen durchs Schulhaus. Ein Tag der offenen Tür findet in diesem Herbst leider nicht statt.');
define('SCHOOL_CONTACT','');
define('PAGE_URL','https://fuehrungen.parhamer.at');
define('PAGE_HEADER_IMG','/imgs/parhamer-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/grg17-1.jpg');
define('PAGE_HEADER_CARD2','/imgs/grg17-2.jpg');

define('EVENT_DATE','16. Nov. 2021');
define('APPOINTMENT_MINUTES',15);
define('EVENT_MAXRES_PER_TIMESLOT',5);
define('PLATFORM_ONLINE_FROM',strtotime("21-10-2020"));
define('PLATFORM_ONLINE_TO',strtotime("11-11-2022"));
define('RESERVATION_EXPIRE_SECONDS',3600);

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:parhamer');

//fields
function getFields(){
    return array(
        'person1'=>     array('mandatory'=>true,'text'=>'Name 1. Person',   'hint'=>'Name der zum Besuch angemeldeten Person'),
        'person2'=>     array('mandatory'=>false,'text'=>'Name 2. Person',  'hint'=>'Name des Kindes (Nur 1 Erwachsener + 1 Kind erlaubt)'),
        'phone'=>       array('mandatory'=>true,'text'=>'Telefonnummer' ,   'hint'=>'Handy oder Festnetz für etwaige Kontaktaufnahme'),
        // optional für welchen zweig interessiert
        'email'=>       array('mandatory'=>true,'text'=>'Email Adresse')
    );}

//timeslots
function getDayData() //16. nov 8:30-13:30
{
    $days[] = array('timeslots'=>array(
        '08:00','08:15','08:30','08:45',
        '09:00','09:15','09:30','09:45',
        '10:00','10:15','10:30','10:45',
        '11:00','11:15','11:30','11:45',
        '12:00','12:15','12:30','12:45',
        '13:00','13:15','13:30'
    ),   'tag' => 'Dienstag, 16.11.2021');
    return $days;
}

