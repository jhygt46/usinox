<?php
    echo "<pre>";
    print_r($inicio);
    echo "</pre>";
?>
<div class="titulo"><div class="nombre"><?php if(isset($inicio['parents'])){ echo $inicio['parents']; } ?> <?php echo $inicio['nombre']; ?></div></div>
<div class="lista_productos clearfix">
<?php if(isset($inicio['childs_cat'])){ for($i=0; $i<count($inicio['childs_cat']); $i++){ $foto = ($inicio['childs_cat'][$i]['foto'] == "") ? "sin_imagen.jpg" : $inicio['childs_cat'][$i]['foto'] ; ?>
    <div class="producto">
        <div class="pro">
            <a class="link" href="<?php echo $inicio['childs_cat'][$i]['urls']; ?>">
            <div class="c_pro">
                <div class="c_pfoto">
                    <img src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $foto; ?>&ancho=218&alto=180" alt="" />
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