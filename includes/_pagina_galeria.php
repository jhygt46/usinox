<div class="titulo"><div class="nombre">Galerias</div></div>
<div class="cont_static">
    <div class="static">
        <?php for($i=0; $i<count($inicio['galeria']); $i++){ ?>
            <div class="galeria"><img src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $inicio['galeria'][$i]['nombre']; ?>&ancho=218&alto=180" alt="<?php echo $inicio['galeria'][$i]['alt']; ?>" /></div>
        <?php } ?>
    </div>
</div>