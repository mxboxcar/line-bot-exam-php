<?php 

$accessToken = "j6gVSEqpU8POsHyYyt823Kti2n7a0k4L/Vgkn7mTSeMzZbqhJcGzYcJahqYauPJlCJk1z276DcGb9feiKzOsO9q+yLi7P8HPaUSvtkilhPcGED/Z7aDdiouv2tAJ/LzXCG6iEBfB4VHjTqcg3TYM8QdB04t89/1O/w1cDnyilFU=";

$content = file_get_contents('php://input');
$arrayJson = json_decode($content, true);

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";

$message = $arrayJson['events'][0]['message']['text'];

if(strtolower($message) == "help"){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = "คุณสามารถลงทะเบียนใหม่อีกครั้ง โดยพิมพ์ u\"ชื่อเข้าใช้งาน\"p\"รหัสผ่าน\"
สามารถลงทะเบียนใหม่ได้ตลอดเวลาหากต้องการเปลี่ยนโทรศัพท์หรือไลน์ไอดี";
    replyMsg($arrayHeader,$arrayPostData);
}

if (strpos(strtolower($message), 'u"') !== false && strpos(strtolower($message), '"p"') !== false) {
    // $exp = explode('u=[' , $message);
    // $exp2 = explode(']p=[', $exp[1]);
 //    $exp3 = explode(']', $exp2[1]);
    $u = findu($message)[1][0];
    $p = findp($message)[1][0];
    $uid = '';

    foreach ($arrayJson['events'] as $event) {
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            $uid = $event['source']['userId'];
        }
    }


// $d = register($u, $p, $uid);
//     $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
//         $arrayPostData['messages'][0]['type'] = "text";
//         $arrayPostData['messages'][0]['text'] = $d;
//     replyMsg($arrayHeader,$arrayPostData);

    if(register($u, $p, $uid) == 1) {
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "
ได้ทำการลงทะเบียนสำหรับโทรศัพท์เครื่องนี้แล้ว
    
ผู้ใช้งานของคุณคือ ".$u."
คุณจะได้รับการแจ้งเตือนจากระบบโดยอัตโนมัติผ่านช่องทาง Line นี้
การตอบกลับ จะไม่สามารถทำได้ คุณสามารถลงทะเบียนใหม่อีกครั้ง 
โดยพิมพ์ u=\"ชื่อเข้าใช้งาน\"p=\"รหัสผ่าน\"
สามารถลงทะเบียนใหม่ได้ตลอดเวลาหากต้องการเปลี่ยนโทรศัพท์หรือไลน์ไอดี";
    replyMsg($arrayHeader,$arrayPostData);
} else {
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "
ชื่อผู้ใช้งานและรหัสผ่านไม่ถูกต้อง";
    replyMsg($arrayHeader,$arrayPostData);
}

    
}
function findu($source) {
    preg_match_all( '#u"(.+?)"p"#s' , $source, $match );
    return $match;
}
function findp($source) {
    preg_match_all( '#"p"(.+?)"#s' , $source, $match );
    return $match;
}
function replyMsg($arrayHeader,$arrayPostData){
    $strUrl = "https://api.line.me/v2/bot/message/reply";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close ($ch);
}

function register($u, $p, $uid) {
    $strUrl = "http://portal.yd-cargo.com/_api/submit_lineman?u=".$u."&p=".$p."&uid=".$uid."&token=1qw23er45t@";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close ($ch);

    return $result;
}
exit;

?>
