<?php



require "vendor/autoload.php";

$access_token = 'HlP3no0Tpsf0iIG3dSRJhCuIVUpUq6JivCtQI5pgSeiLPCuDW6xHpY9bR/Imi5DTsGtHdQGTCiYAsYvP1KgSD89uhvVhLqmlTefaoTtN22uiFI7AsnmVNua+ZIUhrCRZG4BSUO+Xo7AjLqBBOzWgPQdB04t89/1O/w1cDnyilFU=';

$channelSecret = '5d548468496ea6601a7f479bba33d510';

$pushID = 'Uf6ac41a7495231ae65cc949fa61aa581';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello world');
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();







