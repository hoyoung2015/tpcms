<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/21
 * Time: 14:18
 */
namespace Overtrue\Wechat\MsgPool;
class MsgPoolMatcher {
    protected $db;
    public function execute(){
        $db = new medoo();
    }
}