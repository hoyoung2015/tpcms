<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;

/**
 * 后台用户相关模块
 * @author hoyoung
 */
class MessageTextController extends CommonController {

	public function index($page = 1, $rows = 10, $search = array(), $sort = 'create_time', $order = 'desc'){
		if(IS_POST){
            $data = D('MessageText')->search($page, $rows, $search, $sort, $order);

            $this->ajaxReturn($data);
		}else{
			$this->display();
		}
			
	}
	public function add(){
		if(IS_POST){
			$db = D('MessageText');
			$data = I('post.info');
            $msg = array(
                'name'=>$data['name'],
                'create_time'=>time(),
                'msg_type'=>'text',
                'msg_text'=>array(
                    'content'=>$data['content'],
                )
            );
			if($db->where(array('name'=>$data['name'],'msg_type'=>'text'))->field('id')->find()){
				$this->error('消息标题已经存在');
			}
			$id = $db->relation(true)->add($msg);
			if($id){
				$this->success('添加成功');
			}else {
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}
	}
	public function delete($ids){
        $db = D('MessageText');
		$result = $db->where(array('id'=>array('IN',$ids)))->relation(true)->delete();
		if ($result){
			$this->success('删除成功');
		}else {
			$this->error('删除失败');
		}
	}
	public function edit($id){
		$db = D('MessageText');
		if(IS_POST){
			$data = I('post.info');
            $msg = array(
                'id'=>$id,
                'name'=>$data['name'],
                'msg_text'=>array(
                    'base_id'=>$id,
                    'content'=>$data['content'],
                )
            );
			$result = $db->relation(true)->save($msg);
			if($result){
				$this->success('修改成功');
			}else {
				$this->error('修改失败');
			}
		}else{
			$info = $db->relation(true)->find($id);
			$this->assign('info', $info);
			$this->display();
		}
	}
}
