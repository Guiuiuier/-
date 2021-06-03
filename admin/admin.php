<?php
// $content=$_POST['content'];
// $user=$_POST['user'];
// $pubDate=time();

 include "config.inc.php";

   $sql="select * from user)";

   
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

	 if ($mysqli -> connect_error) {

	    	die("连接错误：".$mysqli -> connect_error);

	 }
	$mysqli -> set_charset(DB_CHARSET);
      $result = $mysqli -> query($sql);
      ?>