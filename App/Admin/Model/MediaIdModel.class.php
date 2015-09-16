<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 20:28
 */

namespace Admin\Model;


use Think\Model\RelationModel;

class MediaIdModel extends RelationModel{
    protected $tableName = 'media_id';

    protected $_link = array(
        'msg_base'=>array(
            'mapping_type'=>self::HAS_ONE,
            'foreign_key'=>'msg_id'
        )
    );
    public function search($page = 1, $rows = 10, $search = array(), $sort = 'id', $order = 'desc'){
        $arr = array();
        foreach ($search as $k=>$v){
            if(!$v) continue;
            $arr[] = "`{$k}` like '%{$v}%'";
        }
        $where = '';
        if(!empty($arr)){
            $where = ' and '.join(' and ',$arr);
        }
        $total = $this->where($arr)->count();//总数

        $order = ' order by '.$sort.' '.$order;
//        echo $rows;
        $limit = ($page - 1) * $rows . "," . $rows;

        $sql = 'select * from media_id a,msg_base b where a.msg_id=b.id'.$where.$order.' limit '.$limit;
//        echo $sql;
        $list =$total ? $this->query($sql):array();
        for($i=0;$i<count($list);$i++){
            $list[$i]['opt_id'] = $list[$i]['mid'];
        }
        return array(
            'total'=>$total,
            'rows'=>$list
        );
    }
}