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

$matcher = new \Overtrue\Wechat\MsgPool\MsgPoolMatcher();

//$matcher->execute($input);
$matcher->execute($input_subscribe);
