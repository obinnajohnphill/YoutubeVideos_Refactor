<?php


require_once __DIR__ .'/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use RdKafka\Producer;

class KafkaMessage{

     public $kafka_partition = 0;
     public $kafka_topic = 'youtube';

     public function __construct($data)
     {
         $this->producer($data);
     }

    public function producer($data)
    {
        $logger = new Logger('producer');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/data/logs/producer.log'));
        $logger->debug('Running producer...');
        $kafka = new Producer();

        $logger->debug(json_encode($data));

        $kafka->setLogLevel(LOG_DEBUG);
        $kafka->addBrokers('172.23.0.4:9092');
        $topic = $kafka->newTopic($this->kafka_topic);
        for ($i = 0; $i < count($data['videoId']); $i++) {
            $message = sprintf('Your video' . $data['title'][$i] . ' has been saved into the database', $i);
            $logger->debug(sprintf('Producing: %s', $message));
            $topic->produce($this->kafka_partition , 0, $message);
            $logger->debug(sprintf('Produced: %s', $message));
        }
    }
}

