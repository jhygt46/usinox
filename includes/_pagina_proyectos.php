<div class="titulo"><div class="nombre">Proyectos</div></div>
<div class="cont_static">
    <?php foreach ($inicio['proyectos'] as $valor){ ?>
        <div class="static">
            <div class="row clearfix">
                <div class="row1"><?php echo $valor['foto'][0]; ?></div>
                <div class="row2">
                    <div class="row2a"><?php echo $valor['nombre']; ?></div>
                    <div class="row2b"><?php echo $valor['descripcion']; ?></div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>