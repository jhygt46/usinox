<style>
    .myButton {
	-moz-box-shadow: 0px 3px 0px 0px #8a2a21;
	-webkit-box-shadow: 0px 3px 0px 0px #8a2a21;
	box-shadow: 0px 3px 0px 0px #8a2a21;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #c62d1f), color-stop(1, #f24437));
	background:-moz-linear-gradient(top, #c62d1f 5%, #f24437 100%);
	background:-webkit-linear-gradient(top, #c62d1f 5%, #f24437 100%);
	background:-o-linear-gradient(top, #c62d1f 5%, #f24437 100%);
	background:-ms-linear-gradient(top, #c62d1f 5%, #f24437 100%);
	background:linear-gradient(to bottom, #c62d1f 5%, #f24437 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#c62d1f', endColorstr='#f24437',GradientType=0);
	background-color:#c62d1f;
	-moz-border-radius:18px;
	-webkit-border-radius:18px;
	border-radius:18px;
	border:1px solid #d02718;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:17px;
	padding:7px 25px;
	text-decoration:none;
	text-shadow:0px 1px 0px #810e05;
        margin: 20px auto;
    }
    .myButton:hover {
            background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f24437), color-stop(1, #c62d1f));
            background:-moz-linear-gradient(top, #f24437 5%, #c62d1f 100%);
            background:-webkit-linear-gradient(top, #f24437 5%, #c62d1f 100%);
            background:-o-linear-gradient(top, #f24437 5%, #c62d1f 100%);
            background:-ms-linear-gradient(top, #f24437 5%, #c62d1f 100%);
            background:linear-gradient(to bottom, #f24437 5%, #c62d1f 100%);
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f24437', endColorstr='#c62d1f',GradientType=0);
            background-color:#f24437;
    }
    .myButton:active {
            position:relative;
            top:1px;
    }

</style>
<div class="nav">
    <ul>
        <li>CATEGORIAS</li>
        <?php
        
        $divfooter = "";
        
        include("conex.php");
        $r=0;
        $result = mysql_query("SELECT * FROM categorias ORDER BY id");
        while($row = mysql_fetch_array($result)){
            
        if($r == 0){
            $produrl = $url."/productos/".$row["nombre"]."/".$row["id"];
        }
        $r++;
        
        $divfooter .= "<a href=''>".htmlentities(str_replace("-"," ",$row["nombre"]))."</a>";
        
        ?>

            <li class="ls"><a style='display:block;' href='<?=$url?>/productos/<?=$row["nombre"]?>/<?=$row["id"]?>'><?=htmlentities(str_replace("-"," ",$row["nombre"]))?></a></li>

        <?php } ?>
        
        <li class="ls"><a style='display:block;' href='<?=$url?>/productos/Usados/Seccion%20Usados-1'>Usados</a></li>
        <li class="ls"><a style='display:block;' href='<?=$url?>/cocinas-industriales'>Todos los Productos</a></li>
        
    </ul>
    <div style="display: block; text-align: center;">
        <a href="http://www.usinox.cl/videos" class="myButton">Ver Videos</a>
    </div>
    <a href="https://www.webpay.cl/portalpagodirecto/pages/institucion.jsf?idEstablecimiento=22102112" style="display: block; text-align: center"><img src="images/Webpay.jpg" alt=""></a>
</div>
