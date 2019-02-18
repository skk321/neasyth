/** layuiAdmin.std-v1.1.0 LPPL License By http://www.layui.com/admin/ */
;
layui.define(["table", "form", 'jquery'], function(e) {
	var t = layui.$,
		j = layui.jquery,
		i = layui.table;

	layui.form;
	i.render({
		elem: "#LAY-user-manage",
		// url: layui.setter.base + "json/useradmin/webuser.js",
		url: "products/list",
		cols: [
			[
// {
// 				type: "checkbox",
// 				fixed: "left"
// 			}, 
			{
				field: "id",
				title: "ID",
				sort: !0
			}, {
				field: "product_no",
				title: "产品编号",
				minWidth: 100
			}, {
				field: "product_name",
				title: "产品名称",
				minWidth: 180
			}, {
				field: "avatar",
				title: "缩略图",
				width: 100,
				templet: "#imgTpl"
			}, {
				field: "price",
				title: "价格"
			}, {
				field: "category",
				title: "分类"
			}, {
				field: "status",
				title: "状态"
			}, {
				field: "order",
				title: "排序"
			}, {
				field: "create_time",
				title: "创建时间",
				sort: !0
			}
			, {
				field: "update_time",
				title: "最后修改时间",
				sort: !0
			}, {
				title: "操作",
				width: 150,
				align: "center",
				fixed: "right",
				toolbar: "#table-useradmin-webuser"
			}]
		],
		page: !0,
		limit: 30,
		height: "full-220",
		text: "对不起，加载出现异常！"
	}), i.on("tool(LAY-user-manage)", function(e) {
		e.data;
		if ("del" === e.event) {
			layer.confirm("确定删除此产品吗？", function(t) {
				j.ajax({
					 type: "GET",
					 url: "products/delete/" + e.data.product_no,
					 dataType: "json",
					 success: function(data){
								if(data.code == 1){
									  layer.msg(data.msg, {
										offset: '15px'
										,icon: 5
									  });
									  e.del(), layer.close(t)
									  return;
								}else{
									layer.msg(data.msg, {
										offset: '15px'
										,icon: 1
									  });
									  e.del(), layer.close(t)
									  return;
								}
							  }
				 });

				e.del(), layer.close(t)
			})
		};
	}), i.on("tool(LAY-user-back-manage)", function(e) {
		e.data;
		if ("del" === e.event) {
			layer.confirm("确定删除此产品吗？", function(t) {
				$.ajax({
					 type: "GET",
					 url: "/products/delete/",
					 dataType: "json",
					 success: function(data){
						if(data.code == 1){
							  layer.msg(data.msg, {
								offset: '15px'
								,icon: 5
							  });
							  e.del(), layer.close(t)
							  return;
						}else{
							layer.msg(data.msg, {
								offset: '15px'
								,icon: 1
							  });
							  e.del(), layer.close(t)
							  return;
						}
					}
				 });	
			})
		};
	}), e("product", {})
});
