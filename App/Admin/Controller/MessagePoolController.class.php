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
    public function index($page = 1, $rows = 10, $search = array(), $sort = 'pool_id', $order = 'desc'){
        if(IS_POST){
            $data = D('MessagePool')->search($page, $rows, $search, $sort, $order);
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
            'value'=>'hello'
        );
        $this->ajaxReturn(array(
            'total'=>count($rows),
            'rows'=>$rows
        ));
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


            $data['rule_json'] = json_encode($data['rule_json']);
            $data['msg_bag_json'] = json_encode($data['msg_bag_json']);

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