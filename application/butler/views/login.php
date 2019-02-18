<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>登入 - <?=$this->config->item(''); ?></title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="/public/butler/layui/css/layui.css" media="all">
	<link rel="stylesheet" href="/public/butler/style/admin.css" media="all">
	<link rel="stylesheet" href="/public/butler/style/login.css" media="all">
</head>
<body style="background:url(/public/butler/layui/images/common/6.jpg) no-repeat 0px 0px;">
	<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
		<div class="layadmin-user-login-main">
			<div class="layadmin-user-login-box layadmin-user-login-header">
				<h2><?=$this->config->item('sys_name'); ?></h2>
				<p><?=$this->config->item('sys_into'); ?></p>
			</div>
			<div class="layadmin-user-login-box layadmin-user-login-body layui-form">
				<div class="layui-form-item">
					<label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
					<input type="text" name="username" id="LAY-user-login-username" lay-verify="required" placeholder="用户名" class="layui-input">
				</div>
				<div class="layui-form-item">
					<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
					<input type="password" name="password" id="LAY-user-login-password" lay-verify="required" placeholder="密码" class="layui-input">
					<input type="hidden" id="safe_factor" name="safe_factor" value="<?=$auth_code; ?>" />
					<input type="hidden" id="safe_code" name="safe_code" value="<?=get_md5($auth_code); ?>" />
				</div>
				<div class="layui-form-item">
					<div class="layui-row">
						<div class="layui-col-xs7">
							<label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
							<input type="text" name="vercode" id="LAY-user-login-vercode" lay-verify="required" placeholder="图形验证码" class="layui-input">
						</div>
						<div class="layui-col-xs5">
							<div style="margin-left: 10px;">
								<img src="https://www.oschina.net/action/user/captcha" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">
							</div>
						</div>
					</div>
				</div>
				<div class="layui-form-item" style="margin-bottom: 20px;">
					<input type="checkbox" name="keep_login" lay-skin="primary" title="记住密码">
					<a href="forget.html" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>
				</div>
				<div class="layui-form-item">
					<button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-login-submit">登 入</button>
				</div>
				<div class="layui-trans layui-form-item layadmin-user-login-other">
					<label>社交账号登入</label>
					<a href="javascript:;"><i class="layui-icon layui-icon-login-qq"></i></a>
					<a href="javascript:;"><i class="layui-icon layui-icon-login-wechat"></i></a>
					<a href="javascript:;"><i class="layui-icon layui-icon-login-weibo"></i></a>
					<a href="reg.html" class="layadmin-user-jump-change layadmin-link">注册帐号</a>
				</div>
			</div>
		</div>
		<div class="layui-trans layadmin-user-login-footer">
			<p>© 2018 <a href="http://www.neasyth.cn" target="_blank">neasyth.cn</a></p>
			<p>
				<span><a href="http://www.neasyth.cn" target="_blank">前往官网</a></span>
			</p>
		</div>
	</div>
	<script src="/public/butler/layui/layui.js"></script>
	<script src="/public/butler/lib/extend/md5.js"></script>
	<script src="/public/butler/lib/extend/base64.js"></script>
	<script>
	layui.config({
		base: '/public/butler/' //静态资源所在路径
	}).extend({
		index: 'lib/index' //主入口模块
	}).use(['index', 'user'], function(){
		var $ = layui.$
		,setter = layui.setter
		,admin = layui.admin
		,form = layui.form
		,router = layui.router()
		,search = router.search;

		form.render();
		//提交
		form.on('submit(LAY-user-login-submit)', function(obj){
			obj.field.password = Base64.encode(md5(obj.field.password));
			$.ajax({
			  url:"<?=site_url('login/login_reco'); ?>",
			  type:'POST',
			  data:obj.field,
			  success:function(data){
				  var data = $.parseJSON(data);
				  if(data.code == 1){
					  layer.msg(data.msg, {
						offset: '15px'
						,icon: 5
					  });
					  $(this).removeClass('layui-btn-disabled');
					  return;
				  } else {
					// //验证成功后，写入 access_token
					// layui.data(setter.tableName, {
					//   key: setter.request.tokenName
					//   ,value: data.data.access_token
					// });

					// 登入成功的提示与跳转
					layer.msg('登入成功', {
					  offset: '15px'
					  ,icon: 1
					  ,time: 1000
					}, function(){
					  location.href = '<?=site_url('home'); ?>'; //后台主页
					});
				  }
			  },
			  complete: function () {
				  layer.close(this.layerIndex);
			  }
			});
		});
	});
	</script>
</body>
</html>