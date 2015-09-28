<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/21
 * Time: 14:18
 */
namespace Overtrue\Wechat\MsgPool;
class MessagePoolMatcher {
    protected $db;

    public function __construct()
    {
        $this->db = new medoo();
    }

    public function execute($input = array()){
        $target_pool = $this->matchAllPool($input);

        if($target_pool==null){
//            echo '没有配置全局消息';
            throw new \Exception('没有配置空消息');
        }else{
//            echo '目标消息池>>> '.$target_pool['name'];
        }
        //拿消息包
        $msgBagInPool = $this->matchMsgBag($input,$target_pool);

        //组装消息
        $msgBag = $this->db->get('msg_bag','*',array('msg_bag_id'=>$msgBagInPool['msg_bag_id']));

        $messages = $this->packageMsg($msgBag);

        return $messages;
    }

    /**
     * 组装消息
     * @param $msgBag
     */
    protected function packageMsg($msgBag){
        $messages = json_decode($msgBag['msg_json'],true);
        foreach($messages as &$msg){
            $interval = $msg['interval'];
            $list = $this->db->select('msg_base',array(
                '[]msg_'.$msg['msg_type']=>array('id'=>'base_id')
            ),'*',array('id'=>$msg['msg_id']));
            $msg = $list[0];
            $msg['interval'] = $this->getInterval($interval);
        }
        return $messages;
    }

    protected function matchMsgBag($input,$msgPool){

        $open_id = $input['open_id'];
        $msgBags = json_decode($msgPool['msg_bag_json'],true);

        $probArr = array();//组装概率数组
        foreach($msgBags as $msgBag){
            $probArr[] = $msgBag['prob'];
        }
        msg_bag_point:
        $index = $this->get_rand($probArr);//概率抽取

        //检查间隔时间限制
        $msgBag = $msgBags[$index];
        $interval = $this->getInterval($msgBag['interval']);

        $msg_bag_log = $this->db->select('msg_bag_log','*',array('AND'=>array('open_id'=>$open_id,'msg_bag_id'=>$msgBag['msg_bag_id'])));

        if($msg_bag_log && $interval > 0 && count($probArr)>1){//防止陷入死循环
            if(time()-$msg_bag_log['create_time']<$interval){//间隔时间还没到
                //移除这个消息包和概率数组
                unset($msgBags[$index]);
                unset($probArr[$index]);
                goto msg_bag_point;//重新抽取
            }
        }
        return $msgBags[$index];
    }

    protected function matchAllPool($input){
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

        //逐个匹配消息包
        foreach($msg_pools as $msg_pool){
            if($this->matchOnePool($msg_pool,$input)){//匹配成功
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

    /**
     * @param string $time 格'hh:mm:ss'
     * @return mixed
     */
    protected function getInterval($time = ''){
        $arr = explode(':',$time);
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

}