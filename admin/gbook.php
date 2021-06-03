<?php 
$content=$_POST['content'];
$user=$_POST['user'];
$pubDate=time();

 include "config.inc.php";

   $sql="INSERT INTO gbook VALUES (null,'{$user}','{$content}','{$pubDate}')";

   
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

	 if ($mysqli -> connect_error) {

	    	die("连接错误：".$mysqli -> connect_error);

	 }
	$mysqli -> set_charset(DB_CHARSET);
	$result = $mysqli -> query($sql);
// var_dump($result);
     // 定义一个类
//  class input{

// 	   function post($content){
// 	       if($content == ''){
// 	       	 return false;
// 	       }
	       
// 	       return true;
// 	      }

//  }
//  $input =new input();

 //定义函数  检查内容


//    $post1 = $input->post($content,$user);
//      if ($post1 == false){
//      	echo "<script>";
//      	echo "alert('留言内容或留言人不能为空');";
//      	echo "</script>";
//      }  

	 if($result){
    
        echo "<script>";
        echo "alert('留言成功');";
        echo "window.location='../Home/gbook.html';";
        echo "</script>";

  }

 

     
 ?>