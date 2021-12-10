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
define('SCHOOL_NOTICE','
Leider mussten wir den Tag der Offenen Tür absagen. Als Ersatz bieten wir 20-minütige
Schulführungen am 17.Jän., 18.Jän, 19. Jän., 20. Jän. und 21. Jän. an. An den
Schulführungen kann man ausschließlich nach Voranmeldung über unsere Plattform
teilnehmen.<br/>
Für das Betreten des Schulhauses gilt für alle Besucherinnen und Besucher die 2-G-Regel
(Impfbestätigung, Nachweis über Genesung oder aktueller PCR-Test-Nachweis). Während
des Aufenthaltes im Schulhaus ist das Tragen eines Mund-Nasen-Schutzes (Kinder) oder
einer FFP2- Maske (Eltern) verpflichtend.
');
define('PAGE_URL','https://fuehrungen.brg1.at');
define('PAGE_HEADER_IMG','/imgs/brg1-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/grg17-1.jpg');
define('PAGE_HEADER_CARD2','/imgs/grg17-2.jpg');

define('EVENT_DATE','23. Nov. 2021');
define('APPOINTMENT_MINUTES',20);
define('EVENT_MAXRES_PER_TIMESLOT',16);
define('PLATFORM_ONLINE_FROM',strtotime("22-11-2021"));
define('PLATFORM_ONLINE_TO',strtotime("22-12-2020"));
define('RESERVATION_EXPIRE_SECONDS',3600);

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:brg1');

//fields
function getFields(){
    return array(
        'person1'=>     array('type'=>'input','mandatory'=>true,'text'=>'Erwachsener',   'hint'=>'Name der zum Besuch angemeldeten Person'),
        'person2'=>     array('type'=>'input','mandatory'=>false,'text'=>'Kind',  'hint'=>'Name des Kindes (Nur 1 Erwachsener + 1 Kind erlaubt)'),
        'phone'=>       array('type'=>'input','mandatory'=>true,'text'=>'Telefonnummer' ,   'hint'=>'Handy oder Festnetz für etwaige Kontaktaufnahme'),
        'email'=>       array('type'=>'input','mandatory'=>true,'text'=>'Email Adresse')
    );}

//timeslots
function getDayData()
{
    $days[] = array('timeslots'=>array(
        '15:00','15:20',
        '15:40','16:00',
    ),   'tag' => 'Montag, 17.01.2022');

    $days[] = array('timeslots'=>array(
        '15:00','15:20',
        '15:40','16:00',
    ),   'tag' => 'Dienstag, 18.01.2022');

    $days[] = array('timeslots'=>array(
        '15:00','15:20',
        '15:40','16:00',
    ),   'tag' => 'Mittwoch, 19.01.2022');

    $days[] = array('timeslots'=>array(
        '15:00','15:20',
        '15:40','16:00',
    ),   'tag' => 'Donnerstag, 20.01.2022');

    $days[] = array('timeslots'=>array(
        '15:00','15:20',
        '15:40','16:00',
    ),   'tag' => 'Freitag, 21.01.2022');

    return $days;
}

