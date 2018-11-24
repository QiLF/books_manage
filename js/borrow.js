function borrow_book()
{
	var book_id = window.parent.current_book_id;
    var temp={"state":"borrow_book","data":{"book_id":book_id}};
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
                    layer.msg("借阅成功！");
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

function return_book(book_id,start_date)
{
    var temp={"state":"return_book","data":{"book_id":book_id,"start_date":start_date}};
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
                    layer.msg("还书成功！");
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