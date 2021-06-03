<?php

include "config.inc.php";
$Writer=$_POST['Motto_writer'];
$Content=$_POST['Motto_content'];
$pubDate=time();
$sql ="UPDATE motto SET writer='{$Writer}',content='{$Content}',time='{$pubDate}'";
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

	 if ($mysqli -> connect_error) {

	    	die("连接错误：".$mysqli -> connect_error);

	 }
$mysqli -> set_charset(DB_CHARSET);
	$result = $mysqli -> query($sql);
   
    if($result){
    
        echo "<script>";
        echo "alert('修改成功');";
        echo "window.location='../Home/back_m.html';";
        echo "</script>";

  }

?>