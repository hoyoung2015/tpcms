<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;


class MediaIdController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(), $sort = 'mid', $order = 'desc'){
        if(IS_POST){
            $db = M('media_id');
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
                $list[$i]['opt_id'] = $list[$i]['m_id'];
            }
            $data = array('total'=>$total, 'rows'=>$list);
            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function test(){
        echo strlen("RyLh0DD2e1pAhJihY7QlsFPFMfRcKNKCNZ-lMLQbIaiAFQpS2Rc4MitF7cwZZpFL");
    }
    public function test2(){
        echo $_SERVER['DOCUMENT_ROOT'].'<br>';
        echo SCRIPT_DIR;
//        echo strripos(SITE_DIR,SITE_PATH);
    }

    /**
     * 上传永久素材
     * @param $path
     */
    public function forever(){
        //从缓存中读取 access_tocken
        if(IS_POST){
            $source = $_POST;
            $media = new \Overtrue\Wechat\Media(C('APP_ID'),C('APP_SECRET'));
            $mediaId = null;
            $m = M('media_id');
            if($source['type']=='image'){
                $path = $_SERVER['DOCUMENT_ROOT'].$source['path'];
                $mediaId = $media->forever()->image($path);
                $mediaId['file_path'] = $source['path'];
                $mediaId['is_use'] = 1;
                $rs = $m->add(array(
                    'media_id'=>$mediaId['media_id'],
                    'created_at'=>time(),
                    'file_path'=>$source['path'],
                    'is_use'=>1,
                    'type'=>'image'
                ));
                if($rs){
                    $this->success('永久化成功');
                }else{
                    $this->error('永久化失败');
                }
            }
        }
    }
    public function add(){
        if(IS_POST){
            $data = I('post.info');
            $msg = array(
                'name'=>$data['name'],
                'create_time'=>time(),
                'msg_type'=>'image',
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