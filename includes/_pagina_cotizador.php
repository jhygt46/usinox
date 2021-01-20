<div class="titulo"><div class="nombre">Vitrina de productos</div></div>
<div class="lista_cotizador">
    <?php for($i=0; $i<count($_SESSION["prods"]); $i++){ $cot_pro = $core->get_prod($_SESSION["prods"][$i]['id']); $cot_cant = $_SESSION["prods"][$i]['cant']; ?>
        <div class="cot_pro clearfix">
            <div class="cot_pro_foto"><img class="valign" src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $cot_pro["foto_nombre"]; ?>&ancho=218&alto=180" alt="" /></div>
            <div class="cot_pro_info">
                <table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
                    <tr>
                        <td valign="middle">
                            <div class="cot_pro_titulo"><?php echo $cot_pro["nombre"]; ?></div>
                            <div class="cot_pro_desc"><?php echo substr($cot_pro["descripcion"], 0, $limit_desc2); ?></div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="cot_pro_cant"><input class="valign" type="text" value="<?php echo $cot_cant; ?>" /></div>
            <div class="cot_pro_del"><img class="valign" src="images/delete.png" alt=""></div>
        </div>
    <?php } ?>
</div>
<div class="cotizar_btn clearfix">
    <a href="javascript:history.go(-1)" class="mas_productos">
        <div class="txt">Agregar más productos</div>
        <div class="punto valign"></div>
    </a>
    <a href="/enviar_cotizacion" class="enviar_cotizacion">
        <div class="txt">Enviar cotización</div>
        <div class="punto valign"></div>
    </a>
</div>