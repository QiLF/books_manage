    function personinfo_change()
    {
		var name = document.forms["personinfo_form"]["name"].value;
		var age = document.forms["personinfo_form"]["age"].value;
		var sex = document.forms["personinfo_form"]["sex"].value;
		var dept = document.forms["personinfo_form"]["dept"].value;		
        var grade = document.forms["personinfo_form"]["grade"].value
		//必填项检查
		if(!name || name == "")
        {
          layer.msg("姓名不得为空！");
          return false;
        }
        if(name.length<2||name.length>15)
        {
          layer.msg("姓名需为2-15个字符！");
          return false;
        }
        if(!isNaN(name))
        {
          layer.msg("姓名不得为纯数字！");
          return false;
        }
		if(!isNaN(age))
        {
          layer.msg("年龄应为数字格式");
          return false;
        }
		var res = {"data":{"user_id":user_id,"name":name,"age":age,"sex":sex,"dept":dept,"grade":grade}};
		
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "php/infochange.php" ,
            data: {res:res},
            success: function(data) {
              if(data.success=="false"){
  				if(data.error=="please sign in first")
  				{
  					layer.msg("请先登录！");
  				}
              }
              else {
                  layer.msg('信息修改成功！')
  				  window.location.href="books_manage.html";
              }
            },
            error : function() {
              layer.msg("数据请求异常");
            }
        });
    }



