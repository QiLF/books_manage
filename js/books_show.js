var current_book_id = null; 
/**
 * 显示查询结果
 */
  function show_book_links(books,book_links,elems_block)
  {
	  for(var i=0;i<books.length;i++)
	  {
		  var state = null;
		  if(books[i].curr_state == "borrowed")
		  {
			state = "借出";  
		  }else{
			state = "可借";
		  }
		  var book_id = books[i].book_id;
				book_links.push("<a style='cursor:pointer' class='layui-text' onclick='book_view("+book_id+")'>"
								 + "<div class='layui-row'>"
								 +        " <div class='layui-col-md2'>"
								 +			"<i class='layui-icon' style='font-size: 18px; color: #1E9FFF;'>&#xe64c;</i>书籍名称:"
								 +books[i].title
								 +         "</div>"
								 +			"<div class='layui-col-md1'>作者:"+ books[i].author+"</div>"
								 +			"<div class='layui-col-md2'>索书号:"+ books[i].index_id+"</div>"
								 +			"<div class='layui-col-md2'>出版社:"+ books[i].pub_name+"</div>"
								 +			"<div class='layui-col-md2'> 出版日期: "+books[i].pub_date+"</div>"
								 +          "<div class='layui-col-md3'>状态: "+state+"</div>"
								 +"</div>"
								 +		"</a>"
								);
	  }
	  	/**************************************layui分页部分**********************************************/
		layui.use(['layer','laypage'], function(){ 
		var laypage = layui.laypage
		,layer = layui.layer;
		  //自定义分页样式
		  laypage.render
		({
			elem: elems_block
			,count: book_links.length
			,limit: 10
			,first: '首页'
			,last: '尾页'
			,prev: '<em>←</em>'
			,next: '<em>→</em>'
			,theme: '#1E9FFF'
		  });

		  //调用分页
		  laypage.render({
			elem: elems_block
			,count:book_links.length
			,jump: function(obj){
			  //模拟渲染
			  document.getElementById(elems_block+'Links').innerHTML = function(){
				var arr = []
				,thisData = book_links.concat().splice(obj.curr*obj.limit - obj.limit, obj.limit);
				layui.each(thisData, function(index, item){
				  arr.push('<li>'+ item +'</li>');
				});
				return arr.join('');
			  }();
			}
		  });
		});
  }
  
  
 /**
 * 弹窗,显示书籍详细信息
 */ 
  function book_view(book_id)
  {
	current_book_id = book_id;
		layer.open({
		  type: 2,
		  title: '书籍详情',
		  resize:false,
		  maxmin: true,
		  shadeClose: true, //点击遮罩关闭层
		  area : ['800px' , '600px'],
		  content: 'bookinfo_subframe.html'
		});
  }
  
 /**
 * 弹窗,显示新建图书界面
 */ 
  function new_book()
  {
		layer.open({
		  type: 2,
		  title: '新建书籍',
		  resize:false,
		  maxmin: true,
		  shadeClose: true, //点击遮罩关闭层
		  area : ['800px' , '600px'],
		  content: 'bookinsert_subframe.html'
		});
  }