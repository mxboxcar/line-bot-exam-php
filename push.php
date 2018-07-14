<?php


$accessToken = 'HlP3no0Tpsf0iIG3dSRJhCuIVUpUq6JivCtQI5pgSeiLPCuDW6xHpY9bR/Imi5DTsGtHdQGTCiYAsYvP1KgSD89uhvVhLqmlTefaoTtN22uiFI7AsnmVNua+ZIUhrCRZG4BSUO+Xo7AjLqBBOzWgPQdB04t89/1O/w1cDnyilFU=';
$content = file_get_contents('php://input');
$arrayJson = json_decode($content, true);
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";

$message = $arrayJson['events'][0]['message']['text'];

$id = $_GET['id'];

$arrayPostData['to'] = $id;
$arrayPostData['messages'][0]['type'] = "text";
$arrayPostData['messages'][0]['text'] = "ทดสอบส่งหาลูกค้า";
pushMsg($arrayHeader,$arrayPostData);

function pushMsg($arrayHeader,$arrayPostData){
  $strUrl = "https://api.line.me/v2/bot/message/push";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$strUrl);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close ($ch);
}
exit;
?>