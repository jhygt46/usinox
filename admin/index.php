<?php
    
    if(isset($_GET["accion"]) && $_GET["accion"] == "logout"){
        setcookie("id_user", "", time() - 3600, "/admin");
        setcookie("secure_hash", "", time() - 3600, "/admin");
        die('<meta http-equiv="refresh" content="0; url=/admin">');
    }
    if(!isset($_COOKIE['id_user']) || !isset($_COOKIE['secure_hash'])){
        include("login.php");
    }else{
        require "class/admin_class.php";
        $admin = new Admin();
        $res = $admin->verificar_usuario();
        if($res['op']){
            include("inicio.php");
        }else{
            die('<meta http-equiv="refresh" content="0; url=/admin?accion=logout">');
        }
    }

?>
