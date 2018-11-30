<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 19/11/18
 * Time: 13:54
 */

require_once dirname(__FILE__).'/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


$connection = new AMQPStreamConnection('192.168.10.10', 5672, 'obinna', 'obinna');
$channel = $connection->channel();

$channel->queue_declare('message', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n\n";

$callback = function ($msg) {
    echo $msg->body, "\n";
};

$channel->basic_consume('message', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();