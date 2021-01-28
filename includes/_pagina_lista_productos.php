<div class="lista_productos clearfix">
    <?php if(isset($inicio['childs_pro'])){ foreach ($inicio['childs_pro'] as $valor){ ?>
        <div class="producto">
            <div class="pro">
                <div class="c_pro">
                    <div class="c_pfoto">
                        <a class="link" href="<?php echo $valor['urls']; ?>"><img src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $valor['fotos'][0]; ?>&ancho=218&alto=180" alt="" /></a>
                    </div>
                    <div class="c_pttl"><a class="link" href="<?php echo $valor['urls']; ?>"><?php echo $valor['nombre']; ?></a></div>
                    <div class="c_pdesc"><a class="link" href="<?php echo $valor['urls']; ?>"><?php echo $valor['descripcion']; ?></a></div>
                    <div class="c_pbtn clearfix">
                        <div class="btn_cotizar" onclick="cotizar(<?php echo $valor['id_pro']; ?>, 1)">Cotizar</div>
                        <div class="btn_mostrar btn_mostrar_prod"><a class="link" href='<?php echo $valor['urls']; ?>'><div class="txt">Mostrar</div><div class="punto valign"></div></a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php }} ?>
</div>

