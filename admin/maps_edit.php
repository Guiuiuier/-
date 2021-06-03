<?php



// 用户查询！！
include "../admin/config.inc.php";
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$mysqli -> set_charset(DB_CHARSET);
	 if ($mysqli -> connect_error) {

	    	die("连接错误：".$mysqli -> connect_error);

     }
     

$edit =$_GET['edit'];
$sql ="select * from essay where id=$edit";
 $result = $mysqli -> query($sql);
 
  while ($row = $result -> fetch_assoc()) {
		$rows[] = $row;   //$rows中保存user表中所有记录
      }
    //   var_dump($rows);




?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preferences</title>
    <meta name="description" content="">
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'> -->
    <link href="../Home/css/font-awesome_m.min.css" rel="stylesheet">
    <link href="../Home/css/bootstrap_m.min.css" rel="stylesheet">
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
          <h1>用户编辑</h1>
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
          
      </div>
       <!-- Main content --> 
       <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
          <div class="row">
            <nav class="templatemo-top-nav col-lg-12 col-md-12">
              <ul class="text-uppercase">
                <li><a href="maps.php">退出编辑</a></li>
              </ul>  
            </nav> 
          </div>
        </div>
        <div class="templatemo-content-container">
          <div class="templatemo-content-widget white-bg">
            <h2 class="margin-bottom-10">管理员文章编辑</h2>
            <p>可以在此编辑当前文章</p>
            <form action="maps_edit_1.php?edit=<?php echo $edit;?>" class="templatemo-login-form" method="post" enctype="multipart/form-data">
              <div class="row form-group">
              
                <div class="col-lg-6 col-md-6 form-group">                  
                    <label for="inputFirstName">分类</label>
                    <!-- autocomplete="off" 关闭缓存 -->
                    <input type="text" class="form-control" id="inputFirstName"  name="section" required="true"autocomplete="off" maxlength="20" value="<?php echo $rows[0]['section'] ?>" >                  
                </div>
                <div class="col-lg-6 col-md-6 form-group">                  
                    <label for="inputLastName">标题</label>
                    <input type="" class="form-control" id="inputLastName"  name="title" required="true"autocomplete="off"value="<?php echo $rows[0]['title'] ?>">                  
                </div> 
              </div>
              <div class="row form-group">
                <div class="col-lg-12 form-group">                  
                    <label for="inputEmail">作者</label>
                    <input type="联系方式" class="form-control" id="inputEmail" name="writer" required="true"autocomplete="off" value="<?php echo $rows[0]['writer'] ?>">                  
                </div> 
            
                <div class="col-lg-12 form-group">                  
                    <label for="inputEmail">内容</label>

                      <!-- 在textarea 里面不可 value值 要在<>  该处填写值</> -->
                    <textarea rows="5"  type="内容" class="form-control" id="inputEmail" placeholder="内容" name="content" required="true"autocomplete="off" ><?php echo $rows[0]['content'] ?></textarea>
                </div> 
              </div>
              <div class="form-group text-right">
                <input type="submit" class="templatemo-blue-button"></button>
                <!-- <input type="reset" class="templatemo-white-button"></button> -->
              </div>                           
            </form>
          </div>
           
        </div>
      </div>
    </div>

    <!-- JS -->
    <script type="text/javascript" src="../Home/js/jquery-1.11.2.min.js"></script>        <!-- jQuery -->
    <script type="text/javascript" src="../Home/js/bootstrap-filestyle.min.js"></script>  <!-- http://markusslima.github.io/bootstrap-filestyle/ -->
    <script type="text/javascript" src="../Home/js/templatemo-script.js"></script>        <!-- Templatemo Script -->









  </body>
</html>
