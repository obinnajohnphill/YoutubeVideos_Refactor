<?php

const KAFKA_PARTITION = 0;
const KAFKA_TOPIC = 'youtube';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


require_once __DIR__ .'/vendor/autoload.php';

include_once "public/Send.php";

$call = new Send();
$payload = $call->sendMessage();

$logger = new Logger('producer');
$logger->pushHandler(new StreamHandler(__DIR__ . '/data/logs/producer.log'));
$logger->debug('Running producer...');

$kafka = new RdKafka\Producer();
$kafka->setLogLevel(LOG_DEBUG);
$kafka->addBrokers('kafka');

$topic = $kafka->newTopic(KAFKA_TOPIC);


for ($i = 0; $i < 10; $i++) {
    $message = sprintf(''.$payload.'%d', $i);
    $logger->debug(sprintf('Producing: %s', $message));
    $topic->produce(KAFKA_PARTITION, 0, $message);
    $kafka->poll(0);
}

while($kafka->getOutQLen() > 0) {
    $kafka->poll(0);
}
