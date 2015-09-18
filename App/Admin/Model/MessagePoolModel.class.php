<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 20:28
 */

namespace Admin\Model;


use Think\Model\RelationModel;

class MessagePoolModel extends RelationModel{
    protected $tableName = 'msg_pool';

    protected $_link = array(
        'match_tag'=>array(
            'mapping_type'=>self::HAS_MANY,
            'foreign_key'=>'pool_id'
        )
    );
    public function search($page = 1, $rows = 10, $search = array(),$cat=array('type'=>1,'catid'=>0), $sort = 'pool_id', $order = 'asc'){
        $arr = array();
        foreach ($search as $k=>$v){
            if(!$v) continue;
            $arr[] = "`{$k}` like '%{$v}%'";
        }
        if(intval($cat['catid']) > 0){//分类
            $catIds = array($cat['catid']);
            D('Category')->getSelectCatId($catIds,$cat['catid'],$cat['type']);
            $where .= ' and cat_id in ('.join(',',$catIds).') ';

            $arr[] = 'cat_id in ('.join(',',$catIds).')';

        }
        $total = $this->where($arr)->count();//总数
        $order = $sort.' '.$order;
        $limit = ($page - 1) * $rows . "," . $rows;
        $list =$total ? $this->relation(true)->where($arr)->order($order)->limit($limit)->select():array();

        for($i=0;$i<count($list);$i++){
            $list[$i]['opt_id'] = $list[$i]['pool_id'];
        }
        return array(
            'total'=>$total,
            'rows'=>$list
        );
    }

}