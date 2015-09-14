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
    public function index($page = 1, $rows = 10, $search = array(), $sort = 'pool_id', $order = 'asc'){
        if(IS_POST){
            $data = D('MessagePool')->search($page = 1, $rows = 10, $search = array(), $sort = 'pool_id', $order = 'asc');
            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function add(){
        if(IS_POST){
            $data = I('post.info');

            //检查名称是否重复
            $m = M('msg_bag');
            $list = $m->where(array('name'=>$data['name']))->select();
            if(count($list)>0){
                $this->error('此消息包的名称已被占用');
            }
            $data['create_time'] = time();
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
    public function addRule(){
        if(IS_POST){

        }else{
            $this->display();
        }
    }
}