<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Tests\\' => array($vendorDir . '/superbalist/php-pubsub/tests', $vendorDir . '/superbalist/php-pubsub-kafka/tests'),
    'Superbalist\\PubSub\\Kafka\\' => array($vendorDir . '/superbalist/php-pubsub-kafka/src'),
    'Superbalist\\PubSub\\' => array($vendorDir . '/superbalist/php-pubsub/src'),
    'PhpAmqpLib\\' => array($vendorDir . '/php-amqplib/php-amqplib/PhpAmqpLib'),
    'Obinna\\' => array($vendorDir . '/obinna/app2/src'),
    'Dotenv\\' => array($vendorDir . '/vlucas/phpdotenv/src'),
);
