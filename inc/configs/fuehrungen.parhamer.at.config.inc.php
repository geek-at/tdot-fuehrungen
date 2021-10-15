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
define('TITLE','Tag der offenen Tür am Parhamergymnasium');
define('SCHOOL_INFOTEXT','Tag der Offenen Tür - Schüler/innen führen in Kleingruppen durch das Schulhaus.');
define('SCHOOL_CONTACT','');
define('SCHOOL_NOTICE','
Aufgrund der derzeit gültigen Covid19-Regelungen ist der Besuch unseres Tages der Offenen Tür 2021 <strong>ausschließlich mit einer von Schüler/innen geführten Tour</strong> durch das Schulhaus möglich. Im Rahmen der Führung kann Unterricht beobachtet werden und nach der Führung haben Sie die Möglichkeit, Informationen zu den drei Schulzweigen des Parhamergymnasiums zu erhalten
<br/>
Beim Betreten des Schulhauses muss von allen Besucher/innen ein <strong>3G Nachweis</strong> (Impfbestätigung, Nachweis über Genesung oder aktueller Testnachweis) vorgezeigt werden. Während des Aufenthaltes im Schulhaus muss ein Mund-Nasen-Schutz oder eine FFP2- Maske getragen werden.
<br/>
Die Führungen finden in Gruppen bis maximal 10 Personen statt. Pro Person können jeweils zwei Plätze (z.B. Elternteil mit Kind) vorreserviert werden. Termine können ab Mittwoch, den 20.10., auf der Anmeldeplattform gebucht werden. Im Rahmen der Vorreservierung werden Ihre Telefonnummer und E-Mailadresse erhoben, um Sie im Bedarfsfall kontaktieren zu können. Sollten keine Termine mehr verfügbar sein, verweisen wir Sie auf unseren digitalen Informationsabend am Donnerstag, den 9. November.');
define('PAGE_URL','https://fuehrungen.parhamer.at');
define('PAGE_HEADER_IMG','/imgs/parhamer-h.jpg');
define('PAGE_HEADER_CARD1','/imgs/grg17-1.jpg');
define('PAGE_HEADER_CARD2','/imgs/grg17-2.jpg');

define('EVENT_DATE','16. Nov. 2021');
define('APPOINTMENT_MINUTES',15);
define('EVENT_MAXRES_PER_TIMESLOT',5);
define('PLATFORM_ONLINE_FROM',strtotime("20-10-2020"));
define('PLATFORM_ONLINE_TO',strtotime("10-11-2022"));
define('RESERVATION_EXPIRE_SECONDS',3600);

//redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASS','');
define('REDIS_PRESTRING', 'tdot:parhamer');

//fields
function getFields(){
    return array(
        'person1'=>     array('type'=>'input','mandatory'=>true,'text'=>'Name 1. Person',   'hint'=>'Name der zum Besuch angemeldeten Person'),
        'person2'=>     array('type'=>'input','mandatory'=>false,'text'=>'Name 2. Person',  'hint'=>'Name des Kindes (Nur 1 Erwachsener + 1 Kind erlaubt)'),
        'phone'=>       array('type'=>'input','mandatory'=>true,'text'=>'Telefonnummer' ,   'hint'=>'Handy oder Festnetz für etwaige Kontaktaufnahme'),
        'email'=>       array('type'=>'input','mandatory'=>true,'text'=>'Email Adresse'),
        'zweig'=>       array('type'=>'select','mandatory'=>false,'text'=>'Interesse am Zweig','hint'=>'Bitte auswählen, an welchem Zweig ein Interesse besteht','options'=>[
            'WIKU',
            'Sport',
            'Bilingual'
        ])
    );}

//timeslots
function getDayData() //16. nov 8:30-13:30
{
    $days[] = array('timeslots'=>array(
        '08:30','08:45',
        '09:00','09:15','09:30','09:45',
        '10:00','10:15','10:30','10:45',
        '11:00','11:15','11:30','11:45',
        '12:00','12:15','12:30','12:45',
        '13:00','13:15','13:30'
    ),   'tag' => 'Dienstag, 16.11.2021');
    return $days;
}

