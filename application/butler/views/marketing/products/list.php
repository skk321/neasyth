<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$this->config->item('sys_name'); ?> - <?=$title; ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/public/butler/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/public/butler/style/admin.css" media="all">
</head>
<body>
  <div class="layui-fluid">
    <div class="layui-card">
      <div class="layui-form layui-card-header layuiadmin-card-header-auto">
        <div class="layui-form-item">
          <div class="layui-inline">
            <label class="layui-form-label">产品编号</label>
            <div class="layui-input-block">
              <input type="text" name="product_no" placeholder="请输入产品编号" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">产品名称</label>
            <div class="layui-input-block">
              <input type="text" name="product_name" placeholder="请输入产品名称" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">价格</label>
            <div class="layui-input-block">
              <input type="text" name="price" placeholder="请输入价格" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">分类</label>
            <div class="layui-input-block">
              <select name="category">
                <option value="0">全部</option>
                                <option value="1">主食</option>
                                <option value="2">饮品</option>
                                <option value="3">套餐</option>
                                <option value="4">小食</option>
                              </select>
            </div>
          </div>
          <div class="layui-inline">
            <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="LAY-user-front-search">
              <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
            </button>
          </div>
        </div>
      </div>
      
      <div class="layui-card-body">
        <div style="padding-bottom: 10px;">
         <!--  <button class="layui-btn layuiadmin-btn-useradmin" data-type="batchdel">删除</button> -->
          <button class="layui-btn layuiadmin-btn-useradmin" lay-href="http://101.132.162.79:81/butler.php/goods/products/add">添加</button>
        </div>
        
        <table id="LAY-user-manage" lay-filter="LAY-user-manage"></table>
        <script type="text/html" id="imgTpl">
          <img style="display: inline-block; width: 50%; height: 100%;" src= {{ d.avatar }}>
        </script> 
        <script type="text/html" id="table-useradmin-webuser">
          <a class="layui-btn layui-btn-normal layui-btn-xs" lay-href="http://101.132.162.79:81/butler.php/goods/products/edit/{{ d.product_no }}"><i class="layui-icon layui-icon-edit"></i>编辑</a>
          <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
        </script>
      </div>
    </div>
  </div>

  <script src="/public/butler/layui/layui.js"></script>  
  <script>
  layui.config({
    base: '/public/butler/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'product', 'table'], function(){
    var $ = layui.$
    ,form = layui.form
    ,table = layui.table;
    
    //监听搜索
    form.on('submit(LAY-user-front-search)', function(data){
      var field = data.field;
      
      //执行重载
      table.reload('LAY-user-manage', {
        where: field
      });
    });
  
    //事件
    var active = {
      batchdel: function(){
        var checkStatus = table.checkStatus('LAY-user-manage')
        ,checkData = checkStatus.data; //得到选中的数据

        if(checkData.length === 0){
          return layer.msg('请选择数据');
        }

        layer.confirm('确定删除吗？', function() {
          
          table.reload('LAY-user-manage');
          layer.msg('已删除');
        });
      }
    };
    
    $('.layui-btn.layuiadmin-btn-useradmin').on('click', function(){
      var type = $(this).data('type');
      active[type] ? active[type].call(this) : '';
    });
  });
  </script>
</body>
</html>
