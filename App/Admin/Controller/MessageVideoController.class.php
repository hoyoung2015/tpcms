<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;


class MessageVideoController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(),$cat=array('type'=>1,'catid'=>0), $sort = 'create_time', $order = 'desc'){
        if(IS_POST){
            $data = D('MessageVideo')->search($page, $rows, $search,$cat, $sort, $order);

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
                'info'=>$data['info'],
                'create_time'=>time(),
                'msg_type'=>'video',
                'msg_video'=>array(
                    'file_path'=>$data['file_path'],
                    'singer'=>$data['singer'],
                    'album'=>$data['album'],
                )
            );
            $id = D('MessageVideo')->relation(true)->add($msg);
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
    public function upload(){
        if (!empty($_FILES)) {
            $rootPath = 'Upload';
            //图片上传设置
            $config = array(
                'maxSize'    =>    3145728,
                'rootPath'	 =>    $rootPath,
                'savePath'   =>    '/video/',
                'saveName'   =>    array('uniqid',''),
                'exts'       =>    array('mp4', ),
                'autoSub'    =>    false,
                'subName'    =>    array('date','Ymd'),
            );
            $upload = new \Think\Upload($config);// 实例化上传类
            $videos = $upload->upload();
            //判断是否有
            if($videos){
//                $info=$videos['Filedata']['savename'];
                $info=$videos['Filedata'];
                //返回文件地址和名给JS作回调用

                if(session('video_file') && file_exist(session('video_file'))){
                    //删除
                    file_delete(session('video_file'));
                }
                session('video_file',SITE_PATH.'/'.$rootPath.$info['savepath'].$info['savename']);
                $this->ajaxReturn(array(
                    'title'=>pathinfo($info['name'])['filename'],//原始名称
                    'file_path'=>SCRIPT_DIR.'/'.$rootPath.$info['savepath'].$info['savename']
                ));
            }
            else{
                $this->error($upload->getError());//获取失败信息
            }
        }
    }
    public function edit($id){
        $m = D('MessageVideo');
        if(IS_POST){
            $data = I('post.info');

            $video = M('msg_video')->find($id);

            $msg = array(
                'id'=>$id,
                'name'=>$data['name'],
                'info'=>$data['info'],
                'cat_id'=>$data['cat_id'],
                'msg_video'=>array(
                    'base_id'=>$id,
                    'file_path'=>$data['file_path'],
                    'singer'=>$data['singer'],
                    'album'=>$data['album'],
                )
            );
            $rs = $m->relation(true)->save($msg);
            if($video['file_path'] != $msg['msg_video']['file_path']){
                $file = $_SERVER['DOCUMENT_ROOT'].$video['file_path'];
                if(file_exist($file)){
                    file_delete($file);//删除原来的语音
                }
            }
            $this->success('修改成功');
        }else{
            $info = $m->relation(true)->find($id);
            $this->assign('info', $info);
            $this->display();
        }
    }
    public function view($id){
        $m = D('MessageVideo');
            $info = $m->relation(true)->find($id);
            $this->assign('info', $info);
            $this->display();
    }
    public function delete($ids){
        $cannot_del = $this->cannotDelMsg($ids);
        if(count($ids) > 0){//删除
            $db = D('MessageVideo');
            //删除语音文件
            $messages = $db->where(array('id'=>array('IN',$ids)))->relation(true)->select();
            $rootPath = $_SERVER['DOCUMENT_ROOT'];
            foreach($messages as $msg){
                file_delete($rootPath.$msg['msg_video']['file_path']);
            }
            $result = $db->where(array('id'=>array('IN',$ids)))->relation(true)->delete();
        }
        $this->ajaxReturn(array(
            'cannotDel'=>$cannot_del
        ));
    }
}