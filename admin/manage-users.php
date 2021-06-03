<?php

//屏蔽错误信息
// error_reporting(0); 

  //实现分页功能
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
  $page=@$_GET['page'];
};
// var_dump($page);
//这是a标签传值过来

$sql="select count(*) from user";     //拿出用户总条数
$endResult = $mysqli -> query($sql);
$EndPage=mysqli_fetch_row($endResult)[0];  //[0]数据下的0 直接取总条数 这是命令下的总条数
// var_dump($EndPage);  //7条 

//每一页显示页数
$num=5;                                                                     //$num 与 $start 页数要一致 否则会错误；
$totalpage=ceil($EndPage/$num);//ceil 向上取整数  /除以   //总页数 赋值给尾页
// var_dump($EndPage);
// var_dump($totalpage);

//判断 页数
if($page>$totalpage){
  $page=$totalpage;
}
if($page<1){
  $page=1;
}
//下一页或者上一页显示的新数据                                  
$start=($page-1)*5;                                                       //$num 与 $start 页数要一致 否则会错误；
//获取用户的信息
$sql ="select *  from user limit $start,5";
	$result = $mysqli -> query($sql);
 while ($row = $result -> fetch_assoc()) {
		$rows[] = $row;   //$rows中保存user表中所有记录
      }

// var_dump($rows);
// echo json_encode($rows);



  //删除任务

  $delet=@$_GET['delet'];
// $sql="select count(*) from user"; 
// $endResult = $mysqli -> query($sql);
// $EndPage=mysqli_fetch_row($endResult)[0];
// var_dump($EndPage);
$sql ="DELETE FROM user WHERE  id=$delet ";
$result = $mysqli -> query($sql);

 
if($result){
    
  echo "<script>";
  echo "alert('删除成功');";
  echo "window.location='manage-users.php';";
  echo "</script>";

}

// var_dump($result);
// var_dump($delet);
// var_dump($rows);


