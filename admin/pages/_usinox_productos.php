<?php

require_once "../class/admin_class.php";
$admin = new Admin();

$titulo = "Productos";
$titulo_list = "Mis Productos";
$sub_titulo1 = "Ingresar Producto";
$sub_titulo2 = "Modificar Producto";
$accion = "crear_producto";
$titulo_list = "Lista de Productos";

$eliminaraccion = "eliminar_producto";
$eliminarobjeto = "Productos";

$id_list = "id_pro";
$page_mod = "pages/_usinox_productos.php";
$page_img = "pages/_usinox_productos_image.php";
$sub_titulo = $sub_titulo1;
$id = 0;

$that["nombre"] = "";
$that["urls"] = "";
$that["descripcion"] = "";
$that["marca"] = "";
$that["modelo"] = "";
$that["precio"] = "";
$that["oferta"] = "";
$that["novedad"] = "";
$that["disp"] = "";
$that["id_pag"] = 0;

$id_cat = $_GET["id_cat"];

$list_ = $admin->get_productos($id_cat);
$titulo_padre = $admin->get_titulo_padre_prod($id_cat);
$categorias = $admin->get_categoria_diferente_pagina();

if(isset($_GET["id_pro"]) && is_numeric($_GET["id_pro"]) && $_GET["id_pro"] != 0){

    $id = $_GET["id_pro"];
    $that = $admin->get_producto($id);
    $sub_titulo = $sub_titulo2;
    if(!isset($_GET["re"])){
        $relaciones = $admin->get_relaciones($id);
    }

}
?>

<script>
    $("#nombre").keyup(function(){
        $('#url').val($(this).val().replace(/\s/g, "-"));
    });
    $("#url").keyup(function(){
        $('#url').val($(this).val().replace(/\s/g, "-"));
    });
</script>

<?php if(isset($_GET['sortable'])){ ?>
<script>
    $('.listUser').sortable({
        stop: function(e, ui){
            var order = [];
            $(this).find('.user').each(function(){
                order.push($(this).attr('rel'));
            });
            var send = { accion: 'order_producto', values: order };
            $.ajax({
                url: "ajax/",
                type: "POST",
                data: send,
                success: function(data){
                    console.log(data);
                },
                error: function(e){
                    console.log(e);
                }
            });
        }
    });
</script>
<?php } ?>


<div class="title">
    <h1><?php echo $titulo; ?></h1>
    <ul class="clearfix">
        <li class="back" onclick="backurl()"></li>
    </ul>
</div>
<hr>
<div class="info">
    <div class="fc" id="info-0">
        <div class="minimizar m1"></div>
        <div class="close"></div>
        <div class="name"><?php echo $sub_titulo; ?></div>
        <div class="name2"><?php echo $titulo_padre; ?></div>
        <div class="message"></div>
        <div class="sucont">

            <form action="" method="post" class="basic-grey">
                <fieldset>
                    <input id="id" type="hidden" value="<?php echo $id; ?>" />
                    <input id="accion" type="hidden" value="<?php echo $accion; ?>" />
                    <input id="id_cat" type="hidden" value="<?php echo $id_cat; ?>" />
                    <input id="id_pag" type="hidden" value="<?php echo $that["id_pag"]; ?>" />
                    <?php if(count($relaciones) > 0){ ?>
                    <input id="reload" type="hidden" value="<?php echo $relaciones[0]['id_cat']; ?>/<?php echo $relaciones[0]['id_pro']; ?>/<?php echo $relaciones[0]['id_pag']; ?>" />
                    <?php } ?>

                    <label class="nboleta">
                        <span>Nombre:</span>
                        <input id="nombre" type="text" value="<?php echo $that['nombre']; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Url:</span>
                        <input id="url" type="text" value="<?php echo $that['urls']; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Catalogo Usinox:</span>
                        <input id="file_image0" type="file" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Manual Usinox:</span>
                        <input id="file_image1" type="file" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Descripcion:</span>
                        <textarea id="desc" ><?php echo $that['descripcion']; ?></textarea>
                        <div class="mensaje"></div>
                    </label>
                    <label class="nboleta">
                        <span>Precio:</span>
                        <input id="precio" type="text" value="<?php echo $that['precio']; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label class="nboleta">
                        <span>Marca:</span>
                        <input id="marca" type="text" value="<?php echo $that['marca']; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label class="nboleta">
                        <span>Modelo:</span>
                        <input id="modelo" type="text" value="<?php echo $that['modelo']; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label class="nboleta">
                        <span>Ofertas:</span>
                        <input id="oferta" type="checkbox" value="1" <?php if($that['oferta'] == 1){ echo 'checked="checked"'; } ?> />
                        <div class="mensaje"></div>
                    </label>
                    <label class="nboleta">
                        <span>Novedades:</span>
                        <input id="novedad" type="checkbox" value="1" <?php if($that['novedad'] == 1){ echo 'checked="checked"'; } ?> />
                        <div class="mensaje"></div>
                    </label>
                    <label class="nboleta">
                        <span>Ocultar:</span>
                        <input id="disp" type="checkbox" value="1" <?php if($that['disp'] == 1){ echo 'checked="checked"'; } ?> />
                        <div class="mensaje"></div>
                    </label>
                    <?php if($id == 0){ for($j=0; $j<count($categorias); $j++){ $c = $j + 1; ?>
                    <label>
                        <span>Copiar a:</span>
                        <select id="id_cp_cat_<?php echo $categorias[$j]["id"]; ?>">
                            <option value="0">No copiar</option>
                            <?php for($i=0; $i<count($categorias[$j]["categorias"]); $i++){ echo '<option value="'.$categorias[$j]["categorias"][$i]["id_cat"].'">'.$categorias[$j]["categorias"][$i]["nombre"].'</option>'; }?>
                        </select>
                    </label>
                    <?php }} ?>
                    <label style='margin-top:20px'>
                        <span>&nbsp;</span>
                        <a id='button' onclick="form()">Enviar</a>
                    </label>
                    
                </fieldset>
            </form>
            
        </div>
    </div>
</div>

<?php if(count($list_) > 0){ ?>
<div class="info">
    <div class="fc" id="info-0">
        <div class="minimizar m1"></div>
        <div class="close"></div>
        <div class="name"><?php echo $titulo_list; ?></div>
        <ul class="options sort clearfix">
            <li class="opt">
                <div onclick="navlink('<?php echo $page_mod; ?>?id_cat=<?php echo $id_cat; ?>&sortable=1')" class="order"></div>
            </li>
        </ul>
        <div class="message"></div>
        <div class="sucont">
            <ul class='listUser'>
                <?php
                for($i=0; $i<count($list_); $i++){
                    $id_pro = $list_[$i][$id_list];
                    $nombre = $list_[$i]['nombre'];
                ?>
                <li class="user" rel="<?php echo $id_pro; ?>">
                    <ul class="clearfix">
                        <li class="nombre"><?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', '<?php echo $id_pro; ?>/<?php echo $id_cat; ?>', '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id_cat=<?php echo $id_cat; ?>&id_pro=<?php echo $id_pro; ?>')"></a>
                        <a title="Imagenes" class="icn fotos" onclick="navlink('<?php echo $page_img; ?>?id_pro=<?php echo $id_pro; ?>&nombre=<?php echo $nombre; ?>')"></a>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<?php } ?>
<br />
<br />