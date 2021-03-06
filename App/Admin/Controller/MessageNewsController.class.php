<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;


class MessageNewsController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(), $sort = 'create_time', $order = 'desc'){
        if(IS_POST){
            $data = D('MessageNews')->search($page, $rows, $search, $sort, $order);

            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function volist($page = 1, $rows = 10, $search = array(), $sort = 'create_time', $order = 'desc'){
        $this->ajaxReturn(D('MessageNews')->search($page, $rows, $search, $sort, $order));
    }
    public function add(){
        if(IS_POST){
            $data = I('post.info');
            $msg = array(
                'name'=>$data['name'],
                'create_time'=>time(),
                'msg_type'=>'news',
                'msg_news'=>array(
                    'title'=>$data['title'],
                    'intro'=>$data['intro'],
                    'content'=>$data['content'],
                    'jump_url'=>$data['jump_url'],
                    'cover'=>$data['cover']
                )
            );
            $id = D('MessageNews')->relation(true)->add($msg);
            if($id){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }
    }
    public function edit($id){
        $m = D('MessageNews');
        if(IS_POST){
            $data = I('post.info');
            $msg = array(
                'id'=>$id,
                'name'=>$data['name'],
                'msg_news'=>array(
                    'base_id'=>$id,
                    'title'=>$data['title'],
                    'intro'=>$data['intro'],
                    'content'=>$data['content'],
                    'jump_url'=>$data['jump_url'],
                    'cover'=>$data['cover']
                )
            );
            $rs = $m->relation(true)->save($msg);
            $this->success('修改成功');
        }else{
            $info = $m->relation(true)->find($id);
//            p($info);
            $this->assign('info', $info);
            $this->display();
        }
    }
    public function delete($ids){
        $db = D('MessageNews');
        $result = $db->where(array('id'=>array('IN',$ids)))->relation(true)->delete();
        if ($result){
            $this->success('删除成功');
        }else {
            $this->error('删除失败');
        }
    }
}