
<?php

// 用户查询！！
include "../admin/config.inc.php";
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	 if ($mysqli -> connect_error) {

	    	die("连接错误：".$mysqli -> connect_error);

     }
     

$edit =$_GET['edit'];
$section=$_POST['section'];
$content=$_POST['content'];
$writer=$_POST['writer'];
$title=$_POST['title'];
$pubdate=time();

$sql ="update essay set  section='{$section}', title='{$title}',content='{$content}', writer='{$writer}', pubtime='{$pubdate}' where id=$edit";
$mysqli -> set_charset(DB_CHARSET);
$result = $mysqli -> query($sql);
 
//   while ($row = $result -> fetch_assoc()) {
// 		$rows[] = $row;   //$rows中保存user表中所有记录
//       }
    //   var_dump($rows);

    if($result){
    
        echo "<script>";
        echo "alert('修改文章成功');";
        echo "window.location='maps.php';";
        echo "</script>";

  }
?>