<?php
use Kreait\Firebase;
use Firebase\Auth\Token\Exception\InvalidToken;

function firebasecheck($idTokenString)
{
    try {
        $auth = (new Firebase\Factory())->withProjectId(FIREBASE_PROJECT_ID)->createAuth();
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
    } catch (\InvalidArgumentException $e) {
        $ret = array('code' => -1,'token'=>$idTokenString,'project'=>FIREBASE_PROJECT_ID, 'reason' => 'The token could not be parsed: ' . $e->getMessage());
    } catch (InvalidToken $e) {
        $ret = array('code' => -1,'token'=>$idTokenString,'project'=>FIREBASE_PROJECT_ID, 'reason' => 'The token is invalid: ' . $e->getMessage());
    }

    if ($verifiedIdToken) {
        $uid = $verifiedIdToken->getClaim('sub');

        try {
            $phone = $verifiedIdToken->getClaim('phone_number');
            if(fieldExistsInUser('phone',$phone))
            {
                $ouid = $uid;
                $uid = fieldExistsInUser('phone',$phone);
                addToLog("[$ouid] has an existing phone number and is now known as $uid");
            }
            else
                addToLog("[$uid] Logged in with the phone number $phone");
        } catch (Throwable $e) {
            $phone = false;
        }

        try {
            $email = $verifiedIdToken->getClaim('email');
            if(fieldExistsInUser('email',$email))
            {
                $ouid = $uid;
                $uid = fieldExistsInUser('email',$email);
                addToLog("[$ouid] has an existing email and is now known as $uid");
            }
            else
                addToLog("[$uid] Logged in with the email $email");
        } catch (Throwable $e) {
            $email = false;
        }

        $redis = connectRedis();
        $redis->set(REDIS_PRESTRING.":users:$uid:exists",true);
        if($email)
            $redis->set(REDIS_PRESTRING.":users:$uid:email",$email);
        if($phone)
            $redis->set(REDIS_PRESTRING.":users:$uid:phone",$phone);

        $ret = array('code' => 0, 'data'=>array(
            'fields'=>getUserFields($uid),
            'id'=>$uid
        ));
    }

    return $ret;
}

function getUserFields($user)
{
    $redis = connectRedis();

    $f = getFields();
    $o = array();
    foreach($f as $key=>$fd)
    {
        $o[$key] = $redis->get(REDIS_PRESTRING.":users:$user:$key");
    }

    return $o;
}

function connectRedis()
{
    $redis = new Redis();
    $redis->pconnect(REDIS_SERVER,REDIS_PORT);
    if(defined('REDIS_PASS') && REDIS_PASS)
        $redis->auth(REDIS_PASS);
    return $redis;
}

function uuid(){
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); 
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function getCustomTimeslots($from,$to)
{
    //time calc
    $starttime = $from;
    $endtime = $to;

    $start = strtotime($starttime);
    $end = strtotime($endtime);
    $time = $start;

    while($time<$end)
    {
        $hour = date("H:i",$time);
        $min = date("i",$time);

        
        //echo "$hour<br/>";
        $time+=(APPOINTMENT_MINUTES*60);
        if($min && defined('APPOINTMENT_TOMINUTE') && is_numeric(APPOINTMENT_TOMINUTE) && $min > APPOINTMENT_TOMINUTE) continue;
        $timeslots[] = $hour;
    }

    return $timeslots;
}

function fieldExistsInUser($field,$value)
{
    $r = connectRedis();
    $data = $r->keys(REDIS_PRESTRING.':users:*');

    foreach($data as $key)
    {
        $parts = explode(':',$key);
        $user = $parts[3];
        if($parts[4]==$field && $r->get(REDIS_PRESTRING.":users:$user:$field")==$value)
            return $user;
    }
    return false;
}

function addToLog($data)
{
    $fp = fopen(ROOT.DS.'../log/log.txt','a');
    fwrite($fp,"[".SCHOOLNAME."] [".date("d.m H:i")."] ".$data."\n");
    fclose($fp);
}

function getSlotCount()
{
    $d = getDayData();
    $sum = 0;

    foreach($d as $dd)
    {
        $sum+=(count($dd['timeslots'])*EVENT_MAXRES_PER_TIMESLOT);
    }

    return $sum;
}

function getFreeSlotsCount()
{
    $total = getSlotCount();
    $used = 0;
    $redis = connectRedis();
    $users = $redis->keys(REDIS_PRESTRING . ':users:*');
            foreach ($users as $u) {
                $a = explode(':', $u);
                $user = $a[3];
                $field = $a[4];

                if ($field == 'appointment') {
                    $used++;
                }
            }

    return [
        'total' => $total,
        'used'  => $used,
        'free'  => ($total-$used),
        'free_percent' => round((($total-$used)/$total)*100),
        'used_percent' => round(($used/$total)*100),
    ];
}


function sendMail($rcpt,$subject,$html,$text)
{
    $mail = new PHPMailer();

    ob_start();

    $mail->CharSet ="UTF-8";
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = SMTP_HOST;                    // Set the SMTP server to send through
    $mail->SMTPAuth   = (defined('SMTP_AUTH')?SMTP_AUTH:true);                                   // Enable SMTP authentication
    $mail->Username   = SMTP_USER;                     // SMTP username
    $mail->Password   = SMTP_PW;                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = (defined('SMTP_PORT')?SMTP_PORT:587);                                    // TCP port to connect to
    if(defined('SMTP_EHLO_DOMAIN') && SMTP_EHLO_DOMAIN)
        $mail->Hostname = SMTP_EHLO_DOMAIN;

    //Recipients
    $mail->setFrom(EMAIL, 'Schottenbastei IT');
    $mail->addAddress($rcpt);     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $html;
    $mail->AltBody = $text;

    $mail->send();

    $output = ob_get_clean();

    addToLog("[EML] Email sent to $rcpt\tSubject: $subject");

    return $output;
}