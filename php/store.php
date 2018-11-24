<?php
    $max_num = 40;
    //传入json格式
/*{
    state:"insert_book",
    data:{
        book_id:,
		lib_name
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
        }else if(!strcmp($state, "get_result")){
            $sql = "SELECT * FROM `library`.`store` WHERE book_id=".$data["book_id"];

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