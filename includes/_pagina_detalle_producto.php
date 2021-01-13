<div class="titulo"><div class="nombre">Vitrina de productos</div></div>
<div class="lista_productos clearfix">
<?php if(isset($inicio['pro'])){ ?>
    <div class="detalle_producto">
        <div class="pro_info">
            <div class="titulo_pro"><?php echo $inicio['pro']['nombre']; ?></div>
            <div class="cotizar_pro clearfix">
                <div class="cotizar_pro1">Cant</div>
                <div class="cotizar_pro2"><input type="text" id="pro_cant" value="1"></div>
                <div class="cotizar_pro3"><div class="btn">Cotizar</div></div>
            </div>
            <div class="desc_ttl">Descripcion</div>
            <div class="desc_pro"><?php echo $inicio['pro']['descripcion']; ?></div>
            <div class="redes clearfix">
                <div class="red1"></div>
                <div class="red2"></div>
                <div class="red3"></div>
            </div>
        </div>
        <div class="pro_fotos">
            <div class="pro_fotos_principal"><img src="https://www.usinox.cl/foto.php?archivo=http://35.202.149.15/uploads/images/<?php echo $inicio['pro']['fotos'][0]; ?>&ancho=218&alto=180" alt="" /></div>
            <?php if(count($inicio['pro']['fotos']) > 1){ ?>
            <div class="pro_fotos_otras clearfix">
                <?php for($i=1; $i<count($inicio['pro']['fotos']); $i++){ ?>
                    <div class="foto_prev"><img src="https://www.usinox.cl/foto.php?archivo=http://35.202.149.15/uploads/images/<?php echo $inicio['pro']['fotos'][$i]; ?>&ancho=218&alto=180" alt="" /></div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
</div>