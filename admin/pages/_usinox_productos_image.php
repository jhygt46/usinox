<?php

require_once "../class/admin_class.php";
$admin = new Admin();

$titulo = "Fotos Producto";
$titulo_list = "Mis Fotos";
$sub_titulo = "Ingresar Foto";
$accion = "crear_foto_producto";
$titulo_list = "Lista de Fotos";

$page_mod = "pages/_usinox_productos_image.php";

$eliminaraccion = "eliminar_foto_producto";
$eliminarobjeto = "Foto";

$id_list = "id_prf";

$id_pro = $_GET["id_pro"];
$nombre = $_GET["nombre"];
$list_ = $admin->get_foto_producto($id_pro);

?>


<?php if(isset($_GET['sortable'])){ ?>
<script>
    $('.listUser').sortable({
        stop: function(e, ui){
            var order = [];
            $(this).find('.user').each(function(){
                order.push($(this).attr('rel'));
            });
            var send = { accion: 'order_fotos', values: order };
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
    <h1><?php echo $titulo." ".$nombre; ?></h1>
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
                    <input id="nombre" type="hidden" value="<?php echo $nombre; ?>" />
                    <input id="accion" type="hidden" value="<?php echo $accion; ?>" />
                    <input id="id_pro" type="hidden" value="<?php echo $id_pro; ?>" />
                    <label>
                        <span>Foto Producto:</span>
                        <input id="file_image" type="file" />
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
                <div onclick="navlink('<?php echo $page_mod; ?>?id_pro=<?php echo $id_pro; ?>&nombre=<?php echo $nombre; ?>&sortable=1')" class="order"></div>
            </li>
        </ul>
        <div class="message"></div>
        <div class="sucont">
            <ul class='listUser'>
                <?php
                for($i=0; $i<count($list_); $i++){
                    $id_prf = $list_[$i][$id_list];
                    $nombre_f = $list_[$i]['nombre'];
                ?>
                <li class="user" rel="<?php echo $id_prf; ?>">
                    <ul class="clearfix">
                        <li class="nombre"><a href="/uploads/images/<?php echo $nombre_f; ?>"><?php echo $nombre_f; ?></a></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', '<?php echo $id_prf; ?>/<?php echo $id_pro; ?>/<?php echo $nombre; ?>', '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
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