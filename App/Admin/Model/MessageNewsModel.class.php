<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 20:28
 */

namespace Admin\Model;


use Think\Model\RelationModel;

class MessageNewsModel extends RelationModel{
    protected $tableName = 'msg_base';

    protected $_link = array(
        'msg_news'=>array(
            'mapping_type'=>self::HAS_ONE,
            'foreign_key'=>'base_id'
        )
    );
    public function search($page = 1, $rows = 10, $search = array(),$cat=array('type'=>1,'catid'=>0), $sort = 'id', $order = 'asc'){
        $arr = array();
        foreach ($search as $k=>$v){
            if(!$v) continue;
            $arr[] = "`{$k}` like '%{$v}%'";
        }
        $where = '';
        if(!empty($arr)){
            $where = ' and '.join(' and ',$arr);
        }

        if(intval($cat['catid']) > 0){//分类
            $catIds = getAllIdFromTreeOneStep($cat['catid'],$cat['type']);
            $where .= ' and cat_id in ('.join(',',$catIds).') ';
        }

        $sqlCount = 'select count(id) as total from msg_base a,msg_news b where a.id=b.base_id'.$where;

        $total = $this->query($sqlCount)[0]['total'];//总数
        $order = ' order by '.$sort.' '.$order;
        $limit = ($page - 1) * $rows . "," . $rows;

        $sql = "select a.*,b.*,c.catname,a.id as opt_id from msg_base a "
            ."left join msg_news b on a.id=b.base_id "
            ."left join category c on cat_id=c.catid "
            ."where a.msg_type='news' ".$where.$order.' limit '.$limit;
//        echo $sql;
        $list =$total ? $this->query($sql):array();
        return array(
            'total'=>$total,
            'rows'=>$list
        );
    }
}