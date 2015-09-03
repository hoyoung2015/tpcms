<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;


class MessageImageController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(), $sort = 'create_time', $order = 'desc'){
        if(IS_POST){
            $data = D('MessageImage')->search($page, $rows, $search, $sort, $order);

            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function volist($page = 1, $rows = 10, $search = array(), $sort = 'create_time', $order = 'desc'){
        $this->ajaxReturn(D('MessageImage')->search($page, $rows, $search, $sort, $order));
    }
    public function add(){
        if(IS_POST){
            $data = I('post.info');
            $msg = array(
                'name'=>$data['name'],
                'create_time'=>time(),
                'msg_image'=>array(
                    'image_url'=>$data['image_url'],
                    'image_url_lt'=>str_replace('files/','thumbs/files/',$data['image_url'])
                )
            );
            $id = D('MessageImage')->relation(true)->add($msg);
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
        $m = D('MessageImage');
        if(IS_POST){
            $data = I('post.info');
            $msg = array(
                'id'=>$data['id'],
                'name'=>$data['name'],
                'msg_image'=>array(
                    'base_id'=>$data['id'],
                    'image_url'=>$data['image_url'],
                    'image_url_lt'=>str_replace('files/','thumbs/files/',$data['image_url'])
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
}