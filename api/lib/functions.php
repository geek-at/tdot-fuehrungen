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
        } catch (Throwable $e) {
            $phone = false;
        }

        try {
            $email = $verifiedIdToken->getClaim('email');
        } catch (Throwable $e) {
            $email = false;
        }

        $redis = connectRedis();
        $redis->set(REDIS_PRESTRING.":$uid:exists",true);
        if($email)
            $redis->set(REDIS_PRESTRING.":$uid:email",$email);
        if($phone)
            $redis->set(REDIS_PRESTRING.":$uid:phone",$phone);

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
        $o[$key] = $redis->get(REDIS_PRESTRING.":$user:$key");
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
        //echo "$hour<br/>";
        $time+=(APPOINTMENT_MINUTES*60); //+5min
        $timeslots[] = $hour;
    }

    return $timeslots;
}