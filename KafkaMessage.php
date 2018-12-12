<?php


require_once __DIR__ .'/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use RdKafka\Producer;

class KafkaMessage{

     const KAFKA_PARTITION = 0;
     const KAFKA_TOPIC = 'youtube';

     public function __construct($data)
     {
         $this->producer($data);
     }

    public function producer($data)
    {

         var_dump(php_ini_loaded_file());
         var_dump(get_loaded_extensions());
         die();

        $logger = new Logger('producer');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/data/logs/producer.log'));
        $logger->debug('Running producer...');
        $kafka = new Producer();

        $kafka->setLogLevel(LOG_DEBUG);
        $kafka->addBrokers('kafka');
        $topic = $kafka->newTopic(KAFKA_TOPIC);
        for ($i = 0; $i < count($data['videoId']); $i++) {
            $message = sprintf('Your video' . $data['title'] . 'has been saved into the database', $i);
            $logger->debug(sprintf('Producing: %s', $message));
            $topic->produce(KAFKA_PARTITION, 0, $message);
            $kafka->poll(0);
        }
        while ($kafka->getOutQLen() > 0) {
            $kafka->poll(0);
        }
    }
}

