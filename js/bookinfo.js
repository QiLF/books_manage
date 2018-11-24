function bookinfo_update(book_id)
{
	var title=document.forms["bookinfo-form"]["title"].value;
	var price=document.forms["bookinfo-form"]["price"].value;
	var author=document.forms["bookinfo-form"]["author"].value;
	var pub_name=document.forms["bookinfo-form"]["pub_name"].value;
	var pub_date=document.forms["bookinfo-form"]["pub_date"].value;
	var index_id=document.forms["bookinfo-form"]["index_id"].value;
	var type=document.forms["bookinfo-form"]["type"].value;	
	
    var temp={"state":"update_book","data":{"book_id":book_id,"title":title,"price":price,"index_id":index_id,
				"type":type,"pub_name":pub_name,"pub_date":pub_date,"author":author}};
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
                    layer.msg("修改书籍信息成功！");
                    return true;
                }else{
                    layer.msg(data.error);
                }
            }
        });
    });
}

function delete_book(bookid){
    var temp={"state":"delete_book","data":{"book_id":book_id}};
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
                    layer.msg("删除书籍信息成功！");
                    return true;
                }else{
                    layer.msg(data.error);
                }
            }
        });
    });
}