<?php

function getSk($w, $h, $pz, $arr){
	$pz_sum = $pz;
	$sum = $w * $h;
	$c = 255;
	foreach ($pz_sum as $k => $n){
		$gk[$k] = intval( $c * $pz_sum[$k] ) ;
	}

	$g = array_flip( array_unique($gk));

	$pk = array();
	$sk = array();
	$sk1 = array();
	foreach ($arr as $k => $n){
		$pk[$k] = $n / $sum;
		$sk1[$k] = intval( $c * array_sum($pk) ) ;

		$j = $sk1[$k];
		while( ! isset($g[$j]) && $j>=0 ) $j--;
		if($j== -1)
			while( ! isset($g[$j])) $j++;
		$sk[$k] = $g[$j];
	}

	return $sk;
}
///draw the image
function draw($w,$h,$temp_path2,$pos,$sk){
	$img2 = imagecreate($w, $h);

	for($i=0;$i<256;$i++){
		$color[$i] = imagecolorallocate($img2, $i, $i, $i);
	}

	for($i=0;$i<$h;$i++){
		for($j=0;$j<$w;$j++){

			$r = $pos[$i][$j];
			$s = $sk[ $r ];
			imagesetpixel($img2, $j, $i, $color[$s]);
		}
	}

	imagejpeg($img2,$temp_path2);
	imagedestroy($img2);
	return $temp_path2;
}

function getNormalDensity($u_stand){
    if($u_stand<-3.99)return 0;
    if($u_stand>3.99)return 1;
    $foot=-3.99;
    $step=0.01;
    $result=0.000033;
    for($i=$foot+$step;$i<$u_stand;$i+=$step){
        $result+=(1/sqrt(2*pi())*exp(-$i*$i/2)/100);
    }
    return round($result,6);
}

function getNomal($x,$u=128){
	return getNormalDensity(  3 * ($x - $u) / $u );	
}

function getNomalArr(){	
	static $pz_sum= array();
	
	for($i=0; $i<256; $i++){		
		$pz_sum[$i] = getNomal($i);
	}
	return $pz_sum;
}

function getJhArr(){
	static $pz_sum= array();

	for($i=0; $i<256; $i++){
		$pz_sum[$i] = $i / 255;
	}
	return $pz_sum;
}


function getTriangleArr($reverse=false){
	static $pz= array();
	static $pz_sum= array();
		
	for($i=0; $i<256; $i++){
		if($reverse)
			$pz[$i] = (1 - $i / 255) / 128 ;
		else
			$pz[$i] = $i / (128 * 255);
		
		$pz_sum[$i] = $pz_sum[ ($i-1)<0 ? 0 : $i-1 ] + $pz[$i];
	}
 	return $pz_sum;
}
