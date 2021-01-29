<?php
    session_start();
    
    date_default_timezone_set('america/santiago');
    require "index_class.php";
    $core = new Core();
    $inicio = $core->iniciar();
    /*
    echo "<pre>";
    print_r($inicio);
    echo "</pre>";
    */
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Google+Sans:400,500,700|Signika:300,400,500,700">
        <script src="/js/base.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="/css/base.css"/>
    </head>
    <body>
        <div class="contenedor">
            <div class="menu">
                <div class="btn_toogle" onclick="tooglemenu(this)"><div class="b b1"></div><div class="b b2"></div><div class="b b3"></div></div>
                <div class="titulo">Usinox</div>
                <div class="opciones">
                    <div class="lp">CATEGORIAS</div>
                    <?php for($i=0; $i<count($inicio['base']); $i++){ ?>
                    <div class="ls"><a href="/<?php echo $inicio['base'][$i]['urls']; ?>"><?php echo $inicio['base'][$i]['nombre']; ?></a></div>
                    <?php } ?>
                    <!--<div class="ls"><a href="/todos-los-productos">Todos los Productos</a></div>-->
                </div>
                <div class="bajada"></div>
            </div>
            <div class="sitio">
                <?php include("includes/nav.php"); ?>
                <div class="medio clearfix">
                    <div class="pmenu">
                        <div class="nav">
                            <div class="lp">CATEGORIAS</div>
                            <?php for($i=0; $i<count($inicio['base']); $i++){ ?>
                            <a class="ls" href="/<?php echo $inicio['base'][$i]['urls']; ?>"><?php echo $inicio['base'][$i]['nombre']; ?></a>
                            <?php } ?>
                            <!--<div class="ls"><a href="/todos-los-productos">Todos los Productos</a></div>-->
                        </div>
                        <div class="btnvideos">
                            <a href="/videos" class="myButton">Ver Videos</a>
                        </div>
                        <a href="https://www.webpay.cl/portalpagodirecto/pages/institucion.jsf?idEstablecimiento=22102112" style="display: block; text-align: center"><img src="images/Webpay.jpg" alt=""></a>
                    </div>
                    <div class="info">
                        <div class="data">
                            <?php include("includes/searchcart.php"); ?>

                            <?php

                                switch ($inicio["tipo"]) {
                                    case "inicio":
                                        include("includes/_pagina_inicio.php");
                                        break;
                                    case "categorias":
                                        include("includes/_pagina_categorias.php");
                                        break;
                                    case "productos":
                                        include("includes/_pagina_productos.php");
                                        break;
                                    case "producto":
                                        include("includes/_pagina_detalle_producto.php");
                                        break;
                                    case "cotizador":
                                        include("includes/_pagina_cotizador.php");
                                        break;
                                    case "paginas":
                                        include("includes/_pagina_paginas.php");
                                        break;
                                    case "busqueda":
                                        include("includes/_pagina_busqueda.php");
                                        break;
                                    case "novedades":
                                        include("includes/_pagina_novedades.php");
                                        break;
                                    case "ofertas":
                                        include("includes/_pagina_ofertas.php");
                                        break;
                                    case "videos":
                                        include("includes/_pagina_videos.php");
                                        break;
                                    case "noticias":
                                        include("includes/_pagina_noticias.php");
                                        break;
                                    case "proyectos":
                                        include("includes/_pagina_proyectos.php");
                                        break;
                                    case "galeria":
                                        include("includes/_pagina_galeria.php");
                                        break;
                                }

                            ?>

                        </div>
                    </div>
                </div>
                <?php include("includes/footer.php"); ?>
            </div>
        </div>
    </body>
</html>