<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;


class MessageImageController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(),$cat=array('type'=>1,'catid'=>0), $sort = 'create_time', $order = 'desc'){
        if(IS_POST){
            $data = D('MessageImage')->search($page, $rows, $search,$cat, $sort, $order);

            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function add(){
        if(IS_POST){
            $data = I('post.info');
            $msg = array(
                'name'=>$data['name'],
                'cat_id'=>$data['cat_id'],
                'create_time'=>time(),
                'msg_type'=>'image',
                'msg_image'=>array(
                    'image_url'=>urldecode($data['image_url']),//注意，kcfinder给的路径是真实路径经过了urlencode，这里要urldecode之后才能找到真实路径
                    'image_url_lt'=>urldecode(str_replace('files/','thumbs/files/',$data['image_url']))
                )
            );
            $id = D('MessageImage')->relation(true)->add($msg);
            if($id){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            //查找media_id剩余数量
            $mediaLeft = C('MAX_MID_NUM') - M('media_id')->where('is_use=1')->count();
            $this->assign('mediaIdLeft',$mediaLeft);
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
                'cat_id'=>$data['cat_id'],
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
    public function delete($ids){
        $cannot_del = $this->cannotDelMsg($ids);
        if(count($ids) > 0){//删除
            $db = D('MessageImage');
            $result = $db->where(array('id'=>array('IN',$ids)))->relation(true)->delete();
        }
        $this->ajaxReturn(array(
            'cannotDel'=>$cannot_del
        ));
    }
}