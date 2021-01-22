<div class="titulo"><div class="nombre">Videos</div></div>
<div class="cont_video_resp">
<?php for($i=0; $i<count($inicio['videos']); $i++){ ?>
<div class="video_resp">
    <iframe src="https://www.youtube.com/embed/<?php echo $inicio['videos'][$i]['urls']; ?>" frameborder="0" allowfullscreen></iframe>
</div>
<?php } ?>
</div>

