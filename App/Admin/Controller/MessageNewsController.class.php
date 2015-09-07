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

            $m = M('news_item');
            for($i=0;$i<count($data['rows']);$i++){
                $id = explode(',',$data['rows'][$i]['item_ids'])[0];
                $data['rows'][$i]['cover'] = $m->find($id)['cover'];
            }

            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function itemList($page = 1, $rows = 10, $search = array(), $sort = 'create_time', $order = 'desc'){
        if(IS_POST){
            //搜索
            $where = array();
            foreach ($search as $k=>$v){
                if(!$v) continue;
                $where[] = "`{$k}` like '%{$v}%'";
            }
            $where = implode(' and ', $where);
            $db = M('news_item');
            $total = $db->where($where)->count();
            $order = $sort.' '.$order;
            $limit = ($page - 1) * $rows . "," . $rows;
            $list = $total ? $db->where($where)->order($order)->limit($limit)->select() : array();
            for($i=0;$i<count($list);$i++){
                $list[$i]['opt_id'] = $list[$i]['news_item_id'];
            }
            $data = array('total'=>$total, 'rows'=>$list);
            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function itemAdd(){
        if(IS_POST){
            $data = I('post.info');
            $data['create_time'] = time();
            $id = M('news_item')->add($data);
            if($id){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }
    }
    public function itemDelete($ids){
        $result = M('news_item')->where(array('news_item_id'=>array('IN',$ids)))->delete();
        if ($result){
            $this->success('删除成功');
        }else {
            $this->error('删除失败');
        }
    }
    public function add(){
        if(IS_POST){
            $data = I('post.info');
            $msg = array(
                'name'=>$data['name'],
                'create_time'=>time(),
                'msg_type'=>'news',
                'msg_news'=>array(
                    'item_ids'=>$data['item_ids']
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
                'id'=>$data['id'],
                'name'=>$data['name'],
                'msg_news'=>array(
                    'base_id'=>$data['id'],
                    'item_ids'=>$data['item_ids']
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
    public function find($ids){

    }
    public function itemEdit($id){
        $m = M('news_item');
        if(IS_POST){
            $data = I('post.info');
            $data['news_item_id'] = $id;
            $rs = $m->save($data);
            $this->success('修改成功');
        }else{

            $info = $m->find($id);
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
    public function findNewsItem($ids){
        $m = M('news_item');
        $list = array();
        foreach($ids as $val){
            $list[] = $m->find($val);
        }
        $this->ajaxReturn($list);
    }
}