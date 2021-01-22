<div class="titulo"><div class="nombre">Proyectos</div></div>
<div class="cont_static">
    <?php for($i=0; $i<count($inicio['proyectos']); $i++){ ?>
        <div class="static">
            <div class="row clearfix">
                <div class="row1"><?php echo $inicio['proyectos'][$i]['foto'][0]; ?></div>
                <div class="row2">
                    <div class="row2a"><?php echo $inicio['proyectos'][$i]['nombre']; ?></div>
                    <div class="row2b"><?php echo $inicio['proyectos'][$i]['descripcion']; ?></div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>