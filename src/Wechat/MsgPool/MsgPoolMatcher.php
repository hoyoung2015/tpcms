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

        if($target_pool==null){
            echo '没有配置全局消息';
        }else{
            print_r($target_pool);
            echo '目标消息池>>> '.$target_pool['name'];
        }
        //拿消息包
        $msgBag = $this->matchMsgBag($target_pool);

    }

    protected function matchMsgBag($msgPool){

        $msgBags = json_decode($msgPool['msg_bag_json'],true);

        $probArr = array();
        foreach($msgBags as $msgBag){
            $probArr[] = $msgBag['prob'];
        }
        $index = $this->get_rand($probArr);

        echo '消息包索引>>> '.$index;
        //检查间隔时间限制
        $msgBag = $msgBags[$index];
        $interval = $this->getInterval($msgBag['interval']);

        return $msgBags[$index];
    }

    protected function matchAllPool($input){
        $this->p($input);
        $event = $input['event'];
        $param = isset($input['param'])?$input['param']:'';

        $target_pool = null;

        $where = array(
            'AND'=>array(
                'fire_event'=>$event//触发条件
            ),
            'ORDER'=>'tag_count DESC'
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
//            echo '查找缺省消息';
            $pools = $this->db->select('msg_pool',array('name','msg_bag_json'),array('fire_event'=>'none'));
            if(count($pools) > 0){
                $target_pool = $pools[0];
            }
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
                case 'GT'://大于
                    if(!isset($tag[$rule['tag']])){//标签不存在，没必要比了
                        break;
                    }
                    if($tag[$rule['tag']] > $rule['val']){//符合条件
                        $pass_count++;
                    }
                    break;
                case 'LT'://小于
                    if(!isset($tag[$rule['tag']])){//标签不存在，没必要比了
                        break;
                    }
                    if($tag[$rule['tag']] < $rule['val']){//符合条件
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
                case 'NOT_IN'://在集合外
                    if(!isset($tag[$rule['tag']])){//标签不存在，没必要比了
                        break;
                    }

                    $collection = explode(',',$rule['val']);
                    if(!in_array($tag[$rule['tag']],$collection)){
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
                case 'NOT_BTW'://区间外
                    if(!isset($tag[$rule['tag']])){//标签不存在，没必要比了
                        break;
                    }
                    list($left,$right) = explode(',',$rule['val']);
                    $val = $tag[$rule['tag']];
                    if($val<left || $val>$right){
                        $pass_count++;
                    }
                    break;
            }
        }

        return $pass_count==count($rules);
    }
    protected function getInterval($time = ''){
        $arr = explode(',',$time);
        $total = 0;
        foreach($arr as &$k){
            $k = intval($k);
        }
        list($h,$m,$s) = $arr;
        return $h*60*60 + $m*60 + $s;
    }

    /**
     * 概率抽取
     * @param $proArr
     * @return int|string
     */
    protected function get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);             //抽取随机数
            if ($randNum <= $proCur) {
                $result = $key;                         //得出结果
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }
    protected function p($arr){
        print_r($arr);
    }

}