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
/*define('SCHOOL_NOTICE','
Aufgrund der derzeit gültigen Covid19-Regelungen ist der Besichtigung unseres Schulgebäudes am Tag der Offenen Tür 2021 ausschließlich nach Voranmeldung und mit einer von Schüler*innen geführten Tour durch das Schulhaus möglich. Im Rahmen der Führung kann das Schulhaus besichtigt und Unterricht beobachtet werden. 
Unsere Informationsständen, welche sich am Tag der Offenen Tür in der Fußgängerzone vor der Schule befinden werden, können auch ohne Voranmeldung besucht werden. Hier werden Ihnen von unseren Lehrer*innen, Schüler*innen und Eltern Informationen zu sämtlichen Themen, unsere Schule betreffend, geboten.
Für das Betreten des Schulhauses gilt für alle Besucherinnen und Besucher die 3-G-Regel (Impfbestätigung, Nachweis über Genesung oder aktueller PCR-Test-Nachweis). Während des Aufenthaltes im Schulhaus ist das Tragen eines Mund-Nasen-Schutzes oder einer FFP2- Maske verpflichtend.
Die Führungen finden in Gruppen mit maximal 6 Personen statt. Pro Person können jeweils drei Plätze (z.B. zwei Elternteile mit Kind) reserviert werden.
Die Plattform zur Terminreservierung wird am Freitag, den 22.10. freigeschaltet. Bitte geben Sie bei der Reservierung  Ihre Telefonnummer und E-Mailadresse an, damit wir Sie gegebenenfalls kontaktieren können.
');*/
define('PAGE_URL','https://fuehrungen.brg1.at');
define('PAGE_HEADER_IMG','/imgs/brg1-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/grg17-1.jpg');
define('PAGE_HEADER_CARD2','/imgs/grg17-2.jpg');

define('EVENT_DATE','23. Nov. 2021');
define('APPOINTMENT_MINUTES',20);
define('EVENT_MAXRES_PER_TIMESLOT',15);
define('PLATFORM_ONLINE_FROM',strtotime("22-11-2021"));
define('PLATFORM_ONLINE_TO',strtotime("22-12-2021"));
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
        '09:00','09:30',
        '10:00','10:30',
        '11:00','11:30',
        '12:00','12:30'
    ),   'tag' => 'Dienstag, 23.11.2021');
    return $days;
}

