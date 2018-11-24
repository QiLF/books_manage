var books;
var book_links;
//按名称对书籍进行查询
function searchByTitle()
{
	 books=new Array();	//书籍信息
	 book_links=new Array();	//显示的书籍查询结果，点击实现弹窗 html元素格式
	var title = document.forms["search_form"]["title"].value;
	var res={
				"state":"get_result",
				 "data":{
						  "title":title,
						  "order":"DESC",
						  "order_by":"index_id"
						}
			  };
	  var str=JSON.stringify(res);
	  
	  $.ajax({
             url: "php/books_search.php",
             type: "POST",
             data:{res:str},
			 dataType: "json",
             error: function(){
                 alert('Error loading XML document');
             },
             success: function(data){
				if(data.success=="true"){
					//alert("search success");
					for(var i=0;i<Object.keys(data.res).length;i++){
						books.push(data.res[i]);
					}
					show_book_links(books,book_links,'searchByTitleRes');//将书籍信息显示
				}else{
					//如果查询记录为空
					if(data.error=="result is null")
					{
						document.getElementById('searchByTitleResLinks').innerHTML="<div class='layui-text'>未查询到相关书籍数据</div>";
					}else{
						alert(data.error);
					}
				}
			}
		});
}

//按精细条件对书籍进行查询
function preciselySearch()
{
	books=new Array();	//书籍信息
	book_links=new Array();	//显示的书籍查询结果，点击实现弹窗 html元素格式
	var title = document.forms["precisely_search_form"]["title"].value;
	var index_id = document.forms["precisely_search_form"]["index_id"].value;
	var pub_name = document.forms["precisely_search_form"]["pub_name"].value;
	var type = document.forms["precisely_search_form"]["type"].value;
	var res={
				"state":"get_result",
				 "data":{
						  "title":title,
						  "index_id":index_id,
						  "pub_name":pub_name,
						  "type":type,
						  "order":"DESC",
						  "order_by":"index_id"
						}
			  };
	  var str=JSON.stringify(res);
	  
	  $.ajax({
             url: "php/books_search.php",
             type: "POST",
             data:{res:str},
			 dataType: "json",
             error: function(){
                 alert('Error loading XML document');
             },
             success: function(data){
				if(data.success=="true"){
					alert("search success");
					for(var i=0;i<Object.keys(data.res).length;i++){
						books.push(data.res[i]);
					}
					show_book_links(books,book_links,'preciselySearchRes');//将书籍信息显示

				}else{
					//如果查询记录为空
					if(data.error=="result is null")
					{
						document.getElementById('preciselySearchResLinks').innerHTML="<div class='layui-text'>未查询到相关书籍数据</div>";
					}else{
						alert(data.error);
					}
				}
			}
		});
}

