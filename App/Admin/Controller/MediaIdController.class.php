<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;


class MediaIdController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(), $sort = 'mid', $order = 'asc'){
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
            $root = $_SERVER['DOCUMENT_ROOT'];
            foreach($list as &$item){
                //检查路径是否存在
                if(file_exists($root.$item['file_path'])){
                    $item['valid'] = 1;
                }else{
                    $item['valid'] = 0;
                }
            }
            $data = array('total'=>$total, 'rows'=>$list);
            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
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
            if(in_array($source['type'],array('image','video','voice'))){
                $path = $_SERVER['DOCUMENT_ROOT'].$source['path'];//绝对路径
                $media->forever();
                try{
                    $mediaId = call_user_func(array($media,$source['type']),$path);
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
                }catch (\Overtrue\Wechat\Exception $e){
                    $this->error($e->getMessage());
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
    //同步微信服务器的素材列表
    public function mediaLists(){
        $media = new \Overtrue\Wechat\Media(C('APP_ID'),C('APP_SECRET'));
        $media_types = array('video','image','voice');

        $db = M('media_id');
        $db->where('1')->delete();//清空
        $server_root = $_SERVER['DOCUMENT_ROOT'];

        foreach($media_types as $media_type){
            $offset = 0;
            $count = 20;
            do{
                $list = $media->lists($media_type, $offset , $count);
                foreach($list['item'] as $md){




                    $db->add(array(
                        'media_id'=>$md['media_id'],
                        'type'=>$media_type,
                        'is_use'=>1,
                        'created_at'=>$md['update_time'],
                        'file_path'=>str_replace($server_root,'',$md['name'])
                    ));
                }
                $offset += $count;
            }while($list['item_count']>0);
        }
        $res = array(
            'success'=>true,
            'info'=>'刷新完成'
        );
        $this->ajaxReturn($res);
    }//同步微信服务器的素材列表
    public function mediaLists_temp(){

        //判断已经调用的次数，此接口一天不能超过20次
        $lastTimes = S('MEDIA_LISTS_RESIDUE_DEGREE')===false;
        if($lastTimes===false){//剩余20次
            $lastTimes = C('MEDIA_LISTS_LIMIT');
        }
        if($lastTimes <= 0){
            $res = array(
                'success'=>false,
                'info'=>'该接口今日可调用次数已用完'
            );
            $this->ajaxReturn($res);
        }else{
            $expire = strtotime(date('Y-m-d', time())) + 24 * 60 * 60 - time();//计算有效期，到今日的24点
            $lastTimes--;
            S('MEDIA_LISTS_RESIDUE_DEGREE',$lastTimes,array('type'=>'file','expire'=>$expire));//放入缓存

            $media = new \Overtrue\Wechat\Media(C('APP_ID'),C('APP_SECRET'));
            $media_types = array('video','image','voice');

            $db = M('media_id');
            $db->where('1')->delete();//清空
            $server_root = $_SERVER['DOCUMENT_ROOT'];



            foreach($media_types as $media_type){
                $offset = 0;
                $count = 20;
                do{
                    $list = $media->lists($media_type, $offset , $count);
                    foreach($list['item'] as $md){
                        $db->add(array(
                            'media_id'=>$md['media_id'],
                            'type'=>$media_type,
                            'is_use'=>1,
                            'created_at'=>$md['update_time'],
                            'file_path'=>str_replace($server_root,'',$md['name'])
                        ));
                    }
                    $offset += $count;
                }while($list['item_count']>0);
            }
            $res = array(
                'success'=>true,
                'info'=>'刷新完成'
            );
            $this->ajaxReturn($res);
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
    public function delete($id){
        if(IS_POST){
            $media = new \Overtrue\Wechat\Media(C('APP_ID'),C('APP_SECRET'));

            $rs = array();

            try{
                $res = $media->delete($id);
                if($res['errcode']==0){
                    //删除本地
                    M('media_id')->where(array('media_id'=>$id))->delete();
                    $rs['info'] = '删除成功';
                    $rs['success'] = true;
                }else{
                    $rs['info'] = $res['errmsg'];
                    $rs['success'] = false;
                }
            }catch (\Overtrue\Wechat\Exception $e){
                $rs['success'] = false;
                $rs['info'] = $e->getMessage();
            }
            $this->ajaxReturn($rs);
        }
    }
}