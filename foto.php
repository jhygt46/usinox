<?php

function hexcolor($c) {
       $r = ($c >> 16) & 0xFF;
       $g = ($c >> 8) & 0xFF;
       $b = $c & 0xFF;
       return '#'.str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}


if($_GET["ancho"] == "")
$anchode = 100;
else
$anchode = $_GET["ancho"];


if($_GET["alto"] == "")
$altode = 100;
else
$altode = $_GET["alto"];


$file = $_GET["archivo"];

//si es JPG

        $origen = @imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/".$file);

        imagecolorallocate($origen, 255, 0, 0);

        $imgAncho= @imagesx($origen);

        $imgAlto = @imagesy($origen);

        $alto = @intval($anchode*$imgAlto/$imgAncho);

		

		

		if($alto > $altode)

		{

		$altosof = $altode;

		$anchosof = @intval($altosof*$imgAncho/$imgAlto);

		$difancho = $anchode - $anchosof;

		$difancho = $difancho / 2;

		}

		

		$ancho = @intval($altode*$imgAncho/$imgAlto);

	    if($ancho >= $anchode)

		{

		$anchosof = $anchode;

		$altosof = @intval($anchosof*$imgAlto/$imgAncho);

		$difalto = $altode - $altosof;

		$difalto = $difalto / 2;

		}



//for($y = 0;$y < $imgAlto;++$y){

//for($x = 0;$x < $imgAncho;++$x){

$x = 0;

$y = 0;

$current_color = imagecolorat($origen, $x, $y);



//break;

//}

//break;

//}   

		

		

$current_color2 = hexcolor($current_color);



for($i = 0; $i < strlen($current_color2); $i++)

{

if($current_color2[$i] == "a")

$colorfinal[$i] = "10";

if($current_color2[$i] == "b")

$colorfinal[$i] = "11";

if($current_color2[$i] == "c")

$colorfinal[$i] = "12";

if($current_color2[$i] == "d")

$colorfinal[$i] = "13";

if($current_color2[$i] == "e")

$colorfinal[$i] = "14";

if($current_color2[$i] == "f")

$colorfinal[$i] = "15";

if($current_color2[$i] < "10")

$colorfinal[$i] = $current_color2[$i];

}



$red1 = $colorfinal[1];

$red2 = $colorfinal[2];

$green1 = $colorfinal[3];

$green2 = $colorfinal[4];

$blue1 = $colorfinal[5];

$blue2 = $colorfinal[6]; 







$red = $red2 + ($red1 * 16);

$green = $green2 + ($green1 * 16);

$blue = $blue2 + ($blue1 * 16);

			   

			   

        $imagen  = @imagecreatetruecolor($anchode,$altode);
	    imagefill($imagen,0,0,imagecolorallocate($imagen, $red, $green, $blue));
        @imagecopyresampled($imagen,$origen,$difancho,$difalto,0,0,$anchosof,$altosof,$imgAncho,$imgAlto);
        @imagejpeg($imagen);

//si es PNG
/*
        $origen  = @imageCreateFromPNG($file);

        $imgAncho= @imageSx($origen);

        $imgAlto = @imageSy($origen);

        $alto = @intval($ancho*$imgAlto/$imgAncho);

        $imagen  = @imageCreatetruecolor($ancho,$alto);

        @ImageCopyResampled($imagen,$origen,0,0,0,0,$ancho,$alto,$imgAncho,$imgAlto);

        @imagePNG($imagen);

//si es GIF

        $origen  = @imageCreateFromGIF($file);

        $imgAncho= @imageSx($origen);

        $imgAlto = @imageSy($origen);

        $alto = @intval($ancho*$imgAlto/$imgAncho);

        $imagen  = @imageCreatetruecolor($ancho,$alto);

        @ImageCopyResampled($imagen,$origen,0,0,0,0,$ancho,$alto,$imgAncho,$imgAlto);



imagetruecolortopalette($imagen, false, 256); 



$white = imagecolorresolve($imagen, 0, 0, 0); 

//le pone fondo transparente

imagecolortransparent($imagen, $white); 



imageGif($imagen);  

*/

?>