var borrowed_books;
var borrowed_book_res;
var history_books;
var history_book_res;

/**
 * 显示当前借阅书籍
 */
  function show_borrowed_books()
  {
	  for(var i=0;i<borrowed_books.length;i++)
	  {
		  var book_id = borrowed_books[i].book_id;
				borrowed_book_res.push(
								 "<div class='layui-row' style='margin:10px'>"
								 +        " <div class='layui-col-md2'>"
								 +			"<i class='layui-icon' style='font-size: 18px; color: #1E9FFF;'>&#xe64c;</i>书籍名称:"
								 +		borrowed_books[i].title
								 +         "</div>"
								 +			"<div class='layui-col-md1'>作者:"+ borrowed_books[i].author+"</div>"
								 +			"<div class='layui-col-md2'>索书号:"+ borrowed_books[i].index_id+"</div>"
								 +			"<div class='layui-col-md2'>出版社:"+ borrowed_books[i].pub_name+"</div>"
								 +			"<div class='layui-col-md2'> 出版日期: "+borrowed_books[i].pub_date+"</div>"
								 +			"<div class='layui-col-md3'><button class='layui-btn layui-btn-xs' style='width:87px' type='button' onclick='return_book("+book_id+","+borrowed_books[i].start_date+")'>还书</button>"
								 +"</div>"
								);
	  }
	  	/**************************************layui分页部分**********************************************/
		layui.use(['layer','laypage'], function(){ 
		var laypage = layui.laypage
		,layer = layui.layer;
		  //自定义分页样式
		  laypage.render
		({
			elem: 'borrowed_laypage'
			,count: borrowed_book_res.length
			,limit: 10
			,first: '首页'
			,last: '尾页'
			,prev: '<em>←</em>'
			,next: '<em>→</em>'
			,theme: '#1E9FFF'
		  });

		  //调用分页
		  laypage.render({
			elem: 'borrowed_laypage'
			,count:borrowed_book_res.length
			,limit: 10
			,jump: function(obj){
			  //模拟渲染
			  document.getElementById('borrowed_block').innerHTML = function(){
				var arr = []
				,thisData = borrowed_book_res.concat().splice(obj.curr*obj.limit - obj.limit, obj.limit);
				layui.each(thisData, function(index, item){
				  arr.push('<li>'+ item +'</li>');
				});
				return arr.join('');
			  }();
			}
		  });
		});
  }
  
  function search_user_borrowed_books()
  {
	borrowed_books=new Array();	//书籍信息
	borrowed_book_res=new Array();	//显示的书籍查询结果
	var temp={"state":"search_borrowed","data":{}};
    var res = JSON.stringify(temp);
	//ajax procedure
    	  $.ajax({
             url: "php/user_borrow.php",
             type: "POST",
             data:{res:res},
			 dataType: "json",
             error: function(){
                 alert('Error loading XML document');
             },
             success: function(data){
				if(data.success=="true"){
					for(var i=0;i<Object.keys(data.res).length;i++){
						borrowed_books.push(data.res[i]);
					}
					show_borrowed_books();//将书籍信息显示
				}else{
					//如果查询记录为空
					if(data.error=="result is null")
					{
						document.getElementById('searchByTitleResLinks').innerHTML="<div class='layui-text'>当前没有借阅书籍</div>";
					}else{
						alert(data.error);
					}
				}
			}
		});
  }

  
 /**
 * 显示借阅历史
 */
  function show_history_books()
  {
	  for(var i=0;i<history_books.length;i++)
	  {
		  var book_id = history_books[i].book_id;
				history_book_res.push(
								 "<div class='layui-row' style='margin:10px'>"
								 +        " <div class='layui-col-md2'>"
								 +			"<i class='layui-icon' style='font-size: 18px; color: #1E9FFF;'>&#xe64c;</i>书籍名称:"
								 +		history_books[i].title
								 +         "</div>"
								 +			"<div class='layui-col-md1'>作者:"+ history_books[i].author+"</div>"
								 +			"<div class='layui-col-md2'>索书号:"+ history_books[i].index_id+"</div>"
								 +			"<div class='layui-col-md2'>出版社:"+ history_books[i].pub_name+"</div>"
								 +			"<div class='layui-col-md2'> 出版日期: "+history_books[i].pub_date+"</div>"
								 +          "<div class='layui-col-md3'></div>"
								 +"</div>"
								);
	  }
	  	/**************************************layui分页部分**********************************************/
		layui.use(['layer','laypage'], function(){ 
		var laypage = layui.laypage
		,layer = layui.layer;
		  //自定义分页样式
		  laypage.render
		({
			elem: 'history_laypage'
			,count: history_book_res.length
			,limit: 10
			,first: '首页'
			,last: '尾页'
			,prev: '<em>←</em>'
			,next: '<em>→</em>'
			,theme: '#1E9FFF'
		  });

		  //调用分页
		  laypage.render({
			elem: 'history_laypage'
			,count:history_book_res.length
			,limit: 10
			,jump: function(obj){
			  //模拟渲染
			  document.getElementById('history_block').innerHTML = function(){
				var arr = []
				,thisData = history_book_res.concat().splice(obj.curr*obj.limit - obj.limit, obj.limit);
				layui.each(thisData, function(index, item){
				  arr.push('<li>'+ item +'</li>');
				});
				return arr.join('');
			  }();
			}
		  });
		});
  }
  
  function search_user_history_books()
  {
	history_books=new Array();	//书籍信息
	history_book_res=new Array();	//显示的书籍查询结果
	var temp={"state":"search_history","data":{}};
    var res = JSON.stringify(temp);
	//ajax procedure
    	  $.ajax({
             url: "php/user_borrow.php",
             type: "POST",
             data:{res:res},
			 dataType: "json",
             error: function(){
                 alert('Error loading XML document');
             },
             success: function(data){
				if(data.success=="true"){
					for(var i=0;i<Object.keys(data.res).length;i++){
						history_books.push(data.res[i]);
					}
					show_history_books();//将书籍信息显示
				}else{
					//如果查询记录为空
					if(data.error=="result is null")
					{
						document.getElementById('searchByTitleResLinks').innerHTML="<div class='layui-text'>当前没有借阅书籍</div>";
					}else{
						alert(data.error);
					}
				}
			}
		});
  }
  