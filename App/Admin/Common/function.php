<?php
/**
 * 扫描目录所有文件，并生成treegrid数据
 * @param string $path     目录
 * @param string $filter   过滤文件名
 * @return array
 */
function scan_dir($path, $filter = SITE_DIR) {
	$result = array();
	$path = realpath($path);

	$path = str_replace(array('/', '\\'), DS, $path);
	$filter = str_replace(array('/', '\\'), DS, $filter);

	$list = glob($path . DS . '*');

	foreach ($list as $key => $filename) {
		$result[$key]['path'] = str_replace($filter, '', $filename);
		$result[$key]['name'] = basename($filename);
		$result[$key]['mtime'] = date('Y-m-d H:i:s', filemtime($filename));

		if (is_dir($filename)) {
			$result[$key]['type'] = 'dir';
			$result[$key]['size'] = '-';
		} else {
			$result[$key]['type'] = 'file';
			$result[$key]['size'] = format_bytes(filesize($filename), ' ');
		}
	}
	return $result;
}

/**
 * 上传目录列表
 * @param string $path 目录名
 * @return array
 */
function file_list_upload($path){
	$config  = C('TMPL_PARSE_STRING');
	switch (strtoupper(C('FILE_UPLOAD_TYPE'))){
		case 'SAE':
			$path     = str_replace(DS, '/', rtrim($path, DS));
			$arr      = explode('/', ltrim($path, './'));
			$domain   = array_shift($arr);
			$filePath = implode('/', $arr);
			$s        = new SaeStorage();
			$list     = $s->getListByPath($domain, $filePath);
			$res  = array();
			while(isset($list['dirNum']) && $list['dirNum']){
				$list['dirNum']--;
				array_push($res, array(
					'type'  => 'dir',
					'name'  => $list['dirs'][$list['dirNum']]['name'],
					'path'  => ltrim($list['dirs'][$list['dirNum']]['fullName'], 'upload/'),
					'size'  => '-',
					'mtime' => '-',
					'url'   => '#',
				));
			}
			while(isset($list['fileNum']) && $list['fileNum']){
				$list['fileNum']--;
				array_push($res, array(
					'type'  => 'file',
					'name'  => $list['files'][$list['fileNum']]['Name'],
					'path'  => ltrim($list['files'][$list['fileNum']]['fullName'], 'upload/'),
					'size'  => format_bytes($list['files'][$list['fileNum']]['length'], ' '),
					'mtime' => date('Y-m-d H:i:s', $list['files'][$list['fileNum']]['uploadTime']),
					'url'   => ltrim($list['files'][$list['fileNum']]['fullName'], 'upload/'),
				));
			}
			return $res;
			break;

		case 'FTP':
			$storage = new \Common\Plugin\Ftp();
			$list    =  $storage->ls($path);
			foreach($list as &$item){
				$item['path'] = ltrim($item['path'], UPLOAD_PATH);
				$item['url']  = str_replace('\\', '/', $item['path']);
			}
			return $list;
			break;

		default:
			$path = realpath($path);
			$path = str_replace(array('/', '\\'), DS, $path);
			$list = glob($path . DS . '*');
			$res  = array();
			foreach ($list as $key => $filename) {
				array_push($res, array(
					'type'  => (is_dir($filename) ? 'dir' : 'file'),
					'name'  => basename($filename),
					'path'  => ltrim(str_replace(realpath(UPLOAD_PATH), '', $filename), DS),
					'size'  => format_bytes(filesize($filename), ' '),
					'mtime' => date('Y-m-d H:i:s', filemtime($filename)),
					'url'   => ltrim(str_replace(array(realpath(UPLOAD_PATH), '\\'), array('', '/'), $filename), '/'),
				));
			}
			return $res;
	}
}

/**
 * 生成UUID
 * @return string 返回UUID字符串
 */
function uuid() {
	$uuid = M()->query('SELECT UUID() AS uuid;');
	return $uuid[0]['uuid'];
}

/**
 * 生成弹出层上传链接
 * @param $callback
 * @param string $ext
 * @return string
 */
function url_upload($callback, $ext = 'jpg|jpeg|png|gif|bmp'){
	$query = array('callback'=>$callback, 'ext'=>$ext);
	$query['sign'] = sign($query);
	return U('Storage/public_dialog', $query);
}
function p($a){
    echo "<pre>";
    print_r($a);
}
function match_tag_show($match_tag=array()){
    $opt_name = '【'.C('OPT_OPTIONS')[$match_tag['opt']].'】';
    switch($match_tag['opt']){
        case 'EQ':
        case 'NEQ':
        case 'GT':
        case 'LT':
            return $opt_name.' '.$match_tag['val'];
            break;
        case 'BTW':
        case 'IN':
            return $opt_name.' ('.$match_tag['val'].')';
            break;
        default:
            return '不存在';
            break;
    }
}
/*
 *获得一个类型的全量树
 */
function getCacheTreeByType($type){
    $data = S('category_tree_'.$type);
    if($data === false){
        $data = D('Category')->getSelectTree(0,$type);
        $data = array(0=>array('id'=>0,'text'=>'全部','children'=>$data));
        S('category_tree_'.$type,$data);
    }
    return $data;
}

/**
 * 给定一个父节点id，获取该子树
 * @param $parentId
 */
function getCacheTreeNodeFromParentId(&$rs,$hole_cat_tree,$parentId = 0){
    foreach($hole_cat_tree as $cat){
        if($cat['id']==$parentId){
            $rs = $cat;
            return;
        }
        if(is_array($cat['children']) && count($cat['children'])>0){
            getCacheTreeNodeFromParentId($rs,$cat['children'],$parentId);
        }
    }
}

/**
 * 遍历该树的所有id
 * @param $rs
 * @param $tree
 */
function getAllIdFromTree(&$rs,$tree){
    $rs[] = $tree['id'];
    foreach($tree['children'] as $node){
        getAllIdFromTree($rs,$node);
    }
}
function getAllIdFromTreeOneStep($parentId,$type){
    $hole_tree = getCacheTreeByType($type);//获得该类的所有树
    $pTree = array();
    getCacheTreeNodeFromParentId($pTree,$hole_tree,$parentId);//获得子树
    $rs = array();
    getAllIdFromTree($rs,$pTree);
    return $rs;
}
