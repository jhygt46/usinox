<div class="carrusel">
    <div class="foto fo1"><img src="images/foto1.jpg" alt="" /></div>
    <div class="foto fo2 none"><img src="images/foto2.jpg" alt="" /></div>
    <div class="foto fo3 none"><img src="images/foto3.jpg" alt="" /></div>
    <div class="flecha f1 valign" onclick="next(-1)"><img src="images/flechaleft.png" alt=""></div>
    <div class="flecha f2 valign" onclick="next(1)"><img src="images/flecharight.png" alt=""></div>
</div>
<table class="otros" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td class="otro ot1" valign="middle"><div class="t1">NOTICIAS</div><div class="t2">Lee todas nuestras noticias</div></td>
        <td class="otro ot2" valign="middle"><div class="t1">PROYECTOS</div><div class="t2">Revisa todos nuestros proyectos</div></td>
        <td class="otro ot3" valign="middle"><div class="t1">GALERIA</div><div class="t2">Mira nuestra galeria de imagenes</div></td>
    </tr>
</table>
<div class="titulo"><div class="nombre">Vitrina de Productos</div></div>
<div class="lista_productos clearfix">
<?php if(isset($inicio['childs_pro'])){ foreach ($inicio['childs_pro'] as $valor){ ?>
    <div class="producto">
        <div class="pro">
            <div class="c_pro">
                <div class="c_pfoto">
                    <a class="link" href="<?php echo $valor['urls']; ?>"><img src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $valor['fotos'][0]; ?>&ancho=218&alto=180" alt="" /></a>
                </div>
                <div class="c_pttl"><?php echo $valor['nombre']; ?></div>
                <div class="c_pdesc"><?php echo substr($valor['descripcion'], 0, $limit_desc); ?></div>
                <div class="c_pbtn clearfix">
                    <div class="btn_cotizar" onclick="cotizar(<?php echo $valor['id_pro']; ?>, 1)">Cotizar</div>
                    <div class="btn_mostrar btn_mostrar_prod"><div class="txt">Mostrar</div><div class="punto valign"></div></div>
                </div>
            </div>
        </div>
    </div>
    <?php }} ?>
</div>