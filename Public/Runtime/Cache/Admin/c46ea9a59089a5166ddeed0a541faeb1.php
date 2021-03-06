<?php if (!defined('THINK_PATH')) exit();?>
<table id="admin_rolelist_datagrid" class="easyui-datagrid" data-options='<?php $dataOptions = array_merge(array ( 'border' => false, 'fit' => true, 'fitColumns' => true, 'rownumbers' => true, 'singleSelect' => true, 'striped' => true, 'pagination' => true, 'pageList' => array ( 0 => 20, 1 => 30, 2 => 50, 3 => 80, 4 => 100, ), 'pageSize' => '20', ), $datagrid["options"]);if(isset($dataOptions['toolbar']) && substr($dataOptions['toolbar'],0,1) != '#'): unset($dataOptions['toolbar']); endif; echo trim(json_encode($dataOptions), '{}[]').((isset($datagrid["options"]['toolbar']) && substr($datagrid["options"]['toolbar'],0,1) != '#')?',"toolbar":'.$datagrid["options"]['toolbar']:null); ?>' style=""><thead><tr><?php if(is_array($datagrid["fields"])):foreach ($datagrid["fields"] as $key=>$arr):if(isset($arr['formatter'])):unset($arr['formatter']);endif;echo "<th data-options='".trim(json_encode($arr), '{}[]').(isset($datagrid["fields"][$key]['formatter'])?",\"formatter\":".$datagrid["fields"][$key]['formatter']:null)."'>".$key."</th>";endforeach;endif; ?></tr></thead></table>

