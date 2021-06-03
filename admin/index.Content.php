<?php
include "config.inc.php";

$sql ="select *  from essay";
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

	 if ($mysqli -> connect_error) {

	    	die("连接错误：".$mysqli -> connect_error);

	 }
$mysqli -> set_charset(DB_CHARSET);
	$result = $mysqli -> query($sql);
 while ($row = $result -> fetch_assoc()) {
		$rows[] = $row;   //$rows中保存user表中所有记录
	}

    echo json_encode($rows);
        
	// echo '<script src="../2019/Home/js/jquery.js"></script>';
?>