<?php

include_once 'func.php';

if($_POST){
	
	$name = $_POST['img-name'];
}
else
	$name = 'sunshine.jpg';
$path = 'img/'.$name;
$temp_path = 'img/grey_'.$name;
$temp_path1 = 'img/jh_'.$name;
$temp_path2 = 'img/zsj_'.$name;
$temp_path3 = 'img/fsj_'.$name;
$temp_path4 = 'img/zt_'.$name;


//ignore_user_abort();//
set_time_limit(0);//
//create img
$img = imagecreatefromjpeg($path);

//2grey, save the grey image
imagefilter($img, IMG_FILTER_GRAYSCALE);
imagejpeg($img,$temp_path);

$w = ImageSX($img);
$h = ImageSY($img);

$arr1 = array();
$pos = array();
for($i=0;$i<$h;$i++){
	for($j=0;$j<$w;$j++){
		$rgb = imagecolorat ($img, $j, $i);
		$r = ($rgb >> 16) & 0xFF; //
		$pos[$i][$j] = $r;		
		$arr1[$r]++;
	}	
}

imagedestroy($img);

$arr = array();//
for($i=0;$i<256;$i++){
	if(isset($arr1[$i]))
		$arr[$i] = $arr1[$i];
	else $arr[$i] = 0;	
}


$pz0 = getJhArr();
$sk0 =  getSk($w, $h, $pz0, $arr);
$temp_path1 = draw($w,$h,$temp_path1,$pos,$sk0);

$pz = getTriangleArr();
$sk =  getSk($w, $h, $pz, $arr);
$temp_path2 = draw($w,$h,$temp_path2,$pos,$sk);

$pz1 = getTriangleArr(true);
$sk1 =  getSk($w, $h, $pz1, $arr);
$temp_path3 = draw($w,$h,$temp_path3,$pos,$sk1);

$pz2 = getNomalArr();
$sk2 =  getSk($w, $h, $pz2, $arr);
$temp_path4 = draw($w,$h,$temp_path4,$pos,$sk2);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Demo</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<style>
img{width:32%}
</style>
</head>
<body>
<div class="row container">
	<div class="hero-unit span12">
		<h1>Welcome to DIP</h1>
		<p><a class="btn btn-primary btn-large" href="https://github.com/allen-zh/dip">
	      	Source code at Github
	    </a></p>
		
		<p>(可以在新窗口打开或者下载查看大图，上传功能开发中..)</p>
	    <form method="post">
	    选择一张图片
	    <select name="img-name">
	    	<option value="oneday.jpg">oneday</option>
	    	<option  value="sunshine.jpg">sunshine</option>
	    	<option  value="girl.jpg">girl</option>
	    	<option  value="pollen.jpg">pollen</option>
	    </select>
	    <input type="submit" value="Submit">
	    </form>
	    
	    <p>原图 / 灰度图 / 均衡化</p>
		<p>正三角分布 / 反三角分布 / 正态分布</p>
	</div>
	

	<div class="well span12">
		<span>
		<img src="<?php echo $path?>" />
		</span>
		<span>
		<img src="<?php echo $temp_path?>" />
		</span>
		<span>
		<img src="<?php echo $temp_path1?>" />
		</span>
		<br>
		<hr>
		<span>
		<img src="<?php echo $temp_path2?>" />
		</span>
		<span>
		<img src="<?php echo $temp_path3?>" />
		</span>
		<span>
		<img src="<?php echo $temp_path4?>" />
		</span>
	</div>

</div>
</body>
</html>