<script type="text/javascript">
var adminRoleModule = {
	dialog:   '#globel-dialog-div',
	datagrid: '#admin_rolelist_datagrid',
	
	//工具栏
	toolbar: [
		{text: '添加角色', iconCls: 'icons-table-table_add', handler: function(){adminRoleModule.add();}},
		{text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){adminRoleModule.refresh();}},
		{text: '排序', iconCls: 'icons-table-table_sort', handler: function(){adminRoleModule.order();}}
	],
	
	//排序格式化
	sort: function(val, arr){
		return '<input class="sort-input" type="text" name="order['+arr['roleid']+']" value="'+val+'" size="2" style="text-align:center" />';
	},
	
	//状态格式化
	state: function(val){
		return val == 1 ? '<font color="red">未启用</font>' : '已启用';
	},

	//操作格式化
	operate: function(val){
		var btn = [];
		if(val == 1){
			btn.push('权限设置');
			btn.push('栏目权限');
			btn.push('编辑');
			btn.push('删除');
		}else{
			btn.push('<a href="javascript:void(0);" onclick="adminRoleModule.permission('+val+')">权限设置</a>');
			btn.push('<a href="javascript:void(0);" onclick="adminRoleModule.category('+val+')">栏目权限</a>');
			btn.push('<a href="javascript:void(0);" onclick="adminRoleModule.edit('+val+')">编辑</a>');
			btn.push('<a href="javascript:void(0);" onclick="adminRoleModule.delete('+val+')">删除</a>');
		}
		return btn.join(' | ');
	},
	
	//刷新
	refresh: function(){
		$(this.datagrid).datagrid('reload');
	},
	
	//添加角色
	add: function(){
		var that = this;
		$(that.dialog).dialog({
			title: '添加角色',
			iconCls: 'icons-application-application_add',
			width: 380,
			height: 260,
			cache: false,
			href: '<?php echo U('Admin/roleAdd');?>',
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
							$.post('<?php echo U('Admin/roleAdd?dosubmit=1');?>', $(this).serialize(), function(res){
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
	
	//编辑角色
	edit: function(id){
		if(typeof(id) !== 'number'){
			$.app.method.tip('提示信息', '未选择角色', 'error');
			return false;
		}
		var href = '<?php echo U('Admin/roleEdit');?>';
		href += href.indexOf('?') != -1 ? '&id='+id : '?id='+id;
		
		var that = this;
		$(that.dialog).dialog({
			title: '编辑角色',
			iconCls: 'icons-application-application_edit',
			width: 380,
			height: 260,
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
							var action = '<?php echo U('Admin/roleEdit', array('dosubmit'=>1));?>';
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
	
	//删除角色
	delete: function(id){
		if(typeof(id) !== 'number'){
			$.app.method.tip('提示信息', '未选择角色', 'error');
			return false;
		}
		var that = this;
		$.messager.confirm('提示信息', '确定要删除吗？', function(result){
			if(!result) return false;
			
			$.messager.progress({text:'处理中，请稍候...'});
			$.post('<?php echo U('admin/roleDelete');?>', {id: id}, function(res){
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
		$.post('<?php echo U('Admin/roleOrder');?>', $(that.datagrid).parent('div').find('input[type="text"].sort-input').serialize(), function(res){
			$.messager.progress('close');
			
			if(!res.status){
				$.app.method.tip('提示信息', res.info, 'error');
			}else{
				$.app.method.tip('提示信息', res.info, 'info');
				that.refresh();
			}
		}, 'json');
	},
	
	//权限设置
	permission: function(id){
		if(typeof(id) !== 'number'){
			$.app.method.tip('提示信息', '未选择角色', 'error');
			return false;
		}
		var href = '<?php echo U('Admin/rolePermission');?>';
		href += href.indexOf('?') != -1 ? '&id='+id : '?id='+id;
		
		var that = this;
		$(that.dialog).dialog({
			title: '权限设置',
			iconCls: 'icons-application-application_key',
			width: 320,
			height: 250,
			cache: false,
			href: href,
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: true,
			maximizable: true,
			buttons:[{
				text:'确定',
				iconCls:'icons-other-tick',
				handler:function(){
					var nodes = $('#admin-role-permission-tree').tree('getChecked');
					var menuids = [];
					for(var i=0; i<nodes.length; i++){
						menuids.push(nodes[i]['id']);
						menuids.push(nodes[i]['attributes']['parent']);
					}
					
					$.messager.progress({text:'处理中，请稍候...'});
					$.post('<?php echo U('Admin/rolePermission?dosubmit=1');?>', {id: id, menuids: menuids.join(',')}, function(res){
						$.messager.progress('close');
						
						if(!res.status){
							$.app.method.tip('提示信息', res.info, 'error');
						}else{
							$.app.method.tip('提示信息', res.info, 'info');
							$(that.dialog).dialog('close');
						}
					});
					return false;
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
	
	//栏目权限
	category: function(id){
		if(typeof(id) !== 'number'){
			$.app.method.tip('提示信息', '未选择角色', 'error');
			return false;
		}
		var href = '<?php echo U('Admin/roleCategory');?>';
		href += href.indexOf('?') != -1 ? '&id='+id : '?id='+id;
		
		var that = this;
		$(that.dialog).dialog({
			title: '栏目权限',
			iconCls: 'icons-application-application_key',
			width: 560,
			height: 360,
			cache: false,
			href: href,
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: true,
			maximizable: true,
			buttons:[{
				text:'确定',
				iconCls:'icons-other-tick',
				handler:function(){
					var data = {};
					$(that.dialog).find('input[type="checkbox"]:checked').each(function(i, obj){
						var catid = $(obj).attr('catid') || 0;
						if(catid && !obj.disabled && obj.value){
							if(!data[catid]) data[catid] = [];
							data[catid].push(obj.value);
						}
					});
					var action = '<?php echo U('Admin/roleCategory?dosubmit=1');?>';
					action += action.indexOf('?') != -1 ? '&id='+id : '?id='+id;
					
					$.messager.progress({text:'处理中，请稍候...'});
					$.post(action, {info: data}, function(res){
						$.messager.progress('close');
						
						if(!res.status){
							$.app.method.tip('提示信息', res.info, 'error');
						}else{
							$.app.method.tip('提示信息', res.info, 'info');
							$(that.dialog).dialog('close');
						}
					});
					return false;
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
	
	//栏目权限全选或取消格式化
	checkbox: function(val, arr){
		return '<input type="checkbox" value="' + arr['catid'] + '" onclick="adminRoleModule.checkAll(this)" />';
	},
	
	//栏目权限字段格式化
	field: function(val, arr){
		var row = ['<input type="checkbox"'];
		row.push('class="catid_' + arr['catid'] + '"');
		row.push('catid="' + arr['catid'] + '"');
		row.push('value="' + val + '"');
		
		if(arr['checked_' + val]) row.push('checked');
		
		switch(parseInt(arr['type'])){
			case 0:
				if(val != 'view') row.push('disabled');
				break;
		}
		row.push('/>');
		return row.join(' ');
	},
	
	//栏目权限全选或取消操作
	checkAll: function(object){
		$(this.dialog).find('input[type="checkbox"].catid_' + object.value).each(function(i, obj){
			if(object.checked && !obj.checked){
				obj.checked = true;
			}else if(!object.checked && obj.checked){
				obj.checked = false;
			}
		});
	}
};
</script>