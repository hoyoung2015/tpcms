<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/24
 * Time: 15:21
 */
require 'autoload.php';

$input = array(
    'event'=>'reply',
    'param'=>'测试',
    'user_tag'=>array(
        '学校'=>'西电'
    )
);
$input_subscribe = array(
    'event'=>'subscribe',
    'user_tag'=>array(
        '学校'=>'西电'
    )
);
$input_subscribe2 = array(
    'event'=>'subscribe',
    'user_tag'=>array(
        '学校'=>'西电'
    )
);
$input_subscribe3 = array(
    'event'=>'subscribe',
    'user_tag'=>array(
        '学校'=>'西电',
        '年龄'=>20
    )
);


$input_reply = array(
    'open_id'=>'hoyoung',
    'event'=>'reply',
    'param'=>'hello',
    'user_tag'=>array(
        '学校'=>'西电'
    )
);

$matcher = new \Overtrue\Wechat\MsgPool\MessagePoolMatcher();

//$matcher->execute($input);
$messages = $matcher->execute($input_reply);
print_r($messages);
