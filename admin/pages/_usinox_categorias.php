<?php
session_start();

require_once "../class/admin_class.php";
$admin = new Admin();

$res = $admin->verificar_usuario();
if($res['op']){
    if(isset($_GET["id_pag"])){
        if($res['data']['id_pag'] == $_GET["id_pag"] || $res['data']['id_pag'] == 0){
            $_SESSION["id_pag"] = $_GET["id_pag"];
        }else{
            die('ERROR');
        }
    }
}else{
    die('ERROR');
}

$titulo = "Categorias";
$titulo_list = "Mis Categorias";
$sub_titulo1 = "Ingresar Categoria";
$sub_titulo2 = "Modificar Categoria";
$accion = "crear_categoria";
$titulo_list = "Lista de Categorias";

$eliminaraccion = "eliminar_categoria";
$eliminarobjeto = "Categoria";

$id_list = "id_cat";
$page_mod = "pages/_usinox_categorias.php";
$page_prods = "pages/_usinox_productos.php";
$sub_titulo = $sub_titulo1;
$id = 0;

$that["nombre"] = "";
$that["urls"] = "";
$that["descripcion"] = "";
$that["parent_id"] = (isset($_GET["parent_id"])) ? $_GET["parent_id"] : 0;
$that["id_pag"] = 0;

$list_ = $admin->get_categorias($that["parent_id"]);
$titulo_padre = $admin->get_titulo_padre($that["parent_id"]);

if(isset($_GET["id_cat"]) && is_numeric($_GET["id_cat"]) && $_GET["id_cat"] != 0){

    $id = $_GET["id_cat"];
    $that = $admin->get_categoria($id);
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
            var send = { accion: 'order_categoria', values: order };
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
                    <input id="parent_id" type="hidden" value="<?php echo $that['parent_id']; ?>" />
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
                    <?php if($that["parent_id"] > 0){ ?>
                    <label>
                        <span>Foto:</span>
                        <input id="file_image" type="file" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Descripcion:</span>
                        <textarea id="desc" ><?php echo $that['descripcion']; ?></textarea>
                        <div class="mensaje"></div>
                    </label>
                    <?php } ?>
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
                        <?php if($list_[$i]['sub_prod'] == 1 || ($list_[$i]['sub_prod'] == 0 && $list_[$i]['sub_cat'] == 0)){ ?><a title="Productos" class="icn produc" onclick="navlink('<?php echo $page_prods; ?>?id_cat=<?php echo $id_cat; ?>')"></a><?php } ?>
                        <?php if($list_[$i]['sub_cat'] == 1 || ($list_[$i]['sub_prod'] == 0 && $list_[$i]['sub_cat'] == 0)){ ?><a title="Categorias" class="icn subcat" onclick="navlink('<?php echo $page_mod; ?>?parent_id=<?php echo $id_cat; ?>')"></a><?php } ?>
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