<div class="titulo"><div class="nombre">Noticias</div></div>
<?php
    echo "<pre>";
    print_r($inicio['noticias']);
    echo "</pre>";
?>
<div class="cont_static">
    <?php for($i=0; $i<count($inicio['noticias']); $i++){ ?>
        <div class="static">
            <div class="row"></div>
        </div>
    <?php } ?>
</div>