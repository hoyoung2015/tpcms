<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;

/**
 * 后台用户相关模块
 * @author hoyoung
 */
class MessageTextController extends CommonController {

	public function textlist($page = 1, $rows = 10, $search = array(), $sort = 'create_time', $order = 'desc'){
		if(IS_POST){
			$db      = M('msg_text');
			//搜索
			$where = array();
			foreach ($search as $k=>$v){
				if(!$v) continue;
				$where[] = "`{$k}` like '%{$v}%'";
			}
			$total = $db->where($where)->count();
			$order = $sort.' '.$order;
			$limit = ($page - 1) * $rows . "," . $rows;
			$list = $total ? $db->where($where)->order($order)->limit($limit)->select() : array();
			for($i=0;$i<count($list);$i++){
				$list[$i]['opt_id'] = $list[$i]['id'];
			}
			// die($list.getLastSql());
			$data = array('total'=>$total, 'rows'=>$list);
			$this->ajaxReturn($data);
		}else{
			$datagrid = array(
				'options'     => array(
					'name'   => $currentpos,
					'url'     => U('MessageText/textlist', array('grid'=>'datagrid')),
					'toolbar' => '#msgtext-datagrid-toolbar',
				),
				'fields' => array(
					'复选框'      => array('field'=>'id','checkbox'=>true),
					'名称'      => array('field'=>'name','width'=>20,'sortable'=>true),
					'内容'        => array('field'=>'content','width'=>50,'sortable'=>true),
					'录入时间'      => array('field'=>'create_time','width'=>15,'sortable'=>true,'formatter'=>'msgTextListModule.time'),
					'管理操作'      => array('field'=>'opt_id','width'=>15,'formatter'=>'msgTextListModule.operate'),
				)
			);
			$this->assign('datagrid', $datagrid);
			$this->display();
		}
			
	}
	public function textadd(){
		if(IS_POST){
			$db = M('msg_text');
			$data = I('post.info');
			if($db->where(array('name'=>$data['name']))->field('name')->find()){
				$this->error('消息标题已经存在');
			}
			$data['create_time'] = time();
			$id = $db->add($data);
			if($id){
				$this->success('添加成功');
			}else {
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}
	}
	public function msgdelete($ids){
		$db = M('msg_text');
		$result = $db->where(array('id'=>array('IN',$ids)))->delete();
		if ($result){
			$this->success('删除成功');
		}else {
			$this->error('删除失败');
		}
	}
	public function edit($id){
		$db = M('msg_text');
		if(IS_POST){
			$data = I('post.info');
			$result = $db->where(array('id'=>$id))->save($data);
			if($result){
				$this->success('修改成功');
			}else {
				$this->error('修改失败');
			}
		}else{
			$info = $db->where(array('id'=>$id))->find();
			$this->assign('info', $info);
			$this->display();
		}
	}
}
