<div class="titulo"><div class="nombre">Noticias</div></div>
<div class="cont_static">
    <?php for($i=0; $i<count($inicio['noticias']); $i++){ ?>
        <div class="static">
            <div class="row clearfix">
                <div class="row1"><?php echo $inicio['noticias'][$i]['foto'][0]; ?></div>
                <div class="row2">
                    <div class="row2a"><?php echo $inicio['noticias'][$i]['nombre']; ?></div>
                    <div class="row2b"><?php echo $inicio['noticias'][$i]['descripcion']; ?></div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>