<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;


class MessageVoiceController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(),$cat=array('type'=>1,'catid'=>0), $sort = 'create_time', $order = 'desc'){
        if(IS_POST){
            $data = D('MessageVoice')->search($page, $rows, $search,$cat, $sort, $order);

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
                'msg_type'=>'voice',
                'msg_voice'=>array(
                    'file_path'=>$data['file_path'],
                )
            );
            $id = D('MessageVoice')->relation(true)->add($msg);
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
                'savePath'   =>    '/voice/',
                'saveName'   =>    array('uniqid',''),
                'exts'       =>    array('mp3', 'wma', 'wav', 'amr'),
                'autoSub'    =>    false,
                'subName'    =>    array('date','Ymd'),
            );
            $upload = new \Think\Upload($config);// 实例化上传类
            $voices = $upload->upload();
            //判断是否有
            if($voices){
//                $info=$voices['Filedata']['savename'];
                $info=$voices['Filedata'];
                //返回文件地址和名给JS作回调用

                if(session('voice_file') && file_exist(session('voice_file'))){
                    //删除
                    file_delete(session('voice_file'));
                }
                session('voice_file',SITE_PATH.'/'.$rootPath.$info['savepath'].$info['savename']);
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
        $m = D('MessageVoice');
        if(IS_POST){
            $data = I('post.info');

            $voice = M('msg_voice')->find($id);

            $msg = array(
                'id'=>$id,
                'name'=>$data['name'],
                'info'=>$data['info'],
                'cat_id'=>$data['cat_id'],
                'msg_voice'=>array(
                    'base_id'=>$id,
                    'file_path'=>$data['file_path']
                )
            );
            $rs = $m->relation(true)->save($msg);
            if($voice['file_path'] != $msg['msg_voice']['file_path']){
                $file = $_SERVER['DOCUMENT_ROOT'].$voice['file_path'];
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
        $m = D('MessageVoice');
            $info = $m->relation(true)->find($id);
            $this->assign('info', $info);
            $this->display();
    }
    public function delete($ids){
        $cannot_del = $this->cannotDelMsg($ids);
        if(count($ids) > 0){//删除
            $db = D('MessageVoice');
            //删除语音文件
            $messages = $db->where(array('id'=>array('IN',$ids)))->relation(true)->select();
            $rootPath = $_SERVER['DOCUMENT_ROOT'];
            foreach($messages as $msg){
                file_delete($rootPath.$msg['msg_voice']['file_path']);
            }
            $result = $db->where(array('id'=>array('IN',$ids)))->relation(true)->delete();
        }
        $this->ajaxReturn(array(
            'cannotDel'=>$cannot_del
        ));
    }
}