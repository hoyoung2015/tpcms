<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 14:03
 */

namespace Admin\Controller;

/**
 * 消息包控制器
 * Class MessageBagController
 * @package Admin\Controller
 */
class MessageBagController extends CommonController {
    public function index($page = 1, $rows = 10, $search = array(),$cat=array('type'=>1,'catid'=>0), $sort = 'create_time', $order = 'desc'){
        if(IS_POST){
            $db = M('msg_bag');
            $where = array('1=1');
            foreach ($search as $k=>$v){
                if(!$v) continue;
                $where[] = "`{$k}` like '%{$v}%'";
            }



            if(intval($cat['catid']) > 0){//分类
                $catIds = array($cat['catid']);
                D('Category')->getSelectCatId($catIds,$cat['catid'],$cat['type']);
                $where[] = ' cat_id in ('.join(',',$catIds).') ';
            }
            $where = implode(' and ', $where);

            $total = $db->where($where)->count();
            $order = ' order by '.$sort.' '.$order;
            $limit = ($page - 1) * $rows . "," . $rows;

            $sql = "select a.*,c.catname,a.msg_bag_id as opt_id from msg_bag a "
                ."left join category c on cat_id=c.catid "
                ."where ".$where.$order.' limit '.$limit;

//            echo $sql;

            $list = $total ? $db->query($sql) : array();
            $data = array('total'=>$total, 'rows'=>$list);
            $this->ajaxReturn($data);
        }else{
            $this->display();
        }
    }
    public function add(){
        if(IS_POST){
            $data = $_POST;
            //检查名称是否重复
            $m = M('msg_bag');
            $list = $m->where(array('name'=>$data['name']))->select();
            if(count($list)>0){
                $this->error('此消息包的名称已被占用');
            }
            $data['create_time'] = time();
            $data['msg_json'] = json_encode($data['msg_json']);
            if($m->add($data)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }
    }
    public function getMsgBag($id,$fields = array()){
        $data = M('msg_bag')->field(count($fields)>0?'*':$fields)->find($id);
        $this->ajaxReturn($data);
    }
    public function test2(){
        $ids = array('17');
        $cannot_del = $this->cannotDelBag($ids);
        echo '<pre>';
        print_r($cannot_del);
    }
    /**
     * 检查不能被删除的被消息池引用的消息包
     * 参数按引用传递，剔除不能删除的项
     * @param array $ids
     */
    protected function cannotDelBag(&$ids = array()){
        $msgPoolModel = M('msg_pool');
        $msgBagModel = M('msg_bag');
        //检查是否被消息包使用
        $cannot_del = array();
        foreach($ids as $index=>$id){
            $msgPools = $msgPoolModel->where(array(
                'msg_bag_json'=>array('like','%"msg_bag_id":"'.$id.'"%')
            ))->field('name')->select();
            if(count($msgPools)>0){//被消息包使用
                $msgBag = $msgBagModel->field('name')->find($id);
                $arr = array(
                    'msg_bag_id'=>$id,
                    'msg_bag_name'=>$msgBag['name']
                );
                $arr2 = array();
                foreach($msgPools as $msgPool){
                    $arr2[] = '<span style="font-weight: bold">'.$msgPool['name'].'</span>';
                }
                $arr['msg_pool_name'] = implode(',',$arr2);
                $cannot_del[] = $arr;

                unset($ids[$index]);//去除不能删除的
            }
        }
        return $cannot_del;
    }
    public function delete($ids){
        $cannot_del = $this->cannotDelBag($ids);
        $m = M('msg_bag');
        if(count($ids) > 0){//删除
            $result = $m->where(array('msg_bag_id'=>array('IN',$ids)))->delete();
        }
        $this->ajaxReturn(array(
            'cannotDel'=>$cannot_del
        ));
    }
    public function edit($id){
        $m = M('msg_bag');
        if(IS_POST){
            $data = $_POST;
//            $this->ajaxReturn($data);
            $list = $m->where(array(
                'name'=>$data['name'],
                'msg_bag_id'=>array('neq',$data['msg_bag_id'])
            ))->select();
            if(count($list)>0){
                $this->error('此消息包的名称已被占用');
            }
            $data['msg_json'] = json_encode($data['msg_json']);

            $m->save($data);
            $this->success('修改成功');
        }else{
            $info = $m->find($id);
            $this->assign('info', $info);
            $this->display();
        }
    }
    public function test(){
        $rs = M('msg_bag')->find();
        echo "<pre>";
        print_r($rs);
        print_r(json_decode($rs['msg_json']));
    }
}