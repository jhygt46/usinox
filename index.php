    <?php

        date_default_timezone_set('america/santiago');
        
        /*
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        */

        require "index_class.php";
        $core = new Core();
        $inicio = $core->iniciar();
                
        
    ?>

    <html>
        <head>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
            <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Google+Sans:400,500,700|Signika:300,400,500,700">
            <script src="js/base.js" type="text/javascript"></script>
            <link rel="stylesheet" type="text/css" href="css/base.css"/>
        </head>
        <body>
            <div class="contenedor">
                <div class="menu">
                    <div class="btn_toogle" onclick="tooglemenu(this)"><div class="b b1"></div><div class="b b2"></div><div class="b b3"></div></div>
                    <div class="titulo"></div>
                    <div class="opciones"></div>
                </div>
                <div class="sitio">
                    <div class="header">
                        <div class="logo"><a href="/"><img src="images/logo.jpg" alt="" /></a></div>
                        <div class="tmenu">
                            <div class="btn b2"><a href="">Nosotros</a></div>
                            <div class="btn b3"><a href="">Servicios</a></div>
                            <div class="btn b4"><a href="">Novedades</a></div>
                            <div class="btn b5"><a href="">Ofertas</a></div>
                            <div class="btn b7"><a href="">Contacto</a></div>
                        </div>
                    </div>
                    <div class="medio clearfix">
                        <div class="pmenu">
                            <div class="nav">
                                <div class="lp">CATEGORIAS</div>
                                <div class="ls"><a href="/cat/Cocina-Caliente/">Cocina Caliente</a></div>
                                <div class="ls"><a href="/cat/Cocina-Fria/2">Cocina Fria</a></div>
                                <div class="ls"><a href="/cat/Zona-Lavado/3">Zona Lavado</a></div>
                                <div class="ls"><a href="/cat/Zona-snack/4">Zona snack</a></div>
                                <div class="ls"><a href="/cat/Autoservicio/5">Autoservicio</a></div>
                                <div class="ls"><a href="/cat/Bodega-y-Almacenaje/6">Bodega y Almacenaje</a></div>
                                <div class="ls"><a href="/cat/Zona-Bar/7">Zona Bar</a></div>
                                <div class="ls"><a href="/cat/Equipamento-Menor/8">Equipamento Menor</a></div>
                                <div class="ls"><a href="https://www.usinox.cl/productos/Food truck/9">Food truck</a></div>
                                <div class="ls"><a href="https://www.usinox.cl/productos/Usados/Seccion%20Usados-1">Usados</a></div>
                                <div class="ls"><a href="https://www.usinox.cl/cocinas-industriales">Todos los Productos</a></div>
                            </div>
                            <div class="btnvideos">
                                <a href="http://www.usinox.cl/videos" class="myButton">Ver Videos</a>
                            </div>
                            <a href="https://www.webpay.cl/portalpagodirecto/pages/institucion.jsf?idEstablecimiento=22102112" style="display: block; text-align: center"><img src="images/Webpay.jpg" alt=""></a>
                        </div>
                        <div class="info">
                            <div class="data">
                                <div class="conthead clearfix">
                                    <div class="search">
                                        <div class="sh clearfix">
                                            <div class="l"></div>
                                            <div class="i"><input type="text" id="search" value=""></div>
                                            <div class="s"><a class="vhalign" href="">BUSCAR</a></div>
                                        </div>
                                    </div>
                                    <div class="carro">
                                        <div class="ca clearfix">
                                            <div class="icon"></div>
                                            <div class="item"><div class="txt vhalign">0 Item</div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="aviso">***No olvide Seleccionar los Productos para Recibir en linea Cotizacion en su e-mail***</div>
                                <div class="carrusel">
                                    <div class="foto fo1"><img src="images/foto1.jpg" alt="" /></div>
                                    <div class="foto fo2 none"><img src="images/foto2.jpg" alt="" /></div>
                                    <div class="foto fo3 none"><img src="images/foto3.jpg" alt="" /></div>
                                    <div class="flecha f1 valign" onclick="next(-1)"><img src="images/flechaleft.png" alt=""></div>
                                    <div class="flecha f2 valign" onclick="next(1)"><img src="images/flecharight.png" alt=""></div>
                                </div>
                                <table class="otros" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td class="otro ot1" valign="middle"><div class="t1">NOTICIAS</div><div class="t2">Lee todas nuestras noticias</div></td>
                                        <td class="otro ot2" valign="middle"><div class="t1">PROYECTOS</div><div class="t2">Revisa todos nuestros proyectos</div></td>
                                        <td class="otro ot3" valign="middle"><div class="t1">GALERIA</div><div class="t2">Mira nuestra galeria de imagenes</div></td>
                                    </tr>
                                </table>
                                <div class="titulo"><div class="nombre">Vitrina de productos</div></div>
                                <div class="lista_productos clearfix">

                                    <?php
                                        echo "<pre>";
                                        print_r($inicio);
                                        echo "</pre>";
                                    ?>


                                    <?php if($_GET["tipo"] == 1){ ?>
                                    <?php for($i=0; $i<10; $i++){ ?>
                                    <div class="producto">
                                        <div class="pro">
                                            <div class="c_pro">
                                                <div class="c_pfoto">
                                                    <img src="https://www.usinox.cl/foto.php?archivo=http://www.usinox.cl/admin/imagenes/572anafe_bajo_de_8_pl.jpg&ancho=218&alto=180" alt="" />
                                                </div>
                                                <div class="c_pttl">Anafe Bajo a Gas 8 platos</div>
                                                <div class="c_pdesc">Anafe bajo a gas de acero inoxidable AISI 304 de 8 quemadores de ø180mm, parrillas porta o</div>
                                                <div class="c_pbtn clearfix">
                                                    <div class="btn_cotizar">Cotizar</div>
                                                    <div class="btn_mostrar btn_mostrar_prod"><div class="txt">Mostrar</div><div class="punto valign"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }} ?>
                                    <?php if($_GET["tipo"] == 2){ ?>
                                    <?php for($i=0; $i<10; $i++){ ?>
                                    <div class="producto">
                                        <div class="pro">
                                            <div class="c_pro">
                                                <div class="c_pfoto">
                                                    <img src="https://www.usinox.cl/foto.php?archivo=http://www.usinox.cl/admin/imagenes/572anafe_bajo_de_8_pl.jpg&ancho=218&alto=180" alt="" />
                                                </div>
                                                <div class="c_pttl">Anafe Bajo a Gas 8 platos</div>
                                                <div class="c_pbtn clearfix">
                                                    <div class="btn_mostrar btn_ver_prod"><div class="txt">Ver Productos</div><div class="punto valign"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }} ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </body>
    </html>





    <?php exit; include("includes/header.php"); ?>
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
                    <ul class="otros clearfix">
                        <li style="background: #6f6f6f; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><a href='<?php echo $url; ?>/noticias' class='ti'>NOTICIAS</a><a href='<?php echo $url; ?>/noticias' class='tex'>Lee todas nuestras noticias</a></li>
                        <li style="background: #777;"><a href='<?php echo $url; ?>/proyectos' class='ti'>PROYECTOS</a><a href='<?php echo $url; ?>/proyectos' class='tex'>Revisa todos nuestros proyectos</a></li>
                        <li style="background: #808080; border-top-right-radius: 10px; border-bottom-right-radius: 10px;"><a href='<?php echo $url; ?>/galeria' class='ti'>GALERIA</a><a href='<?php echo $url; ?>/galeria' class='tex'>Mira nuestra galeria de imagenes</a></li>
                    </ul>
                    <div class='title'>Vitrina de productos</div>
                    <div class='productos clearfix'>
                        <?php 
                        $i = 1;
                        $result = mysql_query("SELECT * FROM productos WHERE foto!='' AND visibilidad='0' AND id_ficha!='1' ORDER BY RAND() LIMIT 9");
                        while($row = mysql_fetch_array($result)){ 
                            if($i%3 == 1){ $class="ss"; }else{ $class=""; }
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