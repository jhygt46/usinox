    <?php

        date_default_timezone_set('america/santiago');
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
                                <?php for($i=0; $i<count($inicio['base']); $i++){ ?>
                                <div class="ls"><a href="<?php echo $inicio['base'][$i]['urls']; ?>"><?php echo $inicio['base'][$i]['nombre']; ?></a></div>
                                <?php } ?>
                                <div class="ls"><a href="/todos-los-productos">Todos los Productos</a></div>
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
                                        /*
                                        echo "<pre>";
                                        print_r($inicio);
                                        echo "</pre>";
                                        */
                                    ?>
                                    <?php if(isset($inicio['pro'])){ ?>
                                    <div class="detalle_producto">
                                        <div class="pro_info"></div>
                                        <div class="pro_fotos"></div>
                                    </div>
                                    <?php } ?>
                                    <?php if(isset($inicio['childs_pro'])){ foreach ($inicio['childs_pro'] as $valor){ ?>
                                    <div class="producto">
                                        <div class="pro">
                                            <div class="c_pro">
                                                <div class="c_pfoto">
                                                    <a class="link" href="<?php echo $valor['urls']; ?>"><img src="https://www.usinox.cl/foto.php?archivo=http://35.202.149.15/uploads/images/<?php echo $valor['fotos'][0]; ?>&ancho=218&alto=180" alt="" /></a>
                                                </div>
                                                <div class="c_pttl"><?php echo $valor['nombre']; ?></div>
                                                <div class="c_pdesc"><?php echo $valor['descripcion']; ?></div>
                                                <div class="c_pbtn clearfix">
                                                    <div class="btn_cotizar">Cotizar</div>
                                                    <div class="btn_mostrar btn_mostrar_prod"><div class="txt">Mostrar</div><div class="punto valign"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }} ?>
                                    <?php if(isset($inicio['childs_cat'])){ for($i=0; $i<count($inicio['childs_cat']); $i++){ $foto = ($inicio['childs_cat'][$i]['foto'] == "") ? "sin_imagen.jpg" : $inicio['childs_cat'][$i]['foto'] ; ?>
                                    <div class="producto">
                                        <div class="pro">
                                            <a class="link" href="<?php echo $inicio['childs_cat'][$i]['urls']; ?>">
                                            <div class="c_pro">
                                                <div class="c_pfoto">
                                                    <img src="https://www.usinox.cl/foto.php?archivo=http://35.202.149.15/uploads/images/<?php echo $foto; ?>&ancho=218&alto=180" alt="" />
                                                </div>
                                                <div class="c_pttl"><?php echo $inicio['childs_cat'][$i]['nombre']; ?></div>
                                                <div class="c_pbtn clearfix">
                                                    <div class="btn_mostrar btn_ver_prod"><div class="txt">Ver Productos</div><div class="punto valign"></div></div>
                                                </div>
                                            </div>
                                            </a>
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