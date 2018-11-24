function insert_book(){
	
	var title=document.forms["insert_book_form"]["title"].value;
	var author=document.forms["insert_book_form"]["author"].value;
	var price=document.forms["insert_book_form"]["price"].value;
	var index_id=document.forms["insert_book_form"]["index_id"].value;
	var pub_name=document.forms["insert_book_form"]["pub_name"].value;
	var pub_date=document.forms["insert_book_form"]["pub_date"].value;
	var type=document.forms["insert_book_form"]["type"].value;
	var lib_name=document.forms["insert_book_form"]["lib_name"].value;
	
	
    var temp={"state":"insert_book","data":{"title":title,"price":price,"index_id":index_id,
				"type":type,"pub_name":pub_name,"pub_date":pub_date,"author":author,"lib_name":lib_name}};
    var res = JSON.stringify(temp);
    $(function(){
        $.ajax({
            url: "php/books_manage.php",
            type: "POST",
            data:{res:res},
            dataType: "json",
            error: function(){
                layer.msg("数据请求异常");
                return false;
            },
            success: function(data){
                if(data.success=="true"){
                    layer.msg("录入书籍成功！");
					var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
					parent.layer.close(index);
                    return true;
                }else{
                    layer.msg(data.error);
                }
            }
        });
    });
	
}
