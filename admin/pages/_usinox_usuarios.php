<?php
require_once "../class/admin_class.php";
$admin = new Admin();

$res = $admin->verificar_super_usuario();
if(!$res){ die("ERROR"); }

$titulo = "Usuarios";
$titulo_list = "Mis Usuarios";
$sub_titulo1 = "Ingresar Usuarios";
$sub_titulo2 = "Modificar Usuarios";
$accion = "crear_usuarios";
$titulo_list = "Lista de Usuarios";

$eliminaraccion = "eliminar_usuarios";
$eliminarobjeto = "Usuario";

$id_list = "id_user";
$page_mod = "pages/_usinox_usuarios.php";
$page_prods = "pages/_usinox_usuarios.php";
$sub_titulo = $sub_titulo1;
$id = 0;

$that["nombre"] = "";
$that["correo"] = "";

$list_ = $admin->get_usuarios();
$paginas = $admin->get_paginas();

if(isset($_GET["id_user"]) && is_numeric($_GET["id_user"]) && $_GET["id_user"] != 0){

    $id = $_GET["id_user"];
    $that = $admin->get_usuario($id);
    $sub_titulo = $sub_titulo2;
    
}

?>
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
                    <label class="nboleta">
                        <span>Nombre:</span>
                        <input id="nombre" type="text" value="<?php echo $that['nombre']; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label class="nboleta">
                        <span>Correo:</span>
                        <input id="correo" type="text" value="<?php echo $that['correo']; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Password:</span>
                        <input id="pass" type="password" value="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Permiso:</span>
                        <select id="id_pag">
                            <option value="0">Administrador</option>
                            <?php for($i=0; $i<count($paginas); $i++){ $selected = ($that['id_pag'] == $paginas[$i]["id_pag"]) ? "selected" : ""; echo '<option value="'.$paginas[$i]["id_pag"].'" '.$selected.'>Solo '.$paginas[$i]["nombre"].'</option>'; }?>
                        </select>
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
                    $id_user = $list_[$i][$id_list];
                    $nombre = $list_[$i]['nombre'];
                    $parent_id = $list_[$i]['parent_id'];
                ?>
                <li class="user">
                    <ul class="clearfix">
                        <li class="nombre"><?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', '<?php echo $id_user; ?>', '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id_user=<?php echo $id_user; ?>')"></a>
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