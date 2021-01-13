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
            <div class="i"><input type="text" id="search" value=""></div>
            <div class="s" onclick="search()"><div class="vhalign" href="">BUSCAR</div></div>
        </div>
    </div>
    <a href="/cotizador" class="carro">
        <div class="ca clearfix">
            <div class="icon"></div>
            <div class="item"><div class="txt vhalign"><?php echo $count; ?> Item</div></div>
        </div>
    </a>
</div>
<div class="aviso">***No olvide Seleccionar los Productos para Recibir en linea Cotizacion en su e-mail***</div>