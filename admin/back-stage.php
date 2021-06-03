<?php 
require_once "function.php";
// echo $_POST['check'];
if($_POST['check']!=$_SESSION['gg_code']){
    echo "<script>alert('验证码不正确')</script>";
    echo "<script>window.location='back_login.php'</script>";
    unset($_SESSION['gg_code']);
    break;
}
$Password=md5($_POST['pwd']);
$User=$_POST['user'];
$Check=$_POST['check'];
// $_SESSION[''];
// var_dump($Password,$User);
include "config.inc.php";
$sql="select * from user where Username='{$User}' and Password='{$Password}' ";
$mysqli=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli -> connect_error) {
    die("连接错误：".$mysqli -> connect_error);
}

$mysqli ->set_charset(DB_CHARSET);
$result=$mysqli ->query($sql);
while ($row=$result -> fetch_assoc()) {
    $rows[]=$row; //$rows中保存user表中所有记录
}

// //登录验证


echo "</script>";
if(empty($rows)) {
    echo "<script>alert ('账号或者密码不正确')</script>";
    echo "<script>window.location='back_login.php'</script>";
}

;
//登录验证 
echo "<script>";
foreach($rows as $key=> $value) {
    // var_dump($value['Username']);
    if($User==$value['Username'] && $value['Password']==$Password) {
        echo "alert ('登陆成功');";
        echo "window.location='../Home/back_m.html';";
        break;
    }
}

echo "</script>";