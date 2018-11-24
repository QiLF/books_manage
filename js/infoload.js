window.onload=function(){
	load_info();
}

function load_info()
{	
	var book_id = window.parent.current_book_id;
    var temp={
				"state":"get_result",
				 "data":{
							"book_id":book_id
						}
			  };
    var res = JSON.stringify(temp);
    $(function(){
        $.ajax({
            url: "php/books_search.php",
            type: "POST",
            data:{res:res},
            dataType: "json",
            error: function(){
                layer.msg("数据请求异常");
                return false;
            },
            success: function(data){
                if(data.success=="true"){
					document.forms["bookinfo-form"]["curr_state"].value=data.res[0].curr_state;
					document.forms["bookinfo-form"]["title"].value=data.res[0].title;
					document.forms["bookinfo-form"]["price"].value=data.res[0].price;
					document.forms["bookinfo-form"]["author"].value=data.res[0].author;
					document.forms["bookinfo-form"]["pub_name"].value=data.res[0].pub_name;
					document.forms["bookinfo-form"]["pub_date"].value=data.res[0].pub_date;
					document.forms["bookinfo-form"]["index_id"].value=data.res[0].index_id;
					document.forms["bookinfo-form"]["type"].value=data.res[0].type;	
					document.forms["bookinfo-form"]["lib_name"].value=data.res[0].lib_name;	
                    return true;
                }else{
                    layer.msg(data.error);
                }
            }
        });
    });
}
