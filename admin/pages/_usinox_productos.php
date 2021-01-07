<?php

require_once "../class/admin_class.php";
$admin = new Admin();

$titulo = "Productos";
$titulo_list = "Mis Productos";
$sub_titulo1 = "Ingresar Producto";
$sub_titulo2 = "Modificar Producto";
$accion = "crear_producto";
$titulo_list = "Lista de Productos";

$eliminaraccion = "eliminar_productos";
$eliminarobjeto = "Productos";

$id_list = "id_pro";
$page_mod = "pages/_usinox_productos.php";
$page_img = "pages/_usinox_productos_image.php";
$sub_titulo = $sub_titulo1;
$id = 0;

$that["nombre"] = "";
$that["urls"] = "";
$that["id_pag"] = 0;

$id_cat = $_GET["id_cat"];

$list_ = $admin->get_productos($id_cat);
$titulo_padre = $admin->get_titulo_padre_prod($id_cat);


if(isset($_GET["id_pro"]) && is_numeric($_GET["id_pro"]) && $_GET["id_pro"] != 0){

    $id = $_GET["id_pro"];
    $that = $admin->get_producto($id);
    $sub_titulo = $sub_titulo2;
    
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
                    <label class="nboleta">
                        <span>Nombre:</span>
                        <input id="nombre2" type="text" value="<?php echo $that['nombre']; ?>" />
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
                        <textarea id="desc" ></textarea>
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
                <div onclick="navlink('<?php echo $page_mod; ?>?parent_id=<?php echo $that['parent_id']; ?>&sortable=1')" class="order"></div>
            </li>
        </ul>
        <div class="message"></div>
        <div class="sucont">
            <ul class='listUser'>
                <?php
                for($i=0; $i<count($list_); $i++){
                    $id_cat = $list_[$i][$id_list];
                    $nombre = $list_[$i]['nombre'];
                    $parent_id = $list_[$i]['parent_id'];
                ?>
                <li class="user" rel="<?php echo $id_cat; ?>">
                    <ul class="clearfix">
                        <li class="nombre"><?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', '<?php echo $id_cat; ?>/<?php echo $that['parent_id']; ?>', '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id_cat=<?php echo $id_cat; ?>')"></a>
                        <a title="Categorias" class="icn produc" onclick="navlink('<?php echo $page_prods; ?>?parent_id=<?php echo $id_cat; ?>')"></a>
                        <a title="Categorias" class="icn subcat" onclick="navlink('<?php echo $page_mod; ?>?parent_id=<?php echo $id_cat; ?>')"></a>
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