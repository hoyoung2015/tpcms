<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 20:28
 */

namespace Admin\Model;


use Think\Model\RelationModel;

class MessageImageModel extends RelationModel{
    protected $tableName = 'msg_base';

    protected $_link = array(
        'msg_image'=>array(
            'mapping_type'=>self::HAS_ONE,
            'foreign_key'=>'base_id'
        )
    );
    public function search($page = 1, $rows = 10, $search = array(), $sort = 'id', $order = 'asc'){
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

        $sql = 'select * from msg_base a,msg_image b where a.id=b.base_id'.$where.$order.' limit '.$limit;
//        echo $sql;
        $list =$total ? $this->query($sql):array();

        $m = M('media_id');

        for($i=0;$i<count($list);$i++){
            $list[$i]['opt_id'] = $list[$i]['id'];
            //查询是否为永久素材，按照绝对路径匹配
            $medias = $m->where(array('file_path'=>$list[$i]['image_url'],'is_use'=>1))->select();
            if(count($medias)>0){
                $list[$i]['media_id'] = $medias[0]['media_id'];
            }
        }
        return array(
            'total'=>$total,
            'rows'=>$list
        );
    }
}