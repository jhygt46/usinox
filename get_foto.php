<?php

    $file = explode(".", $_GET["file"]);
    $url = "http://www.usinox.cl/admin/imagenes/".$_GET["file"];
    $img1 = "uploads/images/".$file[0]."0.".$file[1];
    $img2 = "uploads/images/".$file[0]."1.".$file[1];

    file_put_contents($img1, file_get_contents($url));
    file_put_contents($img2, file_get_contents($url));
    
?>