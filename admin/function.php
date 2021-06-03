<?php 
session_start();
function cap(){
header('Content-Type:image/jpeg'); 
//iamgecreateturecolor 为一副图像分配样式；
$img = imagecreatetruecolor(100, 40); 

$black = imagecolorallocate($img, 0x00, 0x00, 0x00); 

$white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF); 

$qingse = imagecolorallocate($img, 22, 160, 133); 

imagefill($img,0,0,$qingse); //生成随机的验证码 

$code = ''; 

for($i = 0; $i < 4; $i++) { $code .= rand(0, 9); }
$_SESSION['gg_code']=$code; 
 //imagestring ($img,此参数默认为1.2.3.4.5字体大小,text参数可调整,x轴,y轴，数字$code,还有点点点，$Black)
 //添加一个空格的函数
 $show_vcode="";
 for($i=0,$max=strlen($code);$i<$max;$i++){
    $show_vcode .= $code[$i].((mt_rand(0,100)>50)?" ":"");
}
     
$sttr=imagestring($img, 5, 15, mt_rand(0,25), $show_vcode, $black); 



//加入噪点干扰 

for($i=0;$i<300;$i++) { 

 imagesetpixel($img, rand(0, 100) , rand(0, 100) , $black); 

 imagesetpixel($img, rand(0, 100) , rand(0, 100) , $white); 



// //加入干扰线
// imagesetthickness($img,1);
// // Xzhou  线的数目， 线长度，
// imageline($img,10,mt_rand(0,5),70,mt_rand(0,5),$white);
// imageline($img,10,mt_rand(0,5),70,mt_rand(0,5),$white);
} //输出验证码 header("content-type: image/png"); 

imagepng($img); 
imagedestroy($img); 
header("Content-Type: image/png");//输出图像
die();
}

?>