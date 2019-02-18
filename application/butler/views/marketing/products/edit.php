
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>产品管理-编辑产品</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
	<link rel="stylesheet" href="/public/style/admin.css" media="all">
</head>
<body>
	<div class="layui-fluid">
		<div class="layui-card">
			<div class="layui-card-header">编辑产品</div>
			<div class="layui-card-body" style="padding: 15px;">
				<form class="layui-form" action="" lay-filter="component-form-group">
					<div class="layui-form-item">
						<label class="layui-form-label">产品名称</label>
						<div class="layui-input-block">
							<input type="text" name="product_name" lay-verify="required|title" autocomplete="off" placeholder="请输入产品名称" class="layui-input" value="板烧鸡腿堡">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">产品价格</label>
						<div class="layui-input-block">
							<input type="text" name="price" lay-verify="required|number" placeholder="请输入价格" autocomplete="off" class="layui-input" value="17.00">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">产品分类</label>
						<div class="layui-input-block">
							<select name="category" lay-filter="aihao">
																<option value="1" >主食</option>
																<option value="2" >饮品</option>
																<option value="3" >套餐</option>
																<option value="4" >小食</option>
															</select>
						</div>
					</div>
					<div class="layui-form-item">
			            <label class="layui-form-label">缩略图</label>
			            <div class="layui-input-inline">
			              <input type="text" name="avatar" lay-verify="required" placeholder="请上传图片" autocomplete="off" class="layui-input" value="https://coca.easyarvr.com/uploads/products/1_m_PlateRoastChickenLeg.png">
			            </div>
			            <button style="float: left;" type="button" class="layui-btn" id="layuiadmin-upload-useradmin">上传图片</button> 
			        </div>
					<div class="layui-form-item">
						<label class="layui-form-label">立即上架</label>
						<div class="layui-input-block">
							<input type="checkbox" name="status" lay-skin="switch" lay-text="是|否" checked="checked">
						</div>
					</div>
					<div class="layui-form-item layui-form-text">
						<label class="layui-form-label">描述信息</label>
						<div class="layui-input-block">
							<textarea name="intro" placeholder="请输入产品描述" class="layui-textarea">111</textarea>
						</div>
					</div>
					<div class="layui-form-item layui-layout-admin">
						<div class="layui-input-block">
							<div class="layui-footer" style="left: 0;">
								<button class="layui-btn" lay-submit="" lay-filter="component-form-demo1">立即提交</button>
								<button type="reset" class="layui-btn layui-btn-primary">重置</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="/public/layui/layui.js"></script>  
	<script>
	layui.config({
		base: 'http://101.132.162.79:81/public/' //静态资源所在路径
	}).extend({
		index: 'lib/index' //主入口模块
	}).use(['index', 'form', 'laydate', 'upload'], function(){
		var $ = layui.$
		,admin = layui.admin
		,element = layui.element
		,layer = layui.layer
		,laydate = layui.laydate
		,form = layui.form
		,upload = layui.upload;

		upload.render({
	      elem: '#layuiadmin-upload-useradmin'
	      ,url: 'http://101.132.162.79:81/butler.php/affixs/upload'
	      ,accept: 'images'
	      ,method: 'get'
	      ,acceptMime: 'image/*'
	      ,done: function(res){
	        $(this.item).prev("div").children("input").val(res.data.url)
	      }
	    });
		
		form.render(null, 'component-form-group');

		laydate.render({
			elem: '#LAY-component-form-group-date'
		});
		
		/* 监听指定开关 */
		form.on('switch(component-form-switchTest)', function(data){
			layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
				offset: '6px'
			});
		});
		
		/* 监听提交 */
		form.on('submit(component-form-demo1)', function(data){

				$.ajax({
						url:"http://101.132.162.79:81/butler.php/goods/products/edit_reco/CN0011901030001",
						type:'post',
						data:JSON.stringify(data.field),
						success:function(data){
								var data = $.parseJSON(data);
								if(data.code == 1){
										parent.layer.msg(data.msg, {
											offset: '15px'
											,icon: 5
										});
			
										return;
								}else{
									parent.layer.msg(data.msg, {
										offset: '15px'
										,icon: 1
									});
									return;
								}
						},
						complete: function () {
								parent.layer.close(this.layerIndex);
						}
					});
		});
	});
	</script>
</body>
</html>
