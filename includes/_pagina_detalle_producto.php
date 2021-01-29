<?php
    /*

    echo "<pre>";
    print_r($inicio['pro']);
    echo "</pre>";

    En el admin ver que foto es
    Destacar hover de categorias
    Marca / Modelo
    Stock
    Descargar Ficha - Manual
    Favicon
    Fotos

    Texto justificado

    */
?>
<div class="titulo"><div class="nombre"><?php if(isset($inicio['parents'])){ echo $inicio['parents']; } ?></div></div>
<div class="lista_productos clearfix">
<?php if(isset($inicio['pro'])){ ?>
    <div class="detalle_producto clearfix">
        <div class="pro_info">
            <div class="titulo_pro"><?php echo $inicio['pro']['nombre']; ?></div>
            <div class="cotizar_pro clearfix">
                <div class="cotizar_pro1">Cant</div>
                <div class="cotizar_pro2"><input type="text" id="pro_cant" value="1"></div>
                <div class="cotizar_pro3"><div class="btn" onclick="cotizar(<?php echo $inicio['pro']['id_pro']; ?>, 0)">Cotizar</div></div>
            </div>
            <div class="desc_ttl">Descripcion</div>
            <div class="desc_pro"><?php echo $inicio['pro']['descripcion']; ?></div>
            <div class="descarga clearfix">
                <div class="manual">Descargar Manual</div>
                <div class="ficha">Descargar Ficha</div>
            </div>
            <div class="redes clearfix">
                <div class="red1"></div>
                <div class="red2"></div>
                <div class="red3"></div>
            </div>
        </div>
        <div class="pro_fotos">
            <div class="pro_fotos_principal"><img src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $inicio['pro']['fotos'][0]; ?>&ancho=218&alto=180" alt="" /></div>
            <div class="pro_fotos_otras clearfix">
            <?php if(count($inicio['pro']['fotos']) > 1){ ?>
                <?php for($i=1; $i<count($inicio['pro']['fotos']); $i++){ ?>
                    <div class="foto_prev"><img src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $inicio['pro']['fotos'][$i]; ?>&ancho=218&alto=180" alt="" /></div>
                <?php } ?>
            <?php } ?>
            </div>
        </div>
    </div>
    <div class="producto_relacionados">
        <div class="titulo_relacionados">Productos Relacionados</div>
        <div class="cont_relacionados cleafix">
            <?php foreach ($inicio['pro']['relacionados'] as $valor){ ?>
                <a href="/<?php echo $valor['url']; ?>" class="item_relacionados">
                    <img src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $valor['fotos'][$i]; ?>&ancho=218&alto=180" alt="" />
                    <div class="rel_name"><?php echo $valor['nombre']; ?></div>
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
</div>