<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/11
 * Time: 17:31
 */
namespace Admin\Controller;
use Admin\Controller\CommonController;
class MessagePoolController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(),$cat=array('type'=>1,'catid'=>0), $sort = 'pool_id', $order = 'desc'){
        if(IS_POST){
            $db = M('msg_pool');
            $where = array('1=1');
            foreach ($search as $k=>$v){
                if(!$v) continue;
                $where[] = "`{$k}` like '%{$v}%'";
            }
            if(intval($cat['catid']) > 0){//分类
                $catIds = array($cat['catid']);
                D('Category')->getSelectCatId($catIds,$cat['catid'],$cat['type']);
                $where[] = ' cat_id in ('.join(',',$catIds).') ';
            }
            $where = implode(' and ', $where);

            $total = $db->where($where)->count();
            $order = ' order by '.$sort.' '.$order;
            $limit = ($page - 1) * $rows . "," . $rows;

            $sql = "select a.*,c.catname,a.pool_id as opt_id from msg_pool a "
                ."left join category c on cat_id=c.catid "
                ."where ".$where.$order.' limit '.$limit;
//            echo $sql;
            $list = $total ? $db->query($sql) : array();
            $data = array('total'=>$total, 'rows'=>$list);
            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }

    /**
     * 规则详情
     */
    public function ruleDetail($id){
        $msg_pool = M('msg_pool')->find($id);
        $rows = array();
        $rows[] = array(
            'group'=>'系统规则',
            'name'=>'触发条件',
            'value'=>C('FIRE_EVENT')[$msg_pool['fire_event']]
        );
        $match_tags = json_decode($msg_pool['rule_json'],true);
        foreach($match_tags as $match_tag){
            $rows[] = array(
                'group'=>'自定义标签',
                'name'=>$match_tag['tag'],
                'value'=>match_tag_show($match_tag)
            );
        }
        $this->assign('data',json_encode($rows));
        $this->display();
    }
    public function optOptions(){
        $opts = C('OPT_OPTIONS');
        $arr = array();
        foreach($opts as $key=>$val){
            $arr[] = array(
                'opt'=>$key,
                'opt_name'=>$val
            );
        }
        $this->ajaxReturn($arr);
    }
    public function fireEvents(){
        $events = C('FIRE_EVENT');
        $arr = array();
        foreach($events as $key=>$val){
            $arr[] = array(
                'event'=>$key,
                'name'=>$val
            );
        }
        $this->ajaxReturn($arr);
    }
    public function edit($id){
        $m = M('msg_pool');
        if(IS_POST){
            //检查是否重名
            $data = $_POST;
            $list = $m->where(array('name'=>$data['name']))->select();
            if(count($list)>0 && strval($list[0]['pool_id']) != $data['pool_id']){
                $this->error('消息池的名称已存在');
            }
            if(!isset($data['rule_json'])){
                $data['rule_json'] = array();
            }

            //设置规则数量，用于匹配的时候先从数量大的匹配
            $data['tag_count'] = count($data['rule_json']);

            $data['rule_json'] = json_encode($data['rule_json']);
            $data['msg_bag_json'] = json_encode($data['msg_bag_json']);
            $rs = $m->save($data);
            if($rs !== false){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            $info = $m->find($id);
            $this->assign('info', $info);
            $this->display();
        }
    }

    public function add(){
        if(IS_POST){
            $data = $_POST;
            //检查名称是否重复
            $m = M('msg_pool');
            $list = $m->where(array('name'=>$data['name']))->select();
            if(count($list)>0){
                $this->error('此消息池的名称已被占用');
            }
            $data['create_time'] = time();


            if(!isset($data['rule_json'])){
                $data['rule_json'] = array();
            }

            //设置规则数量，用于匹配的时候先从数量大的匹配
            $data['tag_count'] = count($data['rule_json']);

            $data['rule_json'] = json_encode($data['rule_json']);
            $data['msg_bag_json'] = json_encode($data['msg_bag_json']);

//            $this->ajaxReturn($data);

            $rs = $m->add($data);
            if($rs){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }
    }
    public function delete($ids){
        $m = M('msg_pool');
        $result = $m->where(array('pool_id'=>array('IN',$ids)))->delete();
        if ($result){
            $this->success('删除成功');
        }else {
            $this->error('删除失败');
        }
    }
    public function addRule(){
        if(IS_POST){

        }else{
            $this->display();
        }
    }
    public function addMsgBag(){
        if(IS_POST){

        }else{
            $this->display();
        }
    }
}