<?php
//向图书管理系统插入一本新的图书
//传入json格式
/*{
    state:"insert_book",
    data:{
        book_id:,
		title:,
        author:,
		index_id,
        price:,
        id:,
		type,
		pubdate,
    }
}
{
    state:"update_book",
    data:{
        book_id:,
		title:,
        author:,
		index_id,
        price:,
        id:,
		type,
		pubdate,
    }
}
{
    state:"delete_book",
    data:{
        book_id:
    }
}
{
    state:"borrow",
    data:{
        book_id:
    }
}
{
    state:"return",
    data:{
        book_id:,
		start_date:
    }
}

*/
//session_save_path("/tmp");  for linux

session_start();
if(empty($_SESSION["name"])){
	echo json_encode(array("success"=>"false", "error"=>"unsigned", "res"=>""));
	return;
};
$user_id = $_SESSION["name"];

//$result["book_id"];
if(empty($_POST["res"])){
	
	echo json_encode(array("success"=>"false", "error"=>"lack_res", "res"=>""));
	return;
}
//前端传至后端的json数据
$json = $_POST["res"];
//json转化为PHP变量
$book = json_decode($json, true);
$opt = $book["state"];
$data = $book["data"];

//判断操作有效性
if($opt != "insert_book" && $opt != "update_book" && $opt != "delete_book"&& $opt != "borrow_book"&& $opt != "return_book")
{
	echo json_encode(array("success"=>"false", "error"=>"Invalid_Operation", "res"=>""));
	return;
}
//连接数据库
$con=mysqli_connect("localhost","root","Mysql_qlf13073");
if (!$con)
{
	echo json_encode(array("success"=>"false", "error"=>mysql_error(), "res"=>""));
	return;
}

mysqli_select_db($con,"library");
mysqli_query($con,"set names utf8");

if($opt == "insert_book"){
	$id = time().rand(0,100); // 时间+随机数 来生成唯一的id
	mysqli_query($con,"INSERT INTO books (book_id, title,author,price,index_id,pub_name,pub_date,type) VALUES ('$id','{$data["title"]}','{$data["author"]}','{$data["price"]}','{$data["index_id"]}','{$data["pub_name"]}', '{$data["pub_date"]}','{$data["type"]}')");
	mysqli_query($con,"INSERT INTO store (book_id, lib_name) VALUES ('$id','{$data["lib_name"]}')   ");
	$result["book_id"]=$id;
	echo json_encode(array("success"=>"true", "error"=>"", "res"=>$result));
	mysqli_close($con);
	return;
}
//更新书籍信息
else if($opt == "update_book"){
	mysqli_query($con,"UPDATE books SET title = '{$data["title"]}', author = '{$data["author"]}', price = '{$data["price"]}', index_id = '{$data["index_id"]}', pub_date = '{$data["pub_date"]}', pub_name = '{$data["pub_name"]}' WHERE book_id = '{$data["book_id"]}'");
	echo json_encode(array("success"=>"true", "error"=>"", "res"=>$result));
	mysqli_close($con);
	return;
}
//借阅操作
else if($opt == "borrow_book"){
	$start_date = date("Y-m-d");
	mysqli_query($con,"INSERT INTO borrow (book_id,user_id,start_date) VALUES('{$data["book_id"]}','$user_id','$start_date')");
	mysqli_query($con,"UPDATE books SET status = 'borrowed' WHERE book_id='{$data["book_id"]}'");
	echo json_encode(array("success"=>"true", "error"=>"", "res"=>""));
	mysqli_close($con);
	return;
}
//还书操作
else if($opt == "return_book"){
	mysqli_query($con,"DELETE FROM borrow WHERE book_id='{$data["book_id"]}'");
	$end_date = date("Y-m-d");
	mysqli_query($con,"INSERT INTO history (book_id,user_id,start_date,end_date) VALUES('{$data["book_id"]}','$user_id','{$data["start_date"]}','$end_date')");
	mysqli_query($con,"UPDATE books SET status = 'not borrowed'");
	echo json_encode(array("success"=>"true", "error"=>"", "res"=>""));
	mysqli_close($con);
	return;
}
else if($opt == "delete_book"){
	mysqli_query($con,"DELETE FROM books WHERE book_id = '{$data["book_id"]}'");
	echo json_encode(array("success"=>"true", "error"=>"", "res"=>""));
	mysqli_close($con);
	return;
}
?>
