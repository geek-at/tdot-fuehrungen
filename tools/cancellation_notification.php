<?php
require '../api/lib/vendor/autoload.php';
require '../api/lib/functions.php';
require '../api/lib/PHPMailer.php';
require_once('../inc/configs/fuehrungen.brg1.at.config.inc.php');

define('SMTP_USER',"noreply@brg1.at");
define('SMTP_HOST',"smtp-relay.gmail.com");
define('SMTP_PW',"");
define('SMTP_PORT',"25");
define('SMTP_AUTH',FALSE);
define('SMTP_EHLO_DOMAIN','brg1.at');
define('EMAIL','it@brg1.at');

$pd = new Parsedown();

$template = file_get_contents('cancellation.template.md');

$fp = fopen('log.txt','a');

$in = file('daten.csv');
foreach($in as $line)
{
    $a = explode(';', trim($line));
    if($a[0])
    {
        $time = $a[0];
        continue;
    }
    $name = trim($a[1]);
    $email = trim($a[5]);

    $lastname = ucfirst(end(explode(' ', $name)));

    echo "[i] Sende Email an:\t$email";

    $mailtext = str_replace('{LASTNAME}', $lastname, $template);
    $mailtext = str_replace('{TIME}', $time, $mailtext);

    //var_dump($mailtext);

    $response = sendMail($email,'Schottenbastei - Stornierung des Termins am Tag der offenen Tür',$pd->text($mailtext),$mailtext);

    echo "\tdone\n";

    fwrite($fp,"[".SCHOOLNAME."] [".date("d.m H:i")."] ".$response."\n\n");
    
    sleep(0.5);

    //exit();
}

fclose($fp);