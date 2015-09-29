<?php
/**
 * Created by PhpStorm.
 * User: hoyoung
 * Date: 2015/9/3
 * Time: 20:28
 */

namespace Admin\Model;


use Think\Model\RelationModel;

class MessageMusicModel extends RelationModel{
    protected $tableName = 'msg_base';

    protected $_link = array(
        'msg_music'=>array(
            'mapping_type'=>self::HAS_ONE,
            'foreign_key'=>'base_id'
        )
    );
    public function search($page = 1, $rows = 10, $search = array(), $cat=array('type'=>1,'catid'=>0), $sort = 'id', $order = 'asc'){
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
            $arr[] = 'cat_id in ('.join(',',$catIds).')';
        }
        $arr[] = "msg_type='music'";
        $total = $this->where($arr)->count();//总数

        $order = ' order by '.$sort.' '.$order;
//        echo $rows;
        $limit = ($page - 1) * $rows . "," . $rows;


        $sql = "select a.*,b.*,c.catname,a.id as opt_id from msg_base a "
            ."left join msg_music b on a.id=b.base_id "
            ."left join category c on cat_id=c.catid "
            ."where a.msg_type='music' ".$where.$order.' limit '.$limit;
//        echo $sql;
        $list =$total ? $this->query($sql):array();

        $m = M('media_id');

        for($i=0;$i<count($list);$i++){
            //查询是否为永久素材，按照绝对路径匹配
            $medias = $m->where(array('file_path'=>$list[$i]['file_path'],'is_use'=>1))->select();
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