<?php
$User_name=$_POST['User_name'];
$User_pass =md5($_POST['User_pass']);
$Email_name =$_POST['Email_name'];
$Number_phone =$_POST['Number_phone'];
$Note_test=$_POST['Note_text'];
$Re_password=md5($_POST['Repassword']);
include "config.inc.php";
$mysqli=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli -> connect_error) {
    die("连接错误：".$mysqli -> connect_error);
}

// 验证账号是否存在
$sql="select * from user where Username ='{$User_name}'";
$mysqli ->set_charset(DB_CHARSET);
$result=$mysqli ->query($sql);
// 查询取出一个结果
$row=$result -> fetch_assoc();

 if($row){
     echo "<script>";
     echo "alert('用户名已存在');";
     echo"window.location='manage-users.php'";
     echo "</script>";
     exit();
     
 }

// var_dump($result);
//  密码确认

if($User_pass != $Re_password ){
     echo "<script>";
    echo "alert ('两次输入的密码不一致');";
    echo "window.location='../Home/preferences.html';";
    echo "</script>";
    exit();
}
 $sql="INSERT INTO user VALUES (null,'{$User_name}','{$User_pass}','{$Email_name}','{$Number_phone}','{$Note_test}')";  
 $mysqli ->set_charset(DB_CHARSET);
$result=$mysqli ->query($sql);
//  添加管理员

 if($result){
        echo "<script>";
        echo "alert ('添加管理员成功');";
        echo "window.location='../Home/back_m.html';";
        echo "</script>";
        exit();
    
}

