<?php if (!defined('THINK_PATH')) exit();?>
<table id="member_typelist_datagrid" class="easyui-datagrid" data-options='<?php $dataOptions = array_merge(array ( 'border' => false, 'fit' => true, 'fitColumns' => true, 'rownumbers' => true, 'singleSelect' => true, 'striped' => true, 'pagination' => true, 'pageList' => array ( 0 => 20, 1 => 30, 2 => 50, 3 => 80, 4 => 100, ), 'pageSize' => '20', ), $datagrid["options"]);if(isset($dataOptions['toolbar']) && substr($dataOptions['toolbar'],0,1) != '#'): unset($dataOptions['toolbar']); endif; echo trim(json_encode($dataOptions), '{}[]').((isset($datagrid["options"]['toolbar']) && substr($datagrid["options"]['toolbar'],0,1) != '#')?',"toolbar":'.$datagrid["options"]['toolbar']:null); ?>' style=""><thead><tr><?php if(is_array($datagrid["fields"])):foreach ($datagrid["fields"] as $key=>$arr):if(isset($arr['formatter'])):unset($arr['formatter']);endif;echo "<th data-options='".trim(json_encode($arr), '{}[]').(isset($datagrid["fields"][$key]['formatter'])?",\"formatter\":".$datagrid["fields"][$key]['formatter']:null)."'>".$key."</th>";endforeach;endif; ?></tr></thead></table>

<script type="text/javascript">
var memberTypeModule = {
	dialog:   '#globel-dialog-div',
	datagrid: '#member_typelist_datagrid',
	
	//工具栏
	toolbar: [
		{ text: '添加分类', iconCls: 'icons-table-table_add', handler: function(){memberTypeModule.add();} },
		{ text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){memberTypeModule.refresh();} },
		{ text: '排序', iconCls: 'icons-table-table_sort', handler: function(){memberTypeModule.order();} }
	],
	
	//排序格式化
	sort: function(val, arr){
		return '<input class="sort-input" type="text" name="order['+arr['typeid']+']" value="'+val+'" size="2" style="text-align:center" />';
	},
	
	//状态格式化
	state: function(val){
		return val == 1 ? '<font color="red">未启用</font>' : '已启用';
	},
	
	//操作格式化
	operate: function(val){
		var btn = [];
		btn.push('<a href="javascript:void(0);" onclick="memberTypeModule.edit('+val+')">编辑</a>');
		btn.push('<a href="javascript:void(0);" onclick="memberTypeModule.delete('+val+')">删除</a>');
		return btn.join(' | ');
	},
	
	//刷新
	refresh: function(){
		$(this.datagrid).datagrid('reload');
	},
	
	//添加
	add: function(){
		var that = this;
		$(that.dialog).dialog({
			title: '添加分类',
			iconCls: 'icons-application-application_add',
			width: 390,
			height: 270,
			cache: false,
			href: '<?php echo U('Member/typeAdd');?>',
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: false,
			maximizable: false,
			buttons:[{
				text:'确定',
				iconCls:'icons-other-tick',
				handler: function(){
					$(that.dialog).find('form').eq(0).form('submit', {
						onSubmit: function(){
							var isValid = $(this).form('validate');
							if (!isValid) return false;
							
							$.messager.progress({text:'处理中，请稍候...'});
							$.post('<?php echo U('Member/typeAdd?dosubmit=1');?>', $(this).serialize(), function(res){
								$.messager.progress('close');
								
								if(!res.status){
									$.app.method.tip('提示信息', res.info, 'error');
								}else{
									$.app.method.tip('提示信息', res.info, 'info');
									$(that.dialog).dialog('close');
									that.refresh();
								}
							}, 'json');
							
							return false;
						}
					});
				}
			},{
				text:'取消',
				iconCls:'icons-arrow-cross',
				handler: function(){
					$(that.dialog).dialog('close');
				}
			}]
		});
	},
	
	//编辑
	edit: function(id){
		if(typeof(id) !== 'number'){
			$.app.method.tip('提示信息', '未选择分类', 'error');
			return false;
		}
		var href = '<?php echo U('Member/typeEdit');?>';
		href += href.indexOf('?') != -1 ? '&id='+id : '?id='+id;
		
		var that = this;
		$(that.dialog).dialog({
			title: '编辑分类',
			iconCls: 'icons-application-application_edit',
			width: 390,
			height: 270,
			cache: false,
			href: href,
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: false,
			maximizable: false,
			buttons:[{
				text:'确定',
				iconCls:'icons-other-tick',
				handler:function(){
					$(that.dialog).find('form').eq(0).form('submit', {
						onSubmit: function(){
							var isValid = $(this).form('validate');
							if (!isValid) return false;
							
							$.messager.progress({text:'处理中，请稍候...'});
							var action = '<?php echo U('Member/typeEdit', array('dosubmit'=>1));?>';
							action += action.indexOf('?') != -1 ? '&id='+id : '?id='+id;
							$.post(action, $(this).serialize(), function(res){
								$.messager.progress('close');
								
								if(!res.status){
									$.app.method.tip('提示信息', res.info, 'error');
								}else{
									$.app.method.tip('提示信息', res.info, 'info');
									$(that.dialog).dialog('close');
									that.refresh();
								}
							}, 'json');
							
							return false;
						}
					});
				}
			},{
				text: '取消',
				iconCls: 'icons-arrow-cross',
				handler: function(){
					$(that.dialog).dialog('close');
				}
			}]
		});
	},
	
	//删除
	delete: function(id){
		if(typeof(id) !== 'number'){
			$.app.method.tip('提示信息', '未选择分类', 'error');
			return false;
		}
		var that = this;
		$.messager.confirm('提示信息', '确定要删除吗？', function(result){
			if(!result) return false;
			
			$.messager.progress({text:'处理中，请稍候...'});
			$.post('<?php echo U('Member/typeDelete');?>', {id: id}, function(res){
				$.messager.progress('close');
				
				if(!res.status){
					$.app.method.tip('提示信息', res.info, 'error');
				}else{
					$.app.method.tip('提示信息', res.info, 'info');
					that.refresh();
				}
			}, 'json');
		});
	},
	
	//排序
	order: function(){
		var that = this;
		$.messager.progress({text:'处理中，请稍候...'});
		$.post('<?php echo U('Member/typeOrder');?>', $(that.datagrid).parent('div').find('input[type="text"].sort-input').serialize(), function(res){
			$.messager.progress('close');
			
			if(!res.status){
				$.app.method.tip('提示信息', res.info, 'error');
			}else{
				$.app.method.tip('提示信息', res.info, 'info');
				that.refresh();
			}
		}, 'json');
	}
};
</script>