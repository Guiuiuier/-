<?php
include_once 'function.php';
// cap();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>后台管理系统登录</title>
    <meta name="author" content="DeathGhost" />
    <link rel="stylesheet" type="text/css" href="../Home/css/login.css" tppabs="css/login.css" />
    <style>
        body {
            height: 100%;
            background: #16a085;
            overflow: hidden;
        }

        canvas {
            z-index: -1;
            position: absolute;
        }
    </style>
    <script src="../Home/js/jquery.js"></script>
    <script src="../Home/js/verificationNumbers.js" tppabs="../Home/js/verificationNumbers.js"></script>
    <script src="../Home/js/Particleground.js" tppabs="../Home/js/Particleground.js"></script>
    <script>
        $(document).ready(function() {
                //粒子背景特效
                $('body').particleground({
                    dotColor: '#5cbdaa',
                    lineColor: '#5cbdaa'
                }); 
            }

        );
    </script> 
</head>

<body>

<!-- autocomplete="off" 关闭缓存 -->
    <dl class="admin_login"><dt><strong>后台管理系统</strong><em>Management System</em></dt>
        <form action="back-stage.php" method="post">
            <dd class="user_icon"><input type="text" placeholder="账号" class="login_txtbx" name="user" required="true" autocomplete="off"/></dd>
            <dd class="pwd_icon"><input type="password" placeholder="密码" class="login_txtbx" name="pwd"required="true" /></dd>
            <input type="text" name="check" class="fsg1" required="true" maxlength="4" style="text-align:center;" autocomplete="off">
           <script type="text/javascript"> function shuaxin() {document.getElementById("code").src = "captcha.php?"+Math.random(); } </script> 
            <img id="code" src="captcha.php" onclick="shuaxin()" /> 
            <span onclick="shuaxin()" class="login_txtbx">看不清？</span><br /></div>
            <dd><input type="submit" value="立即登陆" class="submit_btn" />
             
          </form>
          
            </dd>
            <dd></dd>
    </dl>
</body>

</html>