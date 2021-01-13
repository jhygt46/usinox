<div class="titulo"><div class="nombre">Vitrina de productos</div></div>
<div class="lista_productos clearfix">
<?php if(isset($inicio['childs_pro'])){ foreach ($inicio['childs_pro'] as $valor){ ?>
    <div class="producto">
        <div class="pro">
            <div class="c_pro">
                <div class="c_pfoto">
                    <a class="link" href="<?php echo $valor['urls']; ?>"><img src="https://www.usinox.cl/foto.php?archivo=http://35.202.149.15/uploads/images/<?php echo $valor['fotos'][0]; ?>&ancho=218&alto=180" alt="" /></a>
                </div>
                <div class="c_pttl"><?php echo $valor['nombre']; ?></div>
                <div class="c_pdesc"><?php echo $valor['descripcion']; ?></div>
                <div class="c_pbtn clearfix">
                    <div class="btn_cotizar">Cotizar</div>
                    <div class="btn_mostrar btn_mostrar_prod"><div class="txt">Mostrar</div><div class="punto valign"></div></div>
                </div>
            </div>
        </div>
    </div>
    <?php }} ?>
</div>