<div class="titulo"><div class="nombre">Videos</div></div>
<?php for($i=0; $i<count($inicio['videos']); $i++){ ?>
<div class="video-responsive">
    <iframe src="https://www.youtube.com/embed/<?php echo $inicio['videos'][$i]['urls']; ?>" frameborder="0" allowfullscreen></iframe>
</div>
<?php } ?>

