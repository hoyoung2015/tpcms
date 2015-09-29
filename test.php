<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/29
 * Time: 16:23
 */
class A{
    public function hello(){
        echo 'hello';
        return 100;
    }
}
$a = new A();

echo call_user_func(array($a,'hello'));