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

    public function __construct()
    {
        $this->db = new medoo();
    }

    public function execute($input = array()){
        $target_pool = $this->matchAllPool($input);

        //组装消息
    }

    protected function matchAllPool($input){
        $this->p($input);
        $event = $input['event'];
        $param = $input['param'];

        $target_pool = null;

        $where = array(
            'AND'=>array(
                'fire_event'=>$event//触发条件
            )
        );

        switch($event){
            case 'click':
            case 'reply':
                $where['AND']['fire_event_param'] = $param;//触发条件的参数
                break;
        }

        $msg_pools = $this->db->select('msg_pool',array('name','rule_json'),$where);

        echo $this->db->last_query();
        echo "\n所有消息池>>>";
        $this->p($msg_pools);
        //逐个匹配消息包
        foreach($msg_pools as $msg_pool){
            if($this->matchOnePool($msg_pool,$input)){//匹配成功
                echo $msg_pool['name'].'通过了';
                $target_pool = $msg_pool;
                break;
            }
        }

        if($target_pool==null){

        }

        return $target_pool;
    }

    /**
     * @param $pool 一个消息池
     * @param $input 输入
     */
    protected function matchOnePool($pool,$input){

        $tag = $input['user_tag'];


        $rules = json_decode($pool['rule_json'],true);


        echo "\n所有规则>>>";
        print_r($rules);

        $pass_count = 0;

        //逐个验证条件
        foreach($rules as $rule){
            switch($rule['opt']){
                case 'EQ'://等于
                    if(!isset($tag[$rule['tag']])){//标签不存在，没必要比了
                        break;
                    }
                    if($tag[$rule['tag']]==$rule['val']){//符合条件
                        $pass_count++;
                    }
                    break;
                case 'NEQ'://不等于
                    if(!isset($tag[$rule['tag']])){//标签不存在，没必要比了
                        break;
                    }
                    if($tag[$rule['tag']] != $rule['val']){//符合条件
                        $pass_count++;
                    }
                    break;
                case 'IN'://在集合内
                    if(!isset($tag[$rule['tag']])){//标签不存在，没必要比了
                        break;
                    }

                    $collection = explode(',',$rule['val']);
                    if(in_array($tag[$rule['tag']],$collection)){
                        $pass_count++;
                    }
                    break;
                case 'BTW'://区间内
                    if(!isset($tag[$rule['tag']])){//标签不存在，没必要比了
                        break;
                    }
                    list($left,$right) = explode(',',$rule['val']);
                    $val = $tag[$rule['tag']];
                    if($val>=$left && $val<=$right){
                        $pass_count++;
                    }
                    break;
            }
        }

        return $pass_count==count($rules);
    }
    protected function p($arr){
        print_r($arr);
    }
}