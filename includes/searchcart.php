<?php



    $count = 0;

    for($i=0; $i<count($_SESSION["prods"]); $i++){

            

        $count = $count + $_SESSION["prods"][$i]['cant'];



    }





?>

<div class="conthead clearfix">

    <div class="search">

        <div class="sh clearfix">

            <div class="l"></div>

            <div class="i"><input type="text" id="search" value="" ></div>

            <div class="s"><img class="sear" src="<?php echo $url; ?>/images/search.jpg" alt="" ></div>

        </div>

    </div>

    <div class="carro">

        <div class="ca clearfix">

            <div class="logo"><img src="<?php echo $url; ?>/images/carro.jpg" alt="" ></div>

            <div class="item"><a style="text-decoration: none; color: #E13535;" href="<?php echo $url; ?>/cotizador"><?php echo $count; ?> item</a></div>

        </div>

    </div>

</div>
<div style="margin-top: 10px"><span id="info_cotizacion" style="font-size: 18px; color:#CC3333; font-family:Verdana">***No olvide Seleccionar los Productos para Recibir en linea Cotizacion en su e-mail***</span></div>
