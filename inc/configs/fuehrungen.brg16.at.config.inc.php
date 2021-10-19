<?php
date_default_timezone_set("Europe/Vienna");

// firebase
define('FIREBASE_APIKEY','AIzaSyDfL6wrtXm30be2ZvYDha3jyXLJuxXC-rA');
define('FIREBASE_AUTHDOMAIN','brg16-fuehrungen.firebaseapp.com');
define('FIREBASE_DATABASEURL','https://brg16-fuehrungen.firebaseio.com');
define('FIREBASE_PROJECT_ID','brg16-fuehrungen');
define('FIREBASE_STORAGEBUCKET','brg16-fuehrungen.appspot.com');
define('FIREBASE_MESSAGINGSENDERID','265553160530');
define('FIREBASE_APPID','1:265553160530:web:54c9f3691174598602b28b');

//school
define('ADMIN_PW',"q9zf169u7na");
define('SCHOOLNAME','RG16 Schuhmeierplatz');
define('TITLE','Tag der offenen Tür');
define('SCHOOL_INFOTEXT','Tag der Offenen Tür - Schüler/innen führen in Kleingruppen durch das Schulhaus.');
define('SCHOOL_CONTACT','');
define('SCHOOL_NOTICE','
Aufgrund der derzeit gültigen Covid19-Regelungen ist der Besuch unseres Tages der Offenen Tür 2021 <strong>ausschließlich mit einer von Schüler/innen geführten Tour</strong> durch das Schulhaus möglich. Im Rahmen der Führung kann Unterricht beobachtet werden und nach der Führung haben Sie die Möglichkeit, Informationen zu den drei Schulzweigen des Parhamergymnasiums zu erhalten
<br/>
Beim Betreten des Schulhauses muss von allen Besucher/innen ein <strong>3G Nachweis</strong> (Impfbestätigung, Nachweis über Genesung oder aktueller Testnachweis) vorgezeigt werden. Während des Aufenthaltes im Schulhaus muss ein Mund-Nasen-Schutz oder eine FFP2- Maske getragen werden.
<br/>
Die Führungen finden in Gruppen bis maximal 10 Personen statt. Pro Person können jeweils zwei Plätze (z.B. Elternteil mit Kind) vorreserviert werden. Termine können ab Mittwoch, den 20.10., auf der Anmeldeplattform gebucht werden. Im Rahmen der Vorreservierung werden Ihre Telefonnummer und E-Mailadresse erhoben, um Sie im Bedarfsfall kontaktieren zu können. Sollten keine Termine mehr verfügbar sein, verweisen wir Sie auf unseren digitalen Informationsabend am Donnerstag, den 9. Dezember.');
define('PAGE_URL','https://fuehrungen.brg16.at');
define('PAGE_HEADER_IMG','/imgs/brg16-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/grg17-1.jpg');
define('PAGE_HEADER_CARD2','/imgs/grg17-2.jpg');

define('EVENT_DATE','16. Nov. 2021');
define('APPOINTMENT_MINUTES',20);
define('EVENT_MAXRES_PER_TIMESLOT',5);
define('PLATFORM_ONLINE_FROM',strtotime("20-10-2020"));
define('PLATFORM_ONLINE_TO',strtotime("10-11-2021"));
define('RESERVATION_EXPIRE_SECONDS',3600);

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:brg16');

//fields
function getFields(){
    return array(
        'person1'=>     array('type'=>'input','mandatory'=>true,'text'=>'Name 1. Person',   'hint'=>'Name der zum Besuch angemeldeten Person'),
        'person2'=>     array('type'=>'input','mandatory'=>false,'text'=>'Name 2. Person',  'hint'=>'Name des Kindes (Nur 1 Erwachsener + 1 Kind erlaubt)'),
        'phone'=>       array('type'=>'input','mandatory'=>true,'text'=>'Telefonnummer' ,   'hint'=>'Handy oder Festnetz für etwaige Kontaktaufnahme'),
        'email'=>       array('type'=>'input','mandatory'=>true,'text'=>'Email Adresse')
    );}

//timeslots
function getDayData() //16. nov 8:30-13:30
{
    $days[] = array('timeslots'=>array(
        '09:00','09:20','09:40',
        '10:00','10:20','10:40',
        '11:00','11:20','11:40',
        '12:00','12:20'
    ),   'tag' => 'Dienstag, 16.11.2021');
    return $days;
}

