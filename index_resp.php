<?php

	if($_SERVER['HTTPS']!="on"){
     		$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     		header("Location:$redirect");
  	}

?>

<?php include("includes/header.php"); ?>
    <script> $('document').ready(info_cotizacion(true));</script>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KQQ859V"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <input type="hidden" id="layer" value="0" />

        <div id="cont">

            <?php include("includes/nav.php"); ?>

            <div class="content clearfix">

                <?php include("includes/menu.php"); ?>

                <div class="contenido">

                    <?php include("includes/searchcart.php"); ?>

                    <div class="carrusel" style="margin-top: 10px;">

                        <ul class="dd clearfix">

                            <a href="<?php echo $url; ?>/todos-los-productos"><li class="li" style="background:url('images/foto1.jpg');width:830px;height:300px;float:left;border-radius:10px;"></li></a>

                            <a href="<?php echo $url; ?>/ofertas"><li class="li" style="background:url('images/foto2.jpg');width:830px;height:300px;float:left;border-radius:10px;"></li></a>

                            <a href="<?php echo $url; ?>/novedades"><li class="li" style="background:url('images/foto3.jpg');width:830px;height:300px;float:left;border-radius:10px;"></li></a>

                        </ul>

                        <div class="flecha f1"><img src="images/flechaleft.png" alt='' /></div>

                        <div class="flecha f2"><img src="images/flecharigth.png" alt='' /></div>

                    </div>
		    <?php 

			$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
			$fecha_entrada = strtotime("21-09-2018 23:59:00");
			if($fecha_actual < $fecha_entrada){
	
				echo "<div style='display: block; background-color: #ccc; margin-top: 25px'><img src='banner.jpg'></div>";			

			}

		    ?>
                    <ul class="otros clearfix">

                        <li style="background: #6f6f6f; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><a href='<?php echo $url; ?>/noticias' class='ti'>NOTICIAS</a><a href='<?php echo $url; ?>/noticias' class='tex'>Lee todas nuestras noticias</a></li>

                        <li style="background: #777;"><a href='<?php echo $url; ?>/proyectos' class='ti'>PROYECTOS</a><a href='<?php echo $url; ?>/proyectos' class='tex'>Revisa todos nuestros proyectos</a></li>

                        <li style="background: #808080; border-top-right-radius: 10px; border-bottom-right-radius: 10px;"><a href='<?php echo $url; ?>/galeria' class='ti'>GALERIA</a><a href='<?php echo $url; ?>/galeria' class='tex'>Mira nuestra galeria de imagenes</a></li>

                    </ul>

                    <!--<div class='subbtn clearfix'>

                        <div class='sub'>

                            <a href="<?php echo $url; ?>/nuestra-empresa">

                                <ul class="clearfix">

                                    <li class='a'><img src="images/sub1.jpg" alt='' /></li>

                                    <li class='b'>Nuestra <br/> Empresa</li>

                                </ul>

                            </a>

                        </div>

                        <div class='sub lk'>

                            <a href="<?php echo $url; ?>/servicio-tecnico">

                                <ul class="clearfix">

                                    <li class='a'><img src="images/sub2.jpg" alt='' /></li>

                                    <li class='b'>Servicio <br/> T&eacute;cnico</li>

                                </ul>

                            </a>

                        </div>

                        <div class='sub'>

                            <a href="<?php echo $url; ?>/arriendos">

                                <ul class="clearfix">

                                    <li class='a'><img src="images/sub3.jpg" alt='' /></li>

                                    <li class='b'>Secci&oacute;n <br/> Ariendos</li>

                                </ul>

                            </a>

                        </div>

                        <div class='sub lk'>

                            <a href="<?php echo $url; ?>/usados">

                                <ul class="clearfix">

                                    <li class='a'><img src="images/sub4.jpg" alt='' /></li>

                                    <li class='b'>Secci&oacute;n <br/> Usados</li>

                                </ul>

                            </a>

                        </div>

                    </div>-->

                    <div class='title'>Vitrina de productos</div>

                    <div class='productos clearfix'>

                        <?php 

                        

                        $i = 1;

                        $result = mysql_query("SELECT * FROM productos WHERE foto!='' AND visibilidad='0' AND id_ficha!='1' ORDER BY RAND() LIMIT 9");

                        while($row = mysql_fetch_array($result)){ 



                            if($i%3 == 1){

                                $class="ss";  

                            }else{

                                $class="";

                            }



                        $i++;

                        ?>



                        <div class="pro <?=$class;?>">

                            <div class="foto"><img src='<?php echo $url; ?>/foto.php?archivo=http://www.usinox.cl/admin/imagenes/<?php echo $row["foto"]; ?>&ancho=218&alto=180' alt=''/></div>

                            <div class="titulo"><?=htmlentities($row["titulo"])?></div>

                            <div class="desc"><?=htmlentities(substr($row["descripcion"],0, 90))?></div>

                            <ul class="clearfix">

                                <li class="l1"><a onclick="return cotizar(<?php echo $row["id"]; ?>,1)" href="" >Agregar al carro</a></li>

                                <li class="l2"><a href="<?php echo $url; ?>/detalle/<?=htmlentities(str_replace(" ", "-", $row["titulo"]))?>-<?php echo $row["id"]; ?>" >Ver mas</a></li>

                            </ul>

                        </div>

                        

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

        <?php include("includes/footer.php"); ?>

        	

    </body> 

</html>