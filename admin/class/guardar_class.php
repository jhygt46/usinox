<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

class Guardar{
    
    public $con = null;
    public $host = null;
    public $usuario = null;
    public $password = null;
    public $base_datos = null;
    public $eliminado = 0;
    
    public function __construct(){
        
        global $db_host;
        global $db_user;
        global $db_password;
        global $db_database;

        $this->host	= $db_host;
        $this->usuario = $db_user;
        $this->password = $db_password;
        $this->base_datos = $db_database;

        $this->con = new mysqli($this->host, $this->usuario, $this->password, $this->base_datos);

    }



    public function process(){

        if($_POST['accion'] == "crear_categoria"){
            return $this->crear_categoria();
        }
        if($_POST['accion'] == "eliminar_categoria"){
            return $this->eliminar_categoria();
        }
        if($_POST['accion'] == "order_categoria"){
            return $this->order_categoria();
        }
        if($_POST['accion'] == "crear_producto"){
            return $this->crear_producto();
        }
        if($_POST['accion'] == "eliminar_producto"){
            return $this->eliminar_producto();
        }
        if($_POST['accion'] == "order_producto"){
            return $this->order_producto();
        }
        
    }
    private function verificar_super_usuario(){
        if($sql = $this->con->prepare("SELECT sitio FROM _usinox_usuarios WHERE id_user=? AND secure_hash=? AND eliminado=?")){
            if($sql->bind_param("isi", $_COOKIE['id_user'], $_COOKIE['secure_hash'], $this->eliminado)){
                if($sql->execute()){
                    $usuarios = $this->get_result($sql);
                    if(count($usuarios) == 1 && $usuarios[0]["sitio"] == 2){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    }
    private function verificar_usuario(){
        if($sql = $this->con->prepare("SELECT sitio FROM _usinox_usuarios WHERE id_user=? AND secure_hash=? AND eliminado=?")){
            if($sql->bind_param("isi", $_COOKIE['id_user'], $_COOKIE['secure_hash'], $this->eliminado)){
                if($sql->execute()){
                    $usuarios = $this->get_result($sql);
                    if(count($usuarios) == 1 && ($usuarios[0]["sitio"] == $_SESSION["sitio"] || $usuarios[0]["sitio"] == 2)){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    }
    private function order_producto(){

        if($this->verificar_usuario()){
            $values = $_POST['values'];
            for($i=0; $i<count($values); $i++){
                if($sql = $this->con->prepare("UPDATE _usinox_productos SET orden='".$i."' WHERE sitio=? AND id_pro=?")){
                if($sql->bind_param("ii", $_SESSION["sitio"], $values[$i])){
                if($sql->execute()){
                    $sql->close();
                }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($this->con->error); }
            }
        }

    }
    private function order_categoria(){

        if($this->verificar_usuario()){
            $values = $_POST['values'];
            for($i=0; $i<count($values); $i++){
                if($sql = $this->con->prepare("UPDATE _usinox_categorias SET orden='".$i."' WHERE sitio=? AND id_cat=?")){
                if($sql->bind_param("ii", $_SESSION["sitio"], $values[$i])){
                if($sql->execute()){
                    $sql->close();
                }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($this->con->error); }
            }
        }

    }
    private function verificar_urls_cat($urls, $id){

        if($sql = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE urls=? AND id_cat<>? AND sitio=? AND eliminado=?")){
            if($sql->bind_param("siii", $urls, $id, $_SESSION["sitio"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        if($sqls = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE urls=? AND sitio=? AND eliminado=?")){
                            if($sqls->bind_param("sii", $urls, $_SESSION["sitio"], $this->eliminado)){
                                if($sqls->execute()){
                                    $datas = $this->get_result($sqls);
                                    $sqls->close();
                                    if(count($datas) == 0){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }else{ $this->htmlspecialchars($sqls->error); }
                            }else{ $this->htmlspecialchars($sqls->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                    }else{
                        return false;
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    private function verificar_urls_pro($urls, $id){

        if($sql = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE urls=? AND sitio=? AND eliminado=?")){
            if($sql->bind_param("sii", $urls, $_SESSION["sitio"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        if($sqls = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE urls=? AND id_pro<>? AND sitio=? AND eliminado=?")){
                            if($sqls->bind_param("siii", $urls, $id, $_SESSION["sitio"], $this->eliminado)){
                                if($sqls->execute()){
                                    $datas = $this->get_result($sqls);
                                    $sqls->close();
                                    if(count($datas) == 0){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }else{ $this->htmlspecialchars($sqls->error); }
                            }else{ $this->htmlspecialchars($sqls->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                    }else{
                        return false;
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    private function verificar_urls($urls){

        if($sql = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE urls=? AND sitio=? AND eliminado=?")){
            if($sql->bind_param("sii", $urls, $_SESSION["sitio"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        if($sqls = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE urls=? AND sitio=? AND eliminado=?")){
                            if($sqls->bind_param("sii", $urls, $_SESSION["sitio"], $this->eliminado)){
                                if($sqls->execute()){
                                    $datas = $this->get_result($sqls);
                                    $sqls->close();
                                    if(count($datas) == 0){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }else{ $this->htmlspecialchars($sqls->error); }
                            }else{ $this->htmlspecialchars($sqls->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                    }else{
                        return false;
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    private function eliminar_categoria(){

        $info['tipo'] = "error";
        $info['titulo'] = "Error";
        $info['texto'] = "Categoria no pudo ser eliminado";
        
        $id = explode("/", $_POST['id']);

        if($this->verificar_usuario()){
            if($sql = $this->con->prepare("UPDATE _usinox_categorias SET eliminado='1' WHERE sitio=? AND id_cat=?")){
                if($sql->bind_param("ii", $_SESSION["sitio"], $id[0])){
                    if($sql->execute()){
                        $info['tipo'] = "success";
                        $info['titulo'] = "Eliminado";
                        $info['texto'] = "Categoria Eliminado";
                        $info['reload'] = 1;
                        $info['page'] = "_usinox_categorias.php?parent_id=".$id[1];
                    }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($this->con->error); }
        }

        return $info;

    }
    private function eliminar_producto(){

        $info['tipo'] = "error";
        $info['titulo'] = "Error";
        $info['texto'] = "Producto no pudo ser eliminado";
        
        $id = explode("/", $_POST['id']);
        if($this->verificar_usuario()){
            if($sql = $this->con->prepare("UPDATE _usinox_productos SET eliminado='1' WHERE sitio=? AND id_pro=?")){
                if($sql->bind_param("ii", $_SESSION["sitio"], $id[0])){
                    if($sql->execute()){
                        $info['tipo'] = "success";
                        $info['titulo'] = "Eliminado";
                        $info['texto'] = "Producto Eliminado";
                        $info['reload'] = 1;
                        $info['page'] = "_usinox_productos.php?id_cat=".$id[1];
                    }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($this->con->error); }
        }
        
        return $info;

    }
    private function crear_categoria(){
        
        $info['op'] = 2;
        $info['mensaje'] = "Categoria no se pudo guardar";
        
        $nombre = $_POST['nombre'];
        $url = $_POST['url'];
        $parent_id = $_POST['parent_id'];
        $id = $_POST['id'];

        if($this->verificar_usuario()){

            if($id > 0){
                if($this->verificar_urls_cat($url, $id)){
                    if($sql = $this->con->prepare("UPDATE _usinox_categorias SET nombre=?, urls=? WHERE id_cat=? AND sitio=?")){
                        if($sql->bind_param("ssii", $nombre, $url, $id, $_SESSION["sitio"])){
                            if($sql->execute()){
                                $info['op'] = 1;
                                $info['mensaje'] = "Categoria modificada exitosamente";
                                $info['reload'] = 1;
                                $info['page'] = "_usinox_categorias.php?parent_id=".$parent_id;
                            }else{ $this->htmlspecialchars($sql->error); }
                        }else{ $this->htmlspecialchars($sql->error); }
                    }else{ $this->htmlspecialchars($this->con->error); }
                }else{
                    $info['mensaje'] = "Categoria no se pudo guardar por que ya existe la Url";
                }
            }

            if($id == 0){
                if($this->verificar_urls($url)){
                    if($sqls = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE parent_id=? AND sitio=? AND eliminado=?")){
                        if($sqls->bind_param("iii", $parent_id, $_SESSION["sitio"], $this->eliminado)){
                            if($sqls->execute()){
                                $data = $this->get_result($sqls);
                                $sqls->close();
                                $orden = count($data);
                                if($sql = $this->con->prepare("INSERT INTO _usinox_categorias (nombre, urls, fecha, parent_id, orden, sitio, eliminado) VALUES (?, ?, now(), ?, ?, ?, ?)")){
                                    if($sql->bind_param("ssiiii", $nombre, $url, $parent_id, $orden, $_SESSION["sitio"], $this->eliminado)){
                                        if($sql->execute()){
                                            $info['op'] = 1;
                                            $info['mensaje'] = "Categoria ingresada exitosamente";
                                            $info['reload'] = 1;
                                            $info['page'] = "_usinox_categorias.php?parent_id=".$parent_id;
                                        }else{ $this->htmlspecialchars($sql->error); }
                                    }else{ $this->htmlspecialchars($sql->error); }
                                }else{ $this->htmlspecialchars($this->con->error); }
                            }else{ $this->htmlspecialchars($sqls->error); }
                        }else{ $this->htmlspecialchars($sqls->error); }
                    }else{ $this->htmlspecialchars($this->con->error); }
                }else{
                    $info['mensaje'] = "Categoria no se pudo guardar por que ya existe la Url";
                }
            }

        }
        return $info;

    }
    private function crear_producto(){
        
        $info['op'] = 2;
        $info['mensaje'] = "Producto no se pudo guardar";
        
        $nombre_u = $_POST['nombre1'];
        $nombre_n = $_POST['nombre2'];
        $desc_u = $_POST['desc1'];
        $desc_n = $_POST['desc2'];
        $url = $_POST['url'];
        $id_cat = $_POST['id_cat'];
        $id = $_POST['id'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];

        if($this->verificar_usuario()){

            if($id > 0){
                if($this->verificar_urls_pro($url, $id)){
                    if($sql = $this->con->prepare("UPDATE _usinox_productos SET nombre=?, urls=? WHERE id_cat=? AND sitio=?")){
                        if($sql->bind_param("ssii", $nombre, $url, $id, $_SESSION["sitio"])){
                            if($sql->execute()){
                                $info['op'] = 1;
                                $info['mensaje'] = "Prodcuto modificada exitosamente";
                                $info['reload'] = 1;
                                $info['page'] = "_usinox_productos.php?id_cat=".$id_cat;
                            }else{ $this->htmlspecialchars($sql->error); }
                        }else{ $this->htmlspecialchars($sql->error); }
                    }else{ $this->htmlspecialchars($this->con->error); }
                }else{
                    $info['mensaje'] = "Producto no se pudo guardar por que ya existe la Url";
                }
            }

            if($id == 0){
                if($this->verificar_urls($url)){
                    if($sqls = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE id_cat=? AND sitio=? AND eliminado=?")){
                        if($sqls->bind_param("iii", $id_cat, $_SESSION["sitio"], $this->eliminado)){
                            if($sqls->execute()){
                                $data = $this->get_result($sqls);
                                $sqls->close();
                                $orden = count($data);
                                if($sql = $this->con->prepare("INSERT INTO _usinox_productos (nombre, urls, fecha, id_cat, orden, sitio, eliminado) VALUES (?, ?, now(), ?, ?, ?, ?)")){
                                    if($sql->bind_param("ssiiii", $nombre, $url, $id_cat, $orden, $_SESSION["sitio"], $this->eliminado)){
                                        if($sql->execute()){
                                            $info['op'] = 1;
                                            $info['mensaje'] = "Producto ingresada exitosamente";
                                            $info['reload'] = 1;
                                            $info['page'] = "_usinox_productos.php?id_cat=".$id_cat;
                                        }else{ $this->htmlspecialchars($sql->error); }
                                    }else{ $this->htmlspecialchars($sql->error); }
                                }else{ $this->htmlspecialchars($this->con->error); }
                            }else{ $this->htmlspecialchars($sqls->error); }
                        }else{ $this->htmlspecialchars($sqls->error); }
                    }else{ $this->htmlspecialchars($this->con->error); }
                }else{
                    $info['mensaje'] = "Producto no se pudo guardar por que ya existe la Url";
                }
            }

        }

        
        return $info;

    }
    private function crear_usuarios(){

        $info['op'] = 2;
        $info['mensaje'] = "Producto no se pudo guardar";

        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];
        $pass = $_POST["pass"];
        $sitio = $_POST["sitio"];

        if($this->verificar_super_usuario()){

            if($sql = $this->con->prepare("INSERT INTO _usinox_usuarios (nombre, correo, password, sitio, eliminado) VALUES (?, ?, ?, ?, ?)")){
                if($sql->bind_param("sssii", $nombre, $correo, md5($pass), $sitio, $this->eliminado)){
                    if($sql->execute()){
                        $info['op'] = 1;
                        $info['mensaje'] = "Usuario ingresado exitosamente";
                        $info['reload'] = 1;
                        $info['page'] = "_usinox_crear_usuario.php";
                    }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($this->con->error); }

        }

        return $info;

    }
    private function eliminarusuarios(){
        
	    $info['op'] = 2;
        $info['mensaje'] = "No se pudo borrar el usuario";
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($this->verificar_super_usuario()){

            if($sql = $this->con->prepare("UPDATE _usinox_usuarios SET eliminado='1' WHERE id_user=?")){
                if($sql->bind_param("i", $id)){
                    if($sql->execute()){
                        $info['op'] = 1;
                        $info['mensaje'] = "Usuario eliminado exitosamente";
                        $info['tipo'] = "success";
                        $info['titulo'] = "Eliminado";
                        $info['texto'] = "Usuario ".$nombre." Eliminado";
                        $info['reload'] = 1;
                        $info['page'] = "_usinox_crear_usuario.php";
                    }else{ echo htmlspecialchars($sql->error); }
                }else{ echo htmlspecialchars($sql->error); }
            }else{ echo htmlspecialchars($this->con->error); }

        }

        return $info;
        
    }
    private function get_result($stmt){
        $arrResult = array();
        $stmt->store_result();
        for ($i=0; $i<$stmt->num_rows; $i++){
            $metadata = $stmt->result_metadata();
            $arrParams = array();
            while ($field = $metadata->fetch_field()){
                $arrParams[] = &$arrResult[$i][$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result' ), $arrParams);
            $stmt->fetch();
        }
        return $arrResult;
    }
    private function htmlspecialchars(){
        
    }
}