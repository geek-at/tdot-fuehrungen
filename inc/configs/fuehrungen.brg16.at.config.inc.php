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
<p>
    Aufgrund der derzeit gültigen Covid19-Regelungen ist der Besuch unseres Tages der Offenen
    Tür 2021 <strong>ausschließlich unter Einhaltung der 2,5-G-Regel (geimpft, genesen oder PCR-
    getestet) und mit einer von Schüler*innen geführten Tour durch das Schulhaus möglich.</strong>
    Während des Aufenthaltes im Schulhaus ist das Tragen eines Mund-Nasen-Schutzes oder
    einer FFP2- Maske verpflichtend.
</p>

<p>
    Im Rahmen der Führung kann Unterricht beobachtet werden und Sie können sich über unsere Angebote informieren.
</p>

<p>Sie bekommen auch Informationen zu unseren <strong>neuen Schwerpunktklassen</strong> der Unterstufe:</p>

<ul>
    <li><strong>Musisch-kreativ</strong> (Musik und bildende Kunst)</li>
    <li><strong>MINT</strong> (Mathematik – Informatik – Naturwissenschaften – Technik)</li>
    <li><strong>IWA</strong> (Ich – Wir – Alle; Sozial- und Lebenskompetenz)</li>
    <li><strong>Spanisch</strong></li>
</ul>

<p>
    Sie können auch <strong>ohne Terminreservierung</strong> kommen, müssen jedoch mit etwaigen Wartezeiten (Registrierung) rechnen.
</p>
');
define('PAGE_URL','https://fuehrungen.brg16.at');
define('PAGE_HEADER_IMG','/imgs/brg16-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/grg17-1.jpg');
define('PAGE_HEADER_CARD2','/imgs/grg17-2.jpg');

define('EVENT_DATE','12. Nov. 2021');
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
    ),   'tag' => 'Freitag, 12.11.2021');
    return $days;
}

