<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/24
 * Time: 15:21
 */
require 'autoload.php';
//$APP_ID = 'wx350a0eb717f226f9';
$APP_ID = 'wx769af7d3eebb889c';
//$APP_SECRET = '42d60df83ab3016fe7ac69dbd8c55e63';
$APP_SECRET = '5c4ace3f8d72647d782ec3df169f8b6e';
$media = new \Overtrue\Wechat\Media($APP_ID,$APP_SECRET);
//$list = $media->lists('image', 0 , 50);

$path = "E:/huyang/local/xampp/htdocs/wechat/Upload/files/image/u=3841157212,2135341815&fm=21&gp=0.jpg";

$media = $media->forever();
$type = 'image';
try{
    $media_id = call_user_func(array($media,$type),$path);
}catch (\Overtrue\Wechat\Exception $e){
    echo $e->getMessage();
}
var_dump($media_id);