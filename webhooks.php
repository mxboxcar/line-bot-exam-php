<?php 

$accessToken = "l0UNFhBydAcupsHzUqaxGzMUqH3eBq0nQWTrfUh7X7Ega7ZaHIxHVWGFc0Itu7lEtpjyp4YFkfCiXJrghUulqW3UnxrtCc0VYbDano9N7Ja8gvdxgNqEox9m9Y1sWaH38Qqb1bPwNYPD0Og4OwWgUQdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่

$content = file_get_contents('php://input');
$arrayJson = json_decode($content, true);

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";

$message = $arrayJson['events'][0]['message']['text'];

if($message == "help"){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = "คุณสามารถลงทะเบียนใหม่อีกครั้ง โดยพิมพ์ code=[รหัสลูกค้าของคุณ]
สามารถลงทะเบียนใหม่ได้ตลอดเวลาหากต้องการเปลี่ยนโทรศัพท์หรือไลน์ไอดี
    
ขอบคุณค่ะ
YD-Cargo";
    replyMsg($arrayHeader,$arrayPostData);
}

if (strpos($message, 'code=[') !== false) {
	$exp = explode('code=[' , $message);
	$exp2 = explode(']', $exp[1]);

//register($exp2[0], $arrayJson['source']['userId'])

	$arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "
ได้ทำการลงทะเบียนสำหรับโทรศัพท์เครื่องนี้แล้ว
	
รหัสลูกค้าของคุณคือ ".$exp2[0].$arrayJson['source']['userId']."
คุณจะได้รับการแจ้งเตือนจากระบบโดยอัตโนมัติผ่านช่องทาง Line นี้
การตอบกลับ จะไม่สามารถทำได้ กรุณาตอบกลับที่ Line : @ydcargo
คุณสามารถลงทะเบียนใหม่อีกครั้ง โดยพิมพ์ code=[รหัสลูกค้าของคุณ]
สามารถลงทะเบียนใหม่ได้ตลอดเวลาหากต้องการเปลี่ยนโทรศัพท์หรือไลน์ไอดี
	
ขอบคุณค่ะ
YD-Cargo";
    replyMsg($arrayHeader,$arrayPostData);
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

function register($code, $uid) {
    $strUrl = "https://portal.yd-cargo.com/_api/submit_lineman?code=".$code."&uid=".$uid."&token=1qw23er45t@";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close ($ch);
}
exit;

?>
