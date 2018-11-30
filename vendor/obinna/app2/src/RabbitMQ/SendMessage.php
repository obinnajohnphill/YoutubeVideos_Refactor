<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 19/11/18
 * Time: 17:48
 */

namespace Obinna\RabbitMQ;

$directory = chop($_SERVER["DOCUMENT_ROOT"],'public');
require_once ("$directory./vendor/autoload.php");

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Dotenv;

class SendMessage
{
    public function __construct()
    {
      $this->receive();
    }

    public function receive(){

        $directory = chop($_SERVER["DOCUMENT_ROOT"],'public');
        $dotenv = new Dotenv\Dotenv($directory.'/');
        $dotenv->load();

        $connection = new AMQPStreamConnection($_ENV['RabbitMQ_Host'], $_ENV['RabbitMQ_Port'], $_ENV['RabbitMQ_Username'], $_ENV['RabbitMQ_Password']);
        $channel = $connection->channel();

        $channel->queue_declare('message', false, false, false, false);

        $msg = new AMQPMessage('Awesome, your videos successfully saved!');
        $channel->basic_publish($msg, '', 'message');
        $channel->close();
        $connection->close();
    }

}