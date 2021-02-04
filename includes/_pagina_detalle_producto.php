<?php
    
    echo "<pre>";
    print_r($inicio['pro']);
    echo "</pre>";

    /*
    En el admin ver que foto es
    Marca / Modelo
    Stock
    Descargar Ficha - Manual
    Fotos
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
            <?php if($inicio['pro']['manual'] != "" && $inicio['pro']['ficha'] != ""){ ?>
            <div class="descarga clearfix">
                <?php if($inicio['pro']['manual'] != ""){ ?><div class="manual"><a href="/uploads/pdf/<?php echo $inicio['pro']['manual']; ?>">Descargar Manual</a></div><?php } ?>
                <?php if($inicio['pro']['ficha'] != ""){ ?><div class="ficha"><a href="/uploads/pdf/<?php echo $inicio['pro']['ficha']; ?>">Descargar Ficha</a></div><?php } ?>
            </div>
            <?php } ?>
            <?php if($inicio['pro']['marca'] != "" && $inicio['pro']['modelo'] != ""){ ?>
            <div class="info clearfix">
                <?php if($inicio['pro']['marca'] != ""){ ?><div class="marca"><div class="ttl">Marca</div><div class="nombre"><?php echo $inicio['pro']['marca']; ?></div></div><?php } ?>
                <?php if($inicio['pro']['modelo'] != ""){ ?><div class="modelo"><div class="ttl">Modelo</div><div class="nombre"><?php echo $inicio['pro']['modelo']; ?></div></div><?php } ?>
            </div>
            <?php } ?>
            <div class="redes clearfix">
                <div class="red1"></div>
                <div class="red2"></div>
                <div class="red3"></div>
            </div>
        </div>
        <?php $dim = getimagesize("uploads/images/".$inicio['pro']['fotos'][0]); ?>
        <div class="pro_fotos">
            <div class="pro_fotos_principal"><img src="/foto.php?archivo=uploads/images/<?php echo $inicio['pro']['fotos'][0]; ?>&ancho=218&alto=180" alt="" /></div>
            <div class="pro_fotos_otras clearfix">
            <?php if(count($inicio['pro']['fotos']) > 1){ ?>
                <?php for($i=1; $i<count($inicio['pro']['fotos']); $i++){ ?>
                    <div class="foto_prev"><img src="/foto.php?archivo=uploads/images/<?php echo $inicio['pro']['fotos'][$i]; ?>&ancho=218&alto=180" alt="" /></div>
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
                    <img src="/foto.php?archivo=uploads/images/<?php echo $valor['fotos'][$i]; ?>&ancho=218&alto=180" alt="" />
                    <div class="rel_name"><?php echo $valor['nombre']; ?></div>
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
</div>