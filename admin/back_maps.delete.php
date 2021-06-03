<?php

$id =$_GET['id'];
include "config.inc.php";
$sql  ="delete from essay where id in ({$id})";
$mysqli=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli -> connect_error) {
    die("连接错误：".$mysqli -> connect_error);
}

$mysqli ->set_charset(DB_CHARSET);
$result=$mysqli ->query($sql);
// while ($row=$result -> fetch_assoc()) {
//     $rows[]=$row; //$rows中保存user表中所有记录
// }
// echo "<script>";
//  if($result){
   
//         echo "alert ('删除此条留言成功');";
//         echo "window.location='../admin/data-visualization.php';";
//         echo "</script>";
//         break;
    
// }
 
?>