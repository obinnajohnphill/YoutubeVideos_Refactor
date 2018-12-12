<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 05/12/18
 * Time: 13:28
 */


require_once __DIR__ . '/../KafkaMessage.php';

class Send{

    public function __construct($data)
    {
        new KafkaMessage($data);
    }

}