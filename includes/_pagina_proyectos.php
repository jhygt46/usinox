<div class="titulo"><div class="nombre">Proyectos</div></div>
<?php
    echo "<pre>";
    print_r($inicio['proyectos']);
    echo "</pre>";
?>
<div class="cont_static">
    <?php for($i=0; $i<count($inicio['proyectos']); $i++){ ?>
        <div class="static">
            <div class="row"></div>
        </div>
    <?php } ?>
</div>