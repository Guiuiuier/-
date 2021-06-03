<?php


// 用户编辑后台处理
include "../admin/config.inc.php";
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$mysqli -> set_charset(DB_CHARSET);
	 if ($mysqli -> connect_error) {

	    	die("连接错误：".$mysqli -> connect_error);

     }
    //  var_dump($_POST);
    //  exit();
$edit =$_GET['edit'];
// var_dump($edit);
$userName=$_POST['User_name'];
$Email=$_POST['Email_name'];
$passWord=md5($_POST['User_pass']);
$rePassword=md5($_POST['User_pass']);
$note=$_POST['Note_text'];
$number=$_POST['Number_phone'];


$sql="select * from user where Username ='{$userName}'";
$mysqli ->set_charset(DB_CHARSET);
$result=$mysqli ->query($sql);
// 查询取出一个结果
$row=$result -> fetch_assoc();
// 验证用户名
 if($row){
     echo "<script>";
     echo "alert('用户名已存在');";
     echo"window.location='manage-users.php'";
     echo "</script>";
     exit();
     
 }
//  验证密码
 if($passWord != $rePassword ){
    echo "<script>";
   echo "alert ('两次输入的密码不一致');";
   echo "window.location='manage-users.php';";
   echo "</script>";
   exit();
}
// 修改
$sql="UPDATE user set Username='{$userName}', Password='{$passWord}',email='{$Email}', phone_number='{$number}', Note='{$note}' where id='{$edit}'";
$mysqli ->set_charset(DB_CHARSET);
$result = $mysqli -> query($sql);


if($result){
    echo "<script>";
    echo "alert ('修改成功');";
    echo "window.location='manage-users.php';";
    echo "</script>";
    exit();

}
