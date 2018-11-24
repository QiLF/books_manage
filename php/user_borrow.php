<?php
    $max_num = 40;
    //传入json格式
/*{
    state:"search_borrowed",
    data:{
		//不需要数据
    }
	{
    state:"search_history",
    data:{
		//不需要数据
    }
}*/
    session_start();
    if(empty($_SESSION["name"])){
        echo json_encode(array("success"=>"false", "error"=>"please sign in first", "res"=>""));
		return;
    } 
	
    if(empty($_POST["res"])){
        echo json_encode(array("success"=>"false", "error"=>"no res", "res"=>""));
        return;
    }else{
        $data = json_decode($_POST["res"], true);
        $con = mysqli_connect("localhost","root","Mysql_qlf13073");
        if(!$con)
		{
			echo json_encode(array("success"=>"false", "error"=>mysqli_error($con), "res"=>"")); 
            return;
		}
        mysqli_select_db($con,"library");  
        mysqli_query($con,"set names utf8"); 
        
        $state = $data["state"];
        $data = $data["data"];
        $user_id = $_SESSION["name"];
        if(!$state){
            echo json_encode(array("success"=>"false", "error"=>"no state", "res"=>""));
            mysqli_close($con);
            return;
        }else if(!strcmp($state, "search_borrowed")){
            $condition_num = 0;
            
            $sql = "SELECT * FROM `books`,`borrow`,`store` WHERE books.book_id=borrow.book_id AND store.book_id=books.book_id AND borrow.user_id='$user_id' ";
            
            $result=mysqli_query($con,$sql);  
            if(!$result){
                echo json_encode(array("success"=>"false", "error"=>mysqli_error($con), "res"=>""));
                mysqli_close($con);
                return;
            }
			$res = array();
			$i = 0;
			while($row = mysqli_fetch_array($result)){
				$temp["book_id"] = $row["book_id"];
				$temp["index_id"] = $row["index_id"];
				$temp["title"] = $row["title"];
				$temp["author"] = $row["author"];
				$temp["price"] = $row["price"];
				$temp["pub_name"] = $row["pub_name"];
				$temp["pub_date"] = $row["pub_date"];
				$temp["type"] = $row["type"];
				$temp["curr_state"] = $row["status"];
				$temp["lib_name"] = $row["lib_name"];
				$temp["start_date"]=$row["start_date"];
				$res[$i] = $temp;
				$i = $i + 1;				
				}
            if($res == null||$res == ""){
				echo json_encode(array("success"=>"false", "error"=>"result is null", "res"=>""));
				mysqli_close($con);
				return;
			}else{
				echo json_encode(array("success"=>"true", "error"=>"", "res"=>$res));
				mysqli_close($con);
				return;
           }
            
            
        }else{
            echo json_encode(array("success"=>"false", "error"=>"undefined state type", "res"=>""));
            mysqli_close($con);
            return;
        }
    }
    
?>  