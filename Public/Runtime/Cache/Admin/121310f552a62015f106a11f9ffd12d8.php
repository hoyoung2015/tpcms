<?php if (!defined('THINK_PATH')) exit();?>
<table id="system-setting-propertygrid" class="easyui-propertygrid" data-options="border:false,fit:true,showHeader:true,columns:[[{field:'name',title:'属性名称',width:50},{field:'value',title:'属性值',width:200}]],showGroup:true,scrollbarSize:0,title:'<?php echo ($currentpos); ?>',url:'<?php echo U('System/setting', array('grid'=>'propertygrid'));?>',onClickRow:systemSettingModule.onClickRow,toolbar:systemSettingModule.toolbar"></table>

<script type="text/javascript">
var systemSettingModule = {
	dialog:       '#globel-dialog-div',
	propertygrid: '#system-setting-propertygrid',
	data: {},
	
	//工具栏
	toolbar: [
		{text: '保存', iconCls: 'icons-table-table_save', handler: function(){systemSettingModule.save();}},
		{text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){systemSettingModule.refresh();}},
		{text: '导出', iconCls: 'icons-table-table_go', handler: function(){systemSettingModule.export();} },
		{text: '导入', iconCls: 'icons-table-table_edit', handler: function(){systemSettingModule.import();}},
		{text: '还原', iconCls: 'icons-table-table_gear', handler: function(){systemSettingModule.default();}}
	],

	//记录当前选项的位置，失去焦点的时候可以用来定位
	onClickRow: function(index){
		systemSettingModule.data = {index: index, field: 'value'};
	},
	
	//刷新
	refresh: function(){
		$(this.propertygrid).propertygrid('reload');
	},
	
	//保存
	save: function(){
		var that = this;
		var data = [];
		var rows = $(this.propertygrid).propertygrid('getChanges');
		for(var i=0; i<rows.length; i++){
			data.push({'key': rows[i]['key'], 'value': rows[i]['value']});
		}
		
		$.messager.progress({text:'处理中，请稍候...'});
		$.post('<?php echo U('System/setting?dosubmit=1');?>', {data: data}, function(res){
			$.messager.progress('close');
			
			if(!res.status){
				$.app.method.tip('提示信息', res.info, 'error');
			}else{
				$.app.method.tip('提示信息', res.info, 'info');
				that.refresh();
			}
		}, 'json');
	},

	//上传文件
	image: function(){
		var that = this;
		var option = this.data;
		$.app.method.upload(
			"<?php echo U('Upload/file');?>",
			function(res){
				if(res.status){
					var url = UPLOAD_ROOT + res.info;

					//直接赋值
					$(that.propertygrid).propertygrid('selectRow', option.index).propertygrid('beginEdit', option.index);
					var ed = $(that.propertygrid).propertygrid('getEditor', {index:option.index,field:option.field});
					$(ed.target).prop('src', url);
				}else{
					$.app.method.tip('提示信息', (res.info || '上传失败'), 'error');
				}
			},
			function(filename){  //上传验证函数
				if(!filename.match(/\.jpg$|\.png$|\.bmp$/i)){
					$.app.method.tip('提示信息', '上传文件后缀不允许', 'error');
					return false;
				}
				return true;
			}
		);
	},
	
	//导出
	export: function(){
		$.messager.progress({text:'处理中，请稍候...'});
		$.post('<?php echo U('System/settingExport');?>', function(res){
			$.messager.progress('close');
			
			if(!res.status){
				$.app.method.tip('提示信息', res.info, 'error');
			}else{
				$.app.method.tip('提示信息', res.info, 'info');
				window.location.href = res.url;
			}
		}, 'json');
	},
	
	//导入
	import: function(){
		var that = this;
		$.messager.confirm('提示信息', '该操作将清空所有数据，确定要继续吗？', function(result){
			if(!result) return false;

			$.app.method.upload(
				'<?php echo U('Upload/import', array('from'=>urlencode('站点设置')));?>',
				function(json){    //上传成功回调函数
					$.messager.progress({text:'处理中，请稍候...'});
					$.post('<?php echo U('System/settingImport');?>', {filename: json.filename}, function(res){
						$.messager.progress('close');
						
						if(!res.status){
							$.app.method.tip('提示信息', res.info, 'error');
						}else{
							$.app.method.tip('提示信息', res.info, 'info');
							that.refresh();
						}
					}, 'json');
				},
				function(filename){  //上传验证函数
					if(!filename.match(/\.data$/)){
						$.app.method.tip('提示信息', '上传文件后缀不允许', 'error');
						return false;
					}
					return true;
				}
			);
		});
	},
	
	//还原
	default: function(){
		var that = this;
		$.messager.confirm('提示信息', '确定要恢复出厂设置吗？', function(result){
			if(!result) return true;
			
			$.messager.progress({text:'处理中，请稍候...'});
			$.post('<?php echo U('System/settingDefault');?>', function(res){
				$.messager.progress('close');
				
				if(!res.status){
					$.app.method.tip('提示信息', res.info, 'error');
				}else{
					$.app.method.tip('提示信息', res.info, 'info');
					that.refresh();
				}
			}, 'json');
		})
	}
};
</script>