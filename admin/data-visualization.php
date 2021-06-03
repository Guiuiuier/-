<?php

include "../admin/config.inc.php";
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$mysqli -> set_charset(DB_CHARSET);
	 if ($mysqli -> connect_error) {

	    	die("连接错误：".$mysqli -> connect_error);

	 }
//  第一页：0,5  page1 左边从0开始 右边五条数据
// 第二页 ：5,5  page2
// 第三页：10,5  page3


//判断是否为空 
if(empty($_GET["page"])){

  $page=1;

}else{
  $page=$_GET['page'];
};//这是a标签传值过来 

$sql="select count(*) from gbook";     //拿出用户总条数
$endResult = $mysqli -> query($sql);
$EndPage=mysqli_fetch_row($endResult)[0];  //[0]数据下的0 直接取总条数 这是命令下的总条数
// var_dump($EndPage);  //7条 

//每一页显示的页数
$num=2;                                                              //$num 与 $start 页数要一致 否则会错误；
$totalpage=ceil($EndPage/$num);//ceil 向上取整数  /除以   //总页数 赋值给尾页
// var_dump($EndPage);

//判断 页数
if($page>$totalpage){
  $page=$totalpage;
}
if($page<1){
  $page=1;
}
                            
//下一页或者上一页显示的新数据
$start=($page-1)*2;                                             //$num 与 $start 页数要一致 否则会错误；
//获取用户的信息
$sql ="select *  from gbook limit $start,2 ";
	$result = $mysqli -> query($sql);
 while ($row = $result -> fetch_assoc()) {
		$rows[] = $row;   //$rows中保存user表中所有记录
      }
// var_dump($rows);
// var_dump($rows);
// echo json_encode($rows);





  //删除任务

  $delet=@$_GET['delet'];
$sql="select count(*) from gbook"; 
$endResult = $mysqli -> query($sql);
$EndPage=mysqli_fetch_row($endResult)[0];
$sql ="DELETE FROM gbook WHERE  id=$delet ";
$result = $mysqli -> query($sql);

 
if($result){
    
  echo "<script>";
//   echo "alert('删除成功');";
  echo "window.location='data-visualization.php';";
  echo "</script>";

}

?>




    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Visualization</title>
        <meta name="description" content="">
        <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'> -->
        <link href="../Home/css/font-awesome.min.css" rel="stylesheet">
        <link href="../Home/css/bootstrap.min.css" rel="stylesheet">
        <link href="../Home/css/templatemo_m-style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    </head>

    <body>
        <!-- Left column -->
        <div class="templatemo-flex-row">
            <div class="templatemo-sidebar">
                <header class="templatemo-site-header">
                    <div class="square"></div>
                    <h1>Visual Admin</h1>
                </header>
                <div class="profile-photo-container">
                    <img src="../Home/images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">
                    <div class="profile-photo-overlay"></div>
                </div>
                <!-- Search box -->
                <!-- <form class="templatemo-search-form" role="search">
          <div class="input-group">
              <button type="submit" class="fa fa-search"></button>
              <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">           
          </div>
        </form> -->
                <div class="mobile-menu-icon">
                    <i class="fa fa-bars"></i>
                </div>
                <nav class="templatemo-left-nav">
                    <ul>
                        <li><a href="../Home/back_m.html"><i class="fa fa-home fa-fw"></i>管理面板</a></li>
                        <!-- <li><a href="#"><i class="fa fa-bar-chart fa-fw"></i>图表</a></li> -->
                        <li><a href="#" class="active"><i class="fa fa-database fa-fw"></i>留言内容</a></li>
                        <li><a href="../admin/manage-users.php"><i class="fa fa-users fa-fw"></i>管理与格言</a></li>
                        <li><a href="../Home/preferences.html"><i class="fa fa-sliders fa-fw"></i>用户添加</a></li>
                        <li><a href="maps.php"><i class="fa fa-map-marker fa-fw"></i>地图</a></li>
                        <!-- <li><a href="login.html"><i class="fa fa-eject fa-fw"></i>退出登录</a></li> -->
                    </ul>
                </nav>
            </div>
            <!-- Main content -->
            <div class="templatemo-content col-1 light-gray-bg">
                <div class="templatemo-top-nav-container">
                    <div class="row">
                        <nav class="templatemo-top-nav col-lg-12 col-md-12">
                            <ul class="text-uppercase">
                                <li><a href="../Home/back_m.html" class="active">管理面板</a></li>
                                <li><a href="../Home/index.html">前端主页</a></li>
                                <li><a href="../Home/resume.html">个人简历</a></li>
                                <li><a href="../admin/back_login.php">退出登录</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="templatemo-content-container">
                    <div class="templatemo-content-widget white-bg" style="width:1000px; margin:0 auto">
                        <div class="panel panel-default no-border">
                            <?php
               foreach ($rows as $row) { 
                 ?>
                                <div class="panel-heading border-radius-10">
                                    <h2>留言板</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="templatemo-flex-row flex-content-row margin-bottom-30">
                                        <div class="col-1">
                                            <div id="gauge_div" class="templatemo-chart" style="height:100px width:100px">
                                                <?php echo $row["Content"];?>
                                            </div>
                                            <P style="text-align: right">作者:
                                                <?php echo $row["User"];?>
                                            </P>
                                            <p style="text-align: right">留言时间:
                                                <?php echo date("Y-m-d H:i:s",$row["Time"])?>
                                            </p>
                                            <div class="form-group" style="text-align:right">
                                            <td style="margin-top:5px;"><a href="data-visualization.php?delet=<?php echo $row['id'];?>" class="templatemo-blue-button">删除</a></td>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php   }  ?> </div>
              
                                <tr align="center">

<td colspan="5">
    <!-- 每一页展现五条数据在上面的sql语句中使用limit -->
    <a href="data-visualization.php?page=1" class="templatemo-blue-button">首页</a>
    <a href="data-visualization.php?page=<?php echo $page-1?>" class="templatemo-blue-button">上一页</a>
    <a href=" data-visualization.php?page=<?php echo $page+1?>" class="templatemo-blue-button">下一页</a>
    <a href="data-visualization.php?page=<?php echo $totalpage; ?>" class="templatemo-blue-button">尾页</a>
</td>
</tr> </div>
                </div>
                
            </div>
            
        </div>

        <!-- JS -->
        <script type="text/javascript" src="../Home/js/jquery-1.11.2.min.js"></script>
        <!-- jQuery -->
        <script type="text/javascript" src="../Home/js/jquery-migrate-1.2.1.min.js"></script>
        <!--  jQuery Migrate Plugin -->
        <script type="text/javascript" src="../Home/js/templatemo-script.js"></script>
        <!-- Templatemo Script -->
        <!-- <script>
 
 
 
        //留言内容处理
 $(function(){
   $.ajax({
   
     url:"gbook_back_content.php",
     dataType:"json",
     success:function(data){
    console.log(data);
   me_Content=""; //内容
   Author="";  //作者
   me_time="" //留言时间
   $.each(data,function(a,b){  
     me_Content=me_Content+b.Content
     Author=Author+b.User
     me_time=me_time+b.Time
   })
   $("#author").append(Author); //插入内容
   $("#Message_Content").append(me_Content); 
   $("#Message_time").append(me_time); 
     }
    
   })
   })
</script> -->
    </body>

    </html>