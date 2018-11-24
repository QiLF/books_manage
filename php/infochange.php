<?php
// 个人信息修改

//传入json格式
/*{
    data:{
		name:,
		sex:,
        age:,
		grade:,
        dept:,
    }
}*/
	//session_save_path("/tmp");
	
	session_start();
	if(empty($_SESSION["name"])){
		echo json_encode(array("success"=>"false", "error"=>"please sign in first", "res"=>""));
		exit;
	}
	if(empty($_POST["res"])){
		echo json_encode(array("success"=>"false", "error"=>"res is null", "res"=>""));
		exit;
	}

	$user_id = $_SESSION["name"];

	$json=$_POST["res"];
	$res=json_decode($json,true);
	$data=$res["data"];
	$name=$data["name"];
	$age=$data["age"];
	$sex=$data["sex"];
	$dept=$data["dept"];
	$grade=$data["grade"];
	
	$link=mysqli_connect("localhost","root","Mysql_qlf13073");

	if(!$link){
		echo json_encode(array("success"=>"false", "error"=>"connection_error", "res"=>""));
		exit;
	}
	//Database Select
	mysqli_select_db($link,"library");
	mysqli_query($con,"set names utf8");
	$sql_select="SELECT user_id FROM user_password WHERE user_id ='$user_id'";
	$res_select=mysqli_query($link,$sql_select);
	$num=mysqli_num_rows($res_select);

	if($num){ 
		//user_not_exist FALSE
        $sql_update="UPDATE users SET name='$name',age='$age',grade='$grade',dept='$dept',sex='$sex',WHERE user_id='$user_id'"; 
		$res_update=mysqli_query($link,$sql_update);  
		if($res_update){
			echo json_encode(array("success"=>"true", "error"=>"", "res"=>""));
			mysqli_close($link);
			exit;
		}else{
			echo json_encode(array("success"=>"false", "error"=>"update_fail", "res"=>""));
			mysqli_close($link);
			exit;
		}
    }else{
		//user_not_exist TRUE
		echo json_encode(array("success"=>"false", "error"=>"user_not_exist", "res"=>""));
		mysqli_close($link);
		exit;
	}
?>
