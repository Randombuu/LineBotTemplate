<?php // callback.php
define("LINE_MESSAGING_API_CHANNEL_SECRET", 'cf55387297af42a0ef6fdfc1cd9a9ce7');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'jE1idZ5yweINNtsGtdq5MN6d67ULJG/hrnfDKsSvRv9cMA+Wkem71wIVNUUy1cNSpOLl1R/HxNNCW4IbsTRoiq/Nh7SdLTVBRW3QJ5HFclV5TlEfuqhX0yhQMhOUkjVjLhI8Y8M9TmholkYMHXTC8wdB04t89/1O/w1cDnyilFU=');

require __DIR__."/../vendor/autoload.php";

$bot = new \LINE\LINEBot(
    new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN),
    ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]
);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

$events = $bot->parseEventRequest($body, $signature);

foreach ($events as $event) {
    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
        $text = $event->getText();
        $bot->replyText($reply_token, $text);
    }
}

echo "OK";
