<?php
/**
 * 内容管理中的编辑页面表单元素
 */
return array(
	/* 类型 */
	'type'  => array( 1 => '消息素材', 2 => '消息包',3=>'消息池'),

	/* 字段 TODO 键值与模型对应 */
	'field' => array(
		/* 页面  */
		'page' => array(
			'title'       => array(
				'name'      => '标题',
				'group'     => '基本属性',
				'editor'    => array('type'=>'text','options'=>array('tipPosition'=>'left', 'validType'=>array('length'=>array(3,8)), 'required' => true )),
				'required' => true,
			),
			'keywords'    => array(
				'name'      => '关键字',
				'group'     => '基本属性',
				'editor'    => array('type'=>'validatebox','options'=>array('tipPosition'=>'left', 'validType'=>array('length'=>array(0,255)) )),
			),
			'description' => array(
				'name'      => '描述',
				'group'     => '基本属性',
				'editor'    => array('type'=>'textarea','options'=>array('tipPosition'=>'left', 'validType'=>array('length'=>array(5,255)) )),
			),
			'status'      => array(
				'name'     => '状态',
				'group'    => '发布设置',
				'editor'   => array('type'=>'checkbox','options'=>array('on'=>'发布','off'=>'不发布')),
				'default'  => '发布',
			),
		),
	)
);