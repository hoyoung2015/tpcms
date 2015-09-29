<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/24
 * Time: 15:21
 */
require 'autoload.php';
$APP_ID = 'wx350a0eb717f226f9';
$APP_SECRET = '42d60df83ab3016fe7ac69dbd8c55e63';
$media = new \Overtrue\Wechat\Media($APP_ID,$APP_SECRET);
//$list = $media->lists('image', 0 , 50);

$path = "E:/huyang/local/xampp/htdocs/wechat/Upload/files/image/u%3D2359924424%2C133058807%26fm%3D21%26gp%3D0.jpg";

$media->forever();
$type = 'image';
try{
    $media_id = call_user_func(array($media,$type),$path);
}catch (\Overtrue\Wechat\Exception $e){
    echo $e->getMessage();
}
var_dump($media_id);