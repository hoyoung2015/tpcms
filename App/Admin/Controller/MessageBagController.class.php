<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;

/**
 * 消息包控制器
 * Class MessageBagController
 * @package Admin\Controller
 */
class MessageBagController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(), $sort = 'create_time', $order = 'desc'){
        if(IS_POST){
            $db = M('msg_bag');
            $where = array();
            foreach ($search as $k=>$v){
                if(!$v) continue;
                $where[] = "`{$k}` like '%{$v}%'";
            }
            $where = implode(' and ', $where);
            $total = $db->where($where)->count();
            $order = $sort.' '.$order;
            $limit = ($page - 1) * $rows . "," . $rows;
            $list = $total ? $db->where($where)->order($order)->limit($limit)->select() : array();
            for($i=0;$i<count($list);$i++){
                $list[$i]['opt_id'] = $list[$i]['msg_bag_id'];
            }
            $data = array('total'=>$total, 'rows'=>$list);
            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function add(){
        if(IS_POST){
            $data = $_POST;
            //检查名称是否重复
            $m = M('msg_bag');
            $list = $m->where(array('name'=>$data['name']))->select();
            if(count($list)>0){
                $this->error('此消息包的名称已被占用');
            }
            $data['create_time'] = time();
            $data['msg_json'] = json_encode($data['msg_json']);
            if($m->add($data)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }
    }
    public function getMsgBag($id,$fields = array()){
        $data = M('msg_bag')->field(count($fields)>0?'*':$fields)->find($id);
        $this->ajaxReturn($data);
    }
    public function delete($ids){
        $m = M('msg_bag');
        $result = $m->where(array('msg_bag_id'=>array('IN',$ids)))->delete();
        if ($result){
            $this->success('删除成功');
        }else {
            $this->error('删除失败');
        }
    }
    public function edit($id){
        $m = M('msg_bag');
        if(IS_POST){
            $data = $_POST;

            $list = $m->where(array('name'=>$data['name']))->select();
            if(count($list)>0 && $list[0]['msg_bag_id']!=$id){
                $this->error('此消息包的名称已被占用');
            }
            $data['msg_json'] = json_encode($data['msg_json']);

            $m->save($data);
            $this->success('修改成功');
        }else{
            $info = $m->find($id);
            $this->assign('info', $info);
            $this->display();
        }
    }
    public function test(){
        $rs = M('msg_bag')->find();
        echo "<pre>";
        print_r($rs);
        print_r(json_decode($rs['msg_json']));
    }
}