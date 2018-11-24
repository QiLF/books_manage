<?php
    $max_num = 40;
    //传入json格式
/*{
    state:"get_num/get_result",
    data:{
        book_id:,
		title:,
        author:,
		index_id,
        price:,
        id:,
		type,
		pub_date,
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
        
        if(!$state){
            echo json_encode(array("success"=>"false", "error"=>"no state", "res"=>""));
            mysqli_close($con);
            return;
        }else if(!strcmp($state, "get_num") || !strcmp($state, "get_result")){
            $condition_num = 0;
            if(!empty($data["title"])){
                $condition[$condition_num++] = "(title like '%{$data["title"]}%')";
            }
            if(!empty($data["author"])){
                $condition[$condition_num++] = "(author = '{$data["author"]}')";
            }
            if(!empty($data["pub_name"])){
                $condition[$condition_num++] = "(pub_name = '{$data["pub_name"]}')";
            }
            if(!empty($data["type"])){
                $condition[$condition_num++] = "(type = '{$data["type"]}')";
            }
            $sql = "SELECT * FROM `books`,`store` ";
            if($condition_num > 0){
                $sql = $sql." WHERE books.book_id=store.book_id AND ".$condition[0];
                for($i = 1; $i < $condition_num; $i++){
                    $sql = $sql." AND ".$condition[$i];
                }
            }
            if(!empty($data["order_by"])){
                $sql = $sql." ORDER BY ".$data["order_by"];
            }else{
                $sql = $sql." ORDER BY index_id";
            }
            if(!empty($data["order"])){
                $sql = $sql." ".$data["order"].";";
            }else{
                $sql = $sql." DESC;";
            }
            $result=mysqli_query($con,$sql);  
            if(!$result){
                echo json_encode(array("success"=>"false", "error"=>mysqli_error($con), "res"=>""));
                mysqli_close($con);
                return;
            }
			$res = array();
            if(!strcmp($state, "get_num")){
                $num = mysqli_num_rows($result);
                echo json_encode(array("success"=>"true", "error"=>"", "res"=>array("num"=>$num)));
                mysqli_close($con);
                return;
            }else{
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
						$res[$i] = $temp;
						$i = $i + 1;				
					}
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