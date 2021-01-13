<div class="titulo"><div class="nombre">Vitrina de productos</div></div>
<div class="lista_cotizador">
    <?php for($i=0; $i<count($_SESSION["prods"]); $i++){ $cot_pro = $core->get_prod($_SESSION["prods"][$i]['id']); $cot_cant = $_SESSION["prods"][$i]['cant']; ?>
        <div class="cot_pro">
            <div class="cot_pro_foto"><img src="https://www.usinox.cl/foto.php?archivo=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["HTTP_HOST"]; ?>/uploads/images/<?php echo $cot_pro["foto_nombre"][0]; ?>&ancho=218&alto=180" alt="" /></div>
            <div class="cot_pro_info">
                <div class="cot_pro_titulo"><?php echo $cot_pro["nombre"]; ?></div>
                <div class="cot_pro_desc"><?php echo $cot_pro["descripcion"]; ?></div>
            </div>
            <div class="cot_pro_cant"><input type="text" value="<?php echo $cot_cant; ?>" /></div>
            <div class="cot_pro_del"><img src="" alt=""></div>
        </div>
    <?php } ?>
</div>