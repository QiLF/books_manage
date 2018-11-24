﻿<?php
//Called by register.html
/*
*
*	Data_name : res
*	Data_format : {"data":{"user_id":"this_is_user_id","first_password":"password","second_password":"password_confirm","check_agree":"agree_or_not"}}
*		
*	error_type :	data_not_acquired			:data transmit error
*					user_id_is_empty
*					first_password_empty
*					second_password_empty
*					not_agree
*					different_passwords
*					connection_error			:SQL operation error
*					user_is_exist
*					user_insert_fail			:SQL operation error
*					userinfo_insert_fail		:SQL operation error
*
*
*
*author:A
*version:1.0.0
*/



	//ERROR_TYPE data_not_acquired CHECK
	if(empty($_POST["res"])){
		echo json_encode(array("success"=>"false", "error"=>"data_not_acquired", "res"=>""));
		exit;
	}
	
	//Data Decode
	$json=$_POST["res"];
	$res=json_decode($json,true);
	$data=$res["data"];
	$user_id=$data["username"];
	$password=$data["first_password"];
	$password_confirm=$data["second_password"];
	$check_agree=$data["check_agree"];


	if($user_id==""){
		//ERROR_TYPE user_id_is_empty CHECK
		echo json_encode(array("success"=>"false", "error"=>"user_id_is_empty", "res"=>""));
		exit;
	}else if($password==""){
		//ERROR_TYPE first_password_empty CHECK
		echo json_encode(array("success"=>"false", "error"=>"first_password_empty", "res"=>""));
		exit;
	}else if($password_confirm==""){
		//ERROR_TYPE second_password_empty CHECK
		echo json_encode(array("success"=>"false", "error"=>"second_password_empty", "res"=>""));
		exit;
	}else if($check_agree!="agree"){
		//ERROR_TYPE not_agree CHECK
		echo json_encode(array("success"=>"false", "error"=>"not_agree", "res"=>""));
		exit;
	}else{

		//Server Link
		$link=mysqli_connect("localhost","root","Mysql_qlf13073");
		if(!$link){
			//ERROR_TYPE connection_error CHECK
			echo json_encode(array("success"=>"false", "error"=>"connection_error", "res"=>""));
			exit;
		}
		//Database Select
		mysqli_select_db($link,"library");
		mysqli_query($con,"set names utf8");
		$sql_select="SELECT user_id FROM user_password WHERE user_id ='$user_id'";
		$res_select=mysqli_query($link,$sql_select);
		$num=mysqli_num_rows($res_select);

		//ERROR_TYPE user_is_exist CHECK
		if($num){ 
			//user_is_exist TRUE
            echo json_encode(array("success"=>"false", "error"=>"user_is_exist", "res"=>""));
			mysqli_close($link);
			exit;
        }else{ 
			//user_is_exist FALSE

			//ERROR_TYPE different_passwords CHECK
			if($password==$password_confirm){
				//different_passwords FALSE

				//insert into table:user_password & users
				$sql_user_insert="INSERT INTO user_password(user_id,password) VALUES ('$user_id','$password')"; 
				$res_user_insert=mysqli_query($link,$sql_user_insert);
				$sql_userinfo_insert="INSERT INTO users(user_id) VALUES ('$user_id')";
				$res_userinfo_insert=mysqli_query($link,$sql_userinfo_insert);
				
				//insert into avatar a default avatarname
				$head_sample="img/sample.jpeg";
				mysqli_query($link,"INSERT INTO avatar (user_id, avatarname) VALUES ('$user_id','$head_sample')");
				//end
				
				if($res_user_insert && $res_userinfo_insert){  
					echo json_encode(array("success"=>"true", "error"=>"", "res"=>""));
					mysqli_close($link);
					exit;
				}else{ 
					if(!$res_user_insert){
						//ERROR_TYPE user_insert_fail CHECK
						echo json_encode(array("success"=>"false", "error"=>"user_insert_fail", "res"=>""));
					}
					if(!$res_userinfo_insert){
						//ERROR_TYPE userinfo_insert_fail CHECK
						echo json_encode(array("success"=>"false", "error"=>"userinfo_insert_fail", "res"=>""));
					}
					mysqli_close($link);
					exit;
				}
			}else{
				//different_passwords TRUE
				echo json_encode(array("success"=>"true", "error"=>"different_passwords", "res"=>""));
				exit;
			} 
        }     
	}
?>