// 管理员编辑

 $edit =@$_GET['edit'];

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Manage Users</title>
    <meta name="description" content="">
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'> -->
    <link href="../Home/css/font-awesome_m.min.css" rel="stylesheet">
    <link href="../Home/css/bootstrap_m.min.css" rel="stylesheet">
    <link href="../Home/css/templatemo_m-style.css" rel="stylesheet">
    <script src="../Home/js/jquery.js"></script>
    
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
            <!-- <li><a href="data-visualization.html"><i class="fa fa-bar-chart fa-fw"></i>Charts</a></li> -->
            <li><a href="data-visualization.php"><i class="fa fa-database fa-fw"></i>留言内容</a></li>
            <li><a href="#" class="active"><i class="fa fa-users fa-fw"></i>管理与格言</a></li>
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
                <li><a href="back_login.php">退出登录</a></li>
              </ul>  
            </nav> 
          </div>
        </div>
        <div class="templatemo-content-container">
          <div class="templatemo-content-widget no-padding">
            <div class="panel panel-default table-responsive">
              <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                  <tr  align="center">
                    <td><a href="" class="white-text templatemo-sort-by">ID<span class="caret"></span></a></td>
                    <td><a href="" class="white-text templatemo-sort-by">用户 <span class="caret"></span></a></td>
                    <td><a href="" class="white-text templatemo-sort-by">Eamil <span class="caret"></span></a></td>
                    <td><a href="" class="white-text templatemo-sort-by">联系方式 <span class="caret"></span></a></td>
                    <td><a href="" class="white-text templatemo-sort-by">Note <span class="caret"></span></a></td>
                     <td>编辑</td>
                    <!-- <td>Action</td> -->
                    <td>删除</td>
                  </tr>
                </thead>
                <tbody>


                <!-- 用户查询 endforeach 自动补全 -->
                
                 <?php foreach ($rows as $row):?>
                         <tr align="center">
                         <td><?php echo $row['id'];?></td>
                         <td><?php echo $row['Username'];?></td>
                         <td><?php echo $row['email'];?></td>
                         <td><?php echo $row['phone_number'];?></td>
                         <td><?php echo $row['Note'];?></td>
                         <td><a href="back_user_edit?edit=<?php echo $row['id'];?>" class="templatemo-link" >编辑</a></td>
                         <td><a href="manage-users.php?delet=<?php echo $row['id'];?>" class="templatemo-link">删除</a></td>
                         </tr>
                   <?php endforeach;?>
                    <tr align="center">

                   <td colspan="6" >
                <!-- 每一页展现五条数据在上面的sql语句中使用limit -->
                       <a href="manage-users.php?page=1" class="templatemo-blue-button">首页</a>
                       <a href="manage-users.php?page=<?php echo $page-1?>" class="templatemo-blue-button">上一页</a>
                       <a href="manage-users.php?page=<?php echo $page+1?>"class="templatemo-blue-button">下一页</a>
                       <a href="manage-users.php?page=<?php echo $totalpage; ?>"class="templatemo-blue-button">尾页</a>
                   </td>    
                </tr>    



                    <!-- <td><a href="" class="templatemo-edit-btn">Edit</a></td>
                    <td><a href="" class="templatemo-link">Action</a></td> -->
                   
                  
                  <tbody >
                      
                  </tbody>
                </tbody>    
              </table>    
            </div>                          
          </div> 


          
          <div class="templatemo-flex-row flex-content-row" style="width: 50%; float: left">
            <div class="col-1">
              <div class="panel panel-default margin-10">
                <div class="panel-heading"><h2 class="text-uppercase">每日格言</h2></div>
                <div class="panel-body">
                  <form action="../admin/motto_submit.php" class="templatemo-login-form" method="post">
                    <div class="form-group">
                      <label for="inputEmail">作者</label>
                      <!-- autocomplete="off" 关闭缓存 -->
                      <input type="text" class="form-control" id="inputEmail" placeholder="作者" style="height:30px; width: 200px;" name="Motto_writer"  required="true"  maxlength="15" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label for="inputEmail">格言之声</label>
                      <textarea type="text" class="form-control" id="inputEmail" placeholder="可以在这里填写格言哦" style="height:100px;" name="Motto_content"  required="true"  maxlength="100"></textarea>
                      
                    </div>
                   
                    <div class="form-group">
                      <button type="submit" class="templatemo-blue-button">修改</button>

                    </div>
                  </form>
                </div>                
              </div>              
            </div> 
                           
          </div> 
          <div class="templatemo-flex-row flex-content-row" style="width: 50%; float: right" >
              <div class="col-1">
                <div class="panel panel-default margin-10">
                  <div class="panel-heading"><h2 class="text-uppercase">管理员贴士</h2></div>
                  <div class="panel-body">
                    <form action="../admin/motto_tips_submit.php" class="templatemo-login-form" method="post">
                      <div class="form-group">
                        <label for="inputEmail">留言人</label>
                        <input type="text" class="form-control" id="inputEmail" placeholder="作者" style="height:30px; width: 200px;" name="Motto1_writer"  required="true"  maxlength="15" autocomplete="off">
                       <tr id="tbody">
                         <td></td>
                        </tr>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail">小贴士</label>
                        <textarea type="text" class="form-control" id="inputEmail" placeholder="在这里值班管理员留下贴士，方便后面值班的管理员" style="height:100px;" name="Motto1_content"  required="true"  maxlength="40"></textarea>
                        
                      </div>
                     
                      <div class="form-group">
                        <button type="submit" class="templatemo-blue-button">修改</button>
  
                      </div>
                    </form>
                  </div>                
                </div>       
              </div>                
            </div> 

          <!-- Second row ends -->
           <!-- <div class="templatemo-flex-row flex-content-row">
           <div class="templatemo-content-widget white-bg col-2">
              <i class="fa fa-times"></i>
              <div class="media margin-bottom-30">
                <div class="media-left padding-right-25">
                  <a href="#">
                    <img class="media-object img-circle templatemo-img-bordered" src="images/person.jpg" alt="Sunset">
                  </a>
                </div> 
                <div class="media-body">
                  <h2 class="media-heading text-uppercase blue-text">John Barnet</h2>
                  <p>Project Manager</p>
                </div>        
              </div>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td><div class="circle green-bg"></div></td>
                      <td>New Task Issued</td>
                      <td>02</td>                    
                    </tr> 
                    <tr>
                      <td><div class="circle pink-bg"></div></td>
                      <td>Task Pending</td>
                      <td>22</td>                    
                    </tr>  
                    <tr>
                      <td><div class="circle blue-bg"></div></td>
                      <td>Inbox</td>
                      <td>13</td>                    
                    </tr>  
                    <tr>
                      <td><div class="circle yellow-bg"></div></td>
                      <td>New Notification</td>
                      <td>18</td>                    
                    </tr>                                      
                  </tbody>
                </table>
              </div>             
            </div>  -->
            <!-- <div class="templatemo-content-widget white-bg col-1 text-center templatemo-position-relative">
              <i class="fa fa-times"></i>
              <img src="images/person.jpg" alt="Bicycle" class="img-circle img-thumbnail margin-bottom-30">
              <h2 class="text-uppercase blue-text margin-bottom-5">Paul Smith</h2>
              <h3 class="text-uppercase margin-bottom-70">Managing Director</h3>
              <div class="templatemo-social-icons-container">
                <div class="social-icon-wrap">
                  <i class="fa fa-facebook templatemo-social-icon"></i>  
                </div>
                <div class="social-icon-wrap">
                  <i class="fa fa-twitter templatemo-social-icon"></i>  
                </div>
                <div class="social-icon-wrap">
                  <i class="fa fa-google-plus templatemo-social-icon"></i>  
                </div>                
              </div>
            </div>
            <div class="templatemo-content-widget white-bg col-1 templatemo-position-relative templatemo-content-img-bg">
              <img src="images/sunset-big.jpg" alt="Sunset" class="img-responsive content-bg-img">
              <i class="fa fa-heart"></i>
              <h2 class="templatemo-position-relative white-text">Sunset</h2>
              <div class="view-img-btn-wrap">
                <a href="" class="btn btn-default templatemo-view-img-btn">View</a>  
              </div>              
            </div>
          </div>
          <div class="pagination-wrap">
            <ul class="pagination">
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li class="active"><a href="#">3 <span class="sr-only">(current)</span></a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li>
                <a href="#" aria-label="Next">
                  <span aria-hidden="true"><i class="fa fa-play"></i></span>
                </a>
              </li>
            </ul>
          </div>          
          <footer class="text-right">
            <p>Copyright &copy; 2019.Company name All rights reserved.<a target="_blank" href="http://sc.chinaz.com/moban/">&#x7F51;&#x9875;&#x6A21;&#x677F;</a></p>
          </footer>         
        </div>
      </div>
    </div>
     -->
    <!-- JS -->
    <script type="text/javascript" src="../Home/js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
    <script type="text/javascript" src="../Home/js/templatemo-script.js"></script>      <!-- Templatemo Script -->
    <script>
      $(document).ready(function(){
        // Content widget with background image
        var imageUrl = $('img.content-bg-img').attr('src');
        $('.templatemo-content-img-bg').css('background-image', 'url(' + imageUrl + ')');
        $('img.content-bg-img').hide();        
      });
    
    
    
  


         /////////////////////////////////////////////贴士接收前端内容显示                      

  $(function(){
    $.ajax({
    
      url:"back_Userifo.php",
      dataType:"json",
      success:function(data){
     console.log(data);
    // ID="";
    User_name="";
    // Email="";
    // Phone_number="";
    // Note_text="";
    $.each(data,function(a,b){
      
    User_name=User_name+"<td>"+b.id+"</td>"
    // User_name=User_name+"<td>"+b.Username+"</td>"
    // Email=Email+"<td>"+b.email+"</td>"
    // Phone_number=Phone_number+"<td>"+b.phone_number+"</td>"
    // Note_text=Note_text+"<td>"+b.Note+"</td>"
    })
    // $("#tbody").append(ID);
    $("#tbody").append(User_name);
    // $("#tbody2").append(Email);
    // $("#tbody3").append(Phone_number);
    // $("#tbody4").append(Note_text);
      }
    
    
    })
    }) 
     

     
</script>   

  </body>
</html>