<?php

    $fotos = json_decode(file_get_contents("http://www.usinox.cl/lista_fotos.json"));
    
    for($i=1; $i<count($fotos); $i++){
        if($fotos[$i] != ""){
            $file = explode(".", $fotos[$i]);
            $url = "http://www.usinox.cl/admin/imagenes/".$fotos[$i];
            $img1 = "uploads/images/".$file[0]."0.".$file[1];
            $img2 = "uploads/images/".$file[0]."1.".$file[1];
            file_put_contents($img1, file_get_contents($url));
            copy($img1, $img2);
        }
    }
    

?>