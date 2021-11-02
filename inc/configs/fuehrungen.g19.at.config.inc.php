<?php
date_default_timezone_set("Europe/Vienna");

// firebase
define('FIREBASE_APIKEY','AIzaSyCGc5D7V9y0h_tJfrMqtkiiFf2NturqFvk');
define('FIREBASE_AUTHDOMAIN','fuehrungen-g19.firebaseapp.com');
define('FIREBASE_DATABASEURL','https://fuehrungen-g19.firebaseio.com');
define('FIREBASE_PROJECT_ID','fuehrungen-g19');
define('FIREBASE_STORAGEBUCKET','fuehrungen-g19.appspot.com');
define('FIREBASE_MESSAGINGSENDERID','767780206915');
define('FIREBASE_APPID','1:767780206915:web:568104e9e794889e4417f6');

//school
define('ADMIN_PW',"GlkXtmDBPg");
define('SCHOOLNAME','Döblinger Gymnasium');
define('TITLE','Döblinger Gymnasium');
define('SCHOOL_INFOTEXT','Tag der Offenen Tür - Schüler*innen führen in Gruppen durch das Schulhaus.');
define('SCHOOL_CONTACT','');
//define('SCHOOL_NOTICE','');
define('PAGE_URL','https://fuehrungen.g19.at');
define('PAGE_HEADER_IMG','/imgs/g19-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/grg17-1.jpg');
define('PAGE_HEADER_CARD2','/imgs/grg17-2.jpg');
define('SCHOOL_NOTICE','
<div class="text-left">
<p>
    Aufgrund der derzeit gültigen Covid19-Regelungen ist der Besuch unseres Tages der Offenen
    Tür 2021 <strong>ausschließlich unter Einhaltung der 2,5-G-Regel (geimpft, genesen oder PCR-
    getestet) und mit einer von Schüler*innen geführten Tour durch das Schulhaus möglich.</strong>
    Während des Aufenthaltes im Schulhaus ist das Tragen eines Mund-Nasen-Schutzes oder
    einer FFP2- Maske verpflichtend.
</p>

<p>
    Im Rahmen der Führung kann Unterricht beobachtet werden und Sie können sich über unsere Angebote informieren. Neu ist unsere <strong>Ganztagesklasse</strong> ab dem Schuljahr 2022/23
</p>

<p>
Wir freuen uns sehr über die große Nachfrage! Am Freitag, dem 19.11.2021, sind keine Termine mehr verfügbar.<br/>
Deswegen bieten wir zusätzlich am Freitag, dem 26.11.2021, von 9:00 bis 14:00 weitere Führungen durch die Schule an.
</p>
</div>
');
define('EVENT_DATE','19.11.2021');
define('APPOINTMENT_MINUTES',20);
define('EVENT_MAXRES_PER_TIMESLOT',12);
define('PLATFORM_ONLINE_FROM',strtotime("20-10-2020"));
define('PLATFORM_ONLINE_TO',strtotime("22-11-2021"));
define('RESERVATION_EXPIRE_SECONDS',3600);

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:g19');

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
        '09:10',
        '10:15',
        '11:10',
        '12:10',
        '13:05',
    ),   'tag' => 'Freitag, 19.11.2021');

    $days[] = array('timeslots'=>array(
        '09:10',
        '10:15',
        '11:10',
        '12:10',
        '13:05',
    ),   'tag' => 'Freitag, 26.11.2021');
    return $days;
}

