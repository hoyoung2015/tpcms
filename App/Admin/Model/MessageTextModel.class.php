<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 20:28
 */

namespace Admin\Model;


use Think\Model\RelationModel;

class MessageTextModel extends RelationModel{
    protected $tableName = 'msg_base';

    protected $_link = array(
        'msg_text'=>array(
            'mapping_type'=>self::HAS_ONE,
            'foreign_key'=>'base_id'
        )
    );
    public function search($page = 1, $rows = 10, $search = array(),$catid = 0, $sort = 'id', $order = 'asc'){
        $arr = array();
        foreach ($search as $k=>$v){
            if(!$v) continue;
            $arr[] = "`{$k}` like '%{$v}%'";
        }
        $where = '';
        if(!empty($arr)){
            $where = ' and '.join(' and ',$arr);
        }

        $sqlCount = 'select count(id) as total from msg_base a,msg_text b where a.id=b.base_id'.$where;

        $total = $this->query($sqlCount)[0]['total'];//总数
//print_r($total);
        $order = ' order by '.$sort.' '.$order;
//        echo $rows;
        $limit = ($page - 1) * $rows . "," . $rows;

        $sql = 'select * from msg_base a,msg_text b where a.id=b.base_id'.$where.$order.' limit '.$limit;
//        echo $sql;
        $list =$total ? $this->query($sql):array();
        for($i=0;$i<count($list);$i++){
            $list[$i]['opt_id'] = $list[$i]['id'];
        }
        return array(
            'total'=>$total,
            'rows'=>$list
        );
    }
}