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
        if($_POST['accion'] == "crear_usuarios"){
            return $this->crear_usuarios();
        }
        if($_POST['accion'] == "eliminar_usuarios"){
            return $this->eliminar_usuarios();
        }
        if($_POST['accion'] == "crear_foto_producto"){
            return $this->crear_foto_producto();
        }
        if($_POST['accion'] == "eliminar_foto_producto"){
            return $this->eliminar_foto_producto();
        }

    }
    private function pass_generate($n){
        $r = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for($i=0; $i<$n; $i++){
            $r .= $chars{rand(0, strlen($chars)-1)};
        }
        return $r;
    }
    private function verificar_super_usuario(){
        if($sql = $this->con->prepare("SELECT id_pag FROM _usinox_usuarios WHERE id_user=? AND secure_hash=? AND eliminado=?")){
            if($sql->bind_param("isi", $_COOKIE['id_user'], $_COOKIE['secure_hash'], $this->eliminado)){
                if($sql->execute()){
                    $usuarios = $this->get_result($sql);
                    $sql->close();
                    if(count($usuarios) == 1 && $usuarios[0]["id_pag"] == 0){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    }
    private function verificar_usuario(){
        if($sql = $this->con->prepare("SELECT id_pag FROM _usinox_usuarios WHERE id_user=? AND secure_hash=? AND eliminado=?")){
            if($sql->bind_param("isi", $_COOKIE['id_user'], $_COOKIE['secure_hash'], $this->eliminado)){
                if($sql->execute()){
                    $usuarios = $this->get_result($sql);
                    $sql->close();
                    if(count($usuarios) == 1 && ($usuarios[0]["id_pag"] == $_SESSION["id_pag"] || $usuarios[0]["id_pag"] == 0)){
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
                if($sql = $this->con->prepare("UPDATE _usinox_productos SET orden='".$i."' WHERE id_pag=? AND id_pro=?")){
                if($sql->bind_param("ii", $_SESSION["id_pag"], $values[$i])){
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
                if($sql = $this->con->prepare("UPDATE _usinox_categorias SET orden='".$i."' WHERE id_pag=? AND id_cat=?")){
                if($sql->bind_param("ii", $_SESSION["id_pag"], $values[$i])){
                if($sql->execute()){
                    $sql->close();
                }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($this->con->error); }
            }
        }

    }
    private function verificar_urls_cat($urls, $id){

        if($sql = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE urls=? AND id_cat<>? AND id_pag=? AND eliminado=?")){
            if($sql->bind_param("siii", $urls, $id, $_SESSION["id_pag"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        if($sqls = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE urls=? AND id_pag=? AND eliminado=?")){
                            if($sqls->bind_param("sii", $urls, $_SESSION["id_pag"], $this->eliminado)){
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

        if($sql = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE urls=? AND id_pag=? AND eliminado=?")){
            if($sql->bind_param("sii", $urls, $_SESSION["id_pag"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        if($sqls = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE urls=? AND id_pro<>? AND id_pag=? AND eliminado=?")){
                            if($sqls->bind_param("siii", $urls, $id, $_SESSION["id_pag"], $this->eliminado)){
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

        if($sql = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE urls=? AND id_pag=? AND eliminado=?")){
            if($sql->bind_param("sii", $urls, $_SESSION["id_pag"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        if($sqls = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE urls=? AND id_pag=? AND eliminado=?")){
                            if($sqls->bind_param("sii", $urls, $_SESSION["id_pag"], $this->eliminado)){
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
            if($sql = $this->con->prepare("UPDATE _usinox_categorias SET eliminado='1' WHERE id_pag=? AND id_cat=?")){
                if($sql->bind_param("ii", $_SESSION["id_pag"], $id[0])){
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
            if($sql = $this->con->prepare("UPDATE _usinox_productos SET eliminado='1' WHERE id_pag=? AND id_pro=?")){
                if($sql->bind_param("ii", $_SESSION["id_pag"], $id[0])){
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
    private function get_foto_categoria($id){
        if($sqls = $this->con->prepare("SELECT foto FROM _usinox_categorias WHERE id_cat=? AND eliminado=?")){
            if($sqls->bind_param("ii", $id, $this->eliminado)){
                if($sqls->execute()){
                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    return $datas[0]['foto'];
                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    private function crear_categoria(){
        
        $info['op'] = 2;
        $info['mensaje'] = "Categoria no se pudo guardar";
        
        $nombre = $_POST['nombre'];
        $url = $_POST['url'];
        $parent_id = $_POST['parent_id'];
        $desc = ($parent_id > 0) ? $_POST['desc'] : "" ;
        $id = $_POST['id'];

        if($this->verificar_usuario()){

            if($id > 0){
                if($this->verificar_urls_cat($url, $id)){
                    if($sql = $this->con->prepare("UPDATE _usinox_categorias SET nombre=?, urls=?, descripcion=? WHERE id_cat=? AND id_pag=?")){
                        if($sql->bind_param("sssii", $nombre, $url, $desc, $id, $_SESSION["id_pag"])){
                            if($sql->execute()){
                                $info['op'] = 1;
                                $info['mensaje'] = "Categoria modificada exitosamente";
                                $info['reload'] = 1;
                                $info['page'] = "_usinox_categorias.php?parent_id=".$parent_id;
                                $old_file = $this->get_foto_categoria($id);
                                $info["old_file"] = $old_file;
                                $image = $this->upload_foto($_SERVER["DOCUMENT_ROOT"]."/uploads/images/", $nombre, 0, $old_file);
                                $info["image"] = $image;
                                if($image['op'] == 1){
                                    $this->actualizar_foto_categoria($id, $image['image']);
                                }
                            }else{ $this->htmlspecialchars($sql->error); }
                        }else{ $this->htmlspecialchars($sql->error); }
                    }else{ $this->htmlspecialchars($this->con->error); }
                }else{
                    $info['mensaje'] = "Categoria no se pudo guardar por que ya existe la Url";
                }
            }

            if($id == 0){
                if($this->verificar_urls($url)){
                    if($sqls = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE parent_id=? AND id_pag=? AND eliminado=?")){
                        if($sqls->bind_param("iii", $parent_id, $_SESSION["id_pag"], $this->eliminado)){
                            if($sqls->execute()){
                                $data = $this->get_result($sqls);
                                $sqls->close();
                                $orden = count($data);
                                if($sql = $this->con->prepare("INSERT INTO _usinox_categorias (nombre, urls, descripcion, fecha, parent_id, orden, id_pag, eliminado) VALUES (?, ?, ?, now(), ?, ?, ?, ?)")){
                                    if($sql->bind_param("sssiiii", $nombre, $url, $desc, $parent_id, $orden, $_SESSION["id_pag"], $this->eliminado)){
                                        if($sql->execute()){
                                            $info['op'] = 1;
                                            $info['mensaje'] = "Categoria ingresada exitosamente";
                                            $info['reload'] = 1;
                                            $info['page'] = "_usinox_categorias.php?parent_id=".$parent_id;
                                            $id = $this->con->insert_id;
                                            $image = $this->upload_foto($_SERVER["DOCUMENT_ROOT"]."/uploads/images/", $nombre, 0, "");
                                            $info["image"] = $image;
                                            if($image['op'] == 1){
                                                $this->actualizar_foto_categoria($id, $image['image']);
                                            }
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
    private function get_pdf_producto($id){
        if($sqls = $this->con->prepare("SELECT ficha, manual FROM _usinox_productos WHERE id_pro=? AND eliminado=?")){
            if($sqls->bind_param("ii", $id, $this->eliminado)){
                if($sqls->execute()){
                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    return $datas[0];
                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    private function actualizar_pdf_producto($id, $nombre, $campo){

        $info['op'] = 2;
        if($campo == "ficha"){
            if($sql = $this->con->prepare("UPDATE _usinox_productos SET ficha=? WHERE id_pro=?")){
                if($sql->bind_param("si", $nombre, $id)){
                    if($sql->execute()){
                        $info['op'] = 1;
                        $info['tipo'] = 'ficha';
                    }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
                }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
            }else{ $info['err'] = $this->htmlspecialchars($this->con->error); }
        }
        if($campo == "manual"){
            if($sql = $this->con->prepare("UPDATE _usinox_productos SET manual=? WHERE id_pro=?")){
                if($sql->bind_param("si", $nombre, $id)){
                    if($sql->execute()){
                        $info['op'] = 1;
                        $info['tipo'] = 'manual';
                    }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
                }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
            }else{ $info['err'] = $this->htmlspecialchars($this->con->error); }
        }
        return $info;
    }
    private function actualizar_foto_categoria($id, $nombre){

        $info['op'] = 2;
        if($sql = $this->con->prepare("UPDATE _usinox_categorias SET foto=? WHERE id_cat=?")){
            if($sql->bind_param("si", $nombre, $id)){
                if($sql->execute()){
                    $info['op'] = 1;
                    $info['tipo'] = 'ficha';
                }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
            }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
        }else{ $info['err'] = $this->htmlspecialchars($this->con->error); }
        return $info;
    }
    private function crear_producto(){
        
        $info['op'] = 2;
        $info['mensaje'] = "Producto no se pudo guardar";
        
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['desc'];
        $url = $_POST['url'];
        $id_cat = $_POST['id_cat'];
        $id = $_POST['id'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $precio = $_POST['precio'];
        $reload = $_POST['reload'];

        if($this->verificar_usuario()){

            if($id > 0){
                $_SESSION["id_pag"] = $_POST['id_pag'];
                if($this->verificar_urls_pro($url, $id)){
                    if($sql = $this->con->prepare("UPDATE _usinox_productos SET nombre=?, urls=?, descripcion=?, marca=?, modelo=?, precio=? WHERE id_pro=? AND id_pag=?")){
                        if($sql->bind_param("sssssiii", $nombre, $url, $descripcion, $marca, $modelo, $precio, $id, $_SESSION["id_pag"])){
                            if($sql->execute()){
                                $info['op'] = 1;
                                $info['mensaje'] = "Prodcuto modificada exitosamente";
                                if(!isset($reload)){
                                    $info['reload'] = 1;
                                    $info['page'] = "_usinox_productos.php?id_cat=".$id_cat;
                                }else{

                                    $aux = explode("/", $reload);
                                    $info['reload'] = 1;
                                    $info['page'] = "_usinox_productos.php?re=0&id_cat=".$aux[0]."&id_pro=".$aux[1];

                                }
                                $pdf_name = $this->get_pdf_producto($id);
                                $ficha = $this->upload_pdf($_SERVER["DOCUMENT_ROOT"]."/uploads/pdf/", null, 0, $pdf_name["ficha"]);
                                if($ficha['op'] == 1){
                                    $this->actualizar_pdf_producto($id, $ficha['image'], 'ficha');
                                }
                                $manual = $this->upload_pdf($_SERVER["DOCUMENT_ROOT"]."/uploads/pdf/", null, 1, $pdf_name["manual"]);
                                if($manual['op'] == 1){
                                    $this->actualizar_pdf_producto($id, $manual['image'], 'manual');
                                }

                            }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
                        }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
                    }else{ $info['err'] = $this->htmlspecialchars($this->con->error); }
                }else{
                    $info['mensaje'] = "Producto no se pudo guardar por que ya existe la Url";
                }
            }

            if($id == 0){
                if($this->verificar_urls($url)){
                    if($sqls = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE id_cat=? AND id_pag=? AND eliminado=?")){
                        if($sqls->bind_param("iii", $id_cat, $_SESSION["id_pag"], $this->eliminado)){
                            if($sqls->execute()){
                                $data = $this->get_result($sqls);
                                $sqls->close();
                                $orden = count($data);
                                if($sql = $this->con->prepare("INSERT INTO _usinox_productos (nombre, urls, descripcion, marca, modelo, precio, fecha, id_cat, orden, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, ?, now(), ?, ?, ?, ?)")){
                                    if($sql->bind_param("sssssiiiii", $nombre, $url, $descripcion, $marca, $modelo, $precio, $id_cat, $orden, $_SESSION["id_pag"], $this->eliminado)){
                                        if($sql->execute()){
                                            $info['op'] = 1;
                                            $info['mensaje'] = "Producto ingresada exitosamente";
                                            $info['reload'] = 1;
                                            $info['page'] = "_usinox_productos.php?id_cat=".$id_cat;
                                            $id = $this->con->insert_id;
                                            $ficha = $this->upload_pdf($_SERVER["DOCUMENT_ROOT"]."/uploads/pdf/", null, 0, "");
                                            $ficha['image'] = "";
                                            if($ficha['op'] == 1){
                                                $this->actualizar_pdf_producto($id, $ficha['image'], 'ficha');
                                            }
                                            $manual = $this->upload_pdf($_SERVER["DOCUMENT_ROOT"]."/uploads/pdf/", null, 1, "");
                                            $manual['image'] = "";
                                            if($manual['op'] == 1){
                                                $this->actualizar_pdf_producto($id, $manual['image'], 'manual');
                                            }

                                            for($i=1; $i<=2; $i++){
                                                $id_cp_cat = $_POST["id_cp_cat_".$i];
                                                if($id_cp_cat > 0){

                                                    // RECORDAR MAX ORDEN + 1 EN VEZ DE COUNT
                                                    if($sqlf = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE id_cat=? AND id_pag=? AND eliminado=?")){
                                                        if($sqlf->bind_param("iii", $id_cp_cat, $i, $this->eliminado)){
                                                            if($sqlf->execute()){
                                                                $dataf = $this->get_result($sqlf);
                                                                $sqls->close();
                                                                $ordenf = count($dataf);
                                                                if($sqlr = $this->con->prepare("INSERT INTO _usinox_productos (nombre, urls, descripcion, marca, modelo, precio, fecha, id_cat, orden, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, ?, now(), ?, ?, ?, ?)")){
                                                                    if($sqlr->bind_param("sssssiiiii", $nombre, $url, $descripcion, $marca, $modelo, $precio, $id_cp_cat, $ordenf, $i, $this->eliminado)){
                                                                        if($sqlr->execute()){
                                                                            $id_cp = $this->con->insert_id;

                                                                            if($sqln = $this->con->prepare("INSERT INTO _usinox_prod_rel (id_pro1, id_pro2) VALUES (?, ?)")){
                                                                                if($sqln->bind_param("ii", $id, $id_cp)){
                                                                                    if($sqln->execute()){
                                                                                        
                                                                                    }else{ $info['db'] = $this->htmlspecialchars($sqln->error); }
                                                                                }else{ $info['db'] = $this->htmlspecialchars($sqln->error); }
                                                                            }else{ $info['db'] = $this->htmlspecialchars($this->con->error); }

                                                                        }else{ $this->htmlspecialchars($sqlr->error); }
                                                                    }else{ $this->htmlspecialchars($sqlr->error); }
                                                                }else{ $this->htmlspecialchars($this->con->error); }
                                                            }else{ $this->htmlspecialchars($sqlr->error); }
                                                        }else{ $this->htmlspecialchars($sqlr->error); }
                                                    }else{ $this->htmlspecialchars($this->con->error); }


                                                    
                                                }
                                            }

                                        }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
                                    }else{ $info['err'] = $this->htmlspecialchars($sql->error); }
                                }else{ $info['err'] = $this->htmlspecialchars($this->con->error); }

                            }else{ $info['err'] = $this->htmlspecialchars($sqls->error); }
                        }else{ $info['err'] = $this->htmlspecialchars($sqls->error); }
                    }else{ $info['err'] = $this->htmlspecialchars($this->con->error); }
                }else{
                    $info['mensaje'] = "Producto no se pudo guardar por que ya existe la Url";
                }
            }
        }
        return $info;

    }
    private function verificar_correo($correo){
        if($sql = $this->con->prepare("SELECT id_user FROM _usinox_usuarios WHERE id_user=? AND eliminado=?")){
            if($sql->bind_param("si", $correo, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        return true;
                    }else{
                        return false;
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    private function verificar_correo_id($correo, $id){
        if($sql = $this->con->prepare("SELECT id_user FROM _usinox_usuarios WHERE id_user=? AND eliminado=?")){
            if($sql->bind_param("si", $correo, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        return true;
                    }else{
                        if(count($data) == 1 && $data[0]["id_user"] == $id){
                            return true;
                        }else{
                            return false;
                        }
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    private function crear_usuarios(){

        $info['op'] = 2;
        $info['mensaje'] = "Usuario no se pudo guardar";

        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];
        $pass = $_POST["pass"];
        $id_pag = $_POST["id_pag"];
        $id = $_POST["id"];

        if($this->verificar_super_usuario()){

            if($id > 0){
                if($this->verificar_correo_id($correo, $id)){
                    if($pass != ""){
                        if($sql = $this->con->prepare("UPDATE _usinox_usuarios SET nombre=?, correo=?, pass=?, id_pag=?, eliminado=? WHERE id_user=?")){
                            if($sql->bind_param("sssiii", $nombre, $correo, md5($pass), $id_pag, $this->eliminado, $id)){
                                if($sql->execute()){
                                    $info['op'] = 1;
                                    $info['mensaje'] = "Usuario modificado exitosamente";
                                    $info['reload'] = 1;
                                    $info['page'] = "_usinox_usuarios.php";
                                }else{ $this->htmlspecialchars($sql->error); }
                            }else{ $this->htmlspecialchars($sql->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                    }else{
                        if($sql = $this->con->prepare("UPDATE _usinox_usuarios SET nombre=?, correo=?, id_pag=?, eliminado=? WHERE id_user=?")){
                            if($sql->bind_param("ssiii", $nombre, $correo, $id_pag, $this->eliminado, $id)){
                                if($sql->execute()){
                                    $info['op'] = 1;
                                    $info['mensaje'] = "Usuario modificado exitosamente";
                                    $info['reload'] = 1;
                                    $info['page'] = "_usinox_usuarios.php";
                                }else{ $this->htmlspecialchars($sql->error); }
                            }else{ $this->htmlspecialchars($sql->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                    }
                }else{
                    $info['mensaje'] = "Correo - id ya existe";
                }
            }

            if($id == 0){
                if($this->verificar_correo($correo)){
                    $n_pass = md5($pass);
                    $s_hash = "";
                    if($sql = $this->con->prepare("INSERT INTO _usinox_usuarios (nombre, correo, pass, secure_hash, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, ?)")){
                        if($sql->bind_param("ssssii", $nombre, $correo, $n_pass, $s_hash, $id_pag, $this->eliminado)){
                            if($sql->execute()){
                                $info['op'] = 1;
                                $info['mensaje'] = "Usuario ingresado exitosamente";
                                $info['reload'] = 1;
                                $info['page'] = "_usinox_usuarios.php";
                            }else{ $this->htmlspecialchars($sql->error); }
                        }else{ $this->htmlspecialchars($sql->error); }
                    }else{ $this->htmlspecialchars($this->con->error); }
                }else{
                    $info['mensaje'] = "Correo ya existe";
                }
            }
        }else{
            $info['mensaje'] = "No tiene permisos";
        }

        return $info;

    }
    private function eliminar_usuarios(){
        
	    $info['tipo'] = "error";
        $info['titulo'] = "Error";
        $info['mensaje'] = "No se pudo borrar el usuario";
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($this->verificar_super_usuario()){

            if($sql = $this->con->prepare("UPDATE _usinox_usuarios SET eliminado='1' WHERE id_user=?")){
                if($sql->bind_param("i", $id)){
                    if($sql->execute()){
                        $info['tipo'] = "success";
                        $info['titulo'] = "Eliminado";
                        $info['texto'] = "Usuario ".$nombre." Eliminado";
                        $info['reload'] = 1;
                        $info['page'] = "_usinox_usuarios.php";
                    }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($this->con->error); }

        }else{
            $info['mensaje'] = "No tiene permisos";
        }

        return $info;
        
    }
    private function verificar_foto_producto($id){
        if($sql = $this->con->prepare("SELECT id_user FROM _usinox_usuarios WHERE id_user=? AND eliminado=?")){
            if($sql->bind_param("si", $correo, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 0){
                        return true;
                    }else{
                        return false;
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    private function crear_foto_producto(){

        $info['op'] = 2;
        $info['mensaje'] = "Foto no se pudo guardar";

        $nombre = $_POST["nombre"];
        $id = $_POST["id_pro"];

        $image = $this->upload_foto($_SERVER["DOCUMENT_ROOT"]."/uploads/images/", $nombre, 0, "");

        if($image['op'] == 1){
            if($sql = $this->con->prepare("INSERT INTO _usinox_productos_fotos (nombre, id_pro) VALUES (?, ?)")){
                if($sql->bind_param("si", $image["image"], $id)){
                    if($sql->execute()){
                        $info['op'] = 1;
                        $info['mensaje'] = "Foto ingresada exitosamente";
                        $info['reload'] = 1;
                        $info['page'] = "_usinox_productos_image.php?id_pro=".$id."&nombre=".$nombre;
                    }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($this->con->error); }
        }else{
            $info['mensaje'] = "Error al subir la foto";
        }

        
        return $info;

    }
    private function eliminar_foto_producto(){
        
	    $info['tipo'] = "error";
        $info['titulo'] = "Error";
        $info['mensaje'] = "No se pudo borrar la foto";
        
        $id = explode("/", $_POST['id']);

        if($sqls = $this->con->prepare("SELECT nombre FROM _usinox_productos_fotos WHERE id_prf=? AND id_pro=?")){
            if($sqls->bind_param("ii", $id[0], $id[1])){
                if($sqls->execute()){
                    $data = $this->get_result($sqls);
                    $sqls->close();
                    if(count($data) == 1){
                        $nombre = $data[0]["nombre"];
                        if($sql = $this->con->prepare("DELETE FROM _usinox_productos_fotos WHERE id_prf=?")){
                            if($sql->bind_param("i", $id[0])){
                                if($sql->execute()){
                                    $info['tipo'] = "success";
                                    $info['titulo'] = "Eliminado";
                                    $info['texto'] = "Foto ".$nombre." Eliminada";
                                    $info['reload'] = 1;
                                    $info['page'] = "_usinox_productos_image.php?id_pro=".$id[1]."&nombre=".$id[2];
                                    @unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/images/".$nombre);
                                }else{ $this->htmlspecialchars($sql->error); }
                            }else{ $this->htmlspecialchars($sql->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                    }else{
                        $info['mensaje'] = "No se pudo borrar la foto";
                    }
                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

        

        return $info;
        
    }
    private function get_force_name_upload($filepath, $filename, $extension){

        $w = true;
        $aux = "";
        $count = 0;
        while($w){
            if(!file_exists($filepath.$filename.$aux.".".$extension)){
                return $filename.$aux.".".$extension;
            }else{
                $aux = "_".$count;
                $count++;
            }
        }

    }
    private function upload_foto($filepath, $filename, $i, $old_file){

        $filename = ($filename !== null) ? $filename : $this->pass_generate(20) ;
        $file_formats = array("JPG", "JPEG");
        $name = $_FILES['file_image'.$i]['name'];
        $size = $_FILES['file_image'.$i]['size'];
        if(strlen($name)){
            $extension = substr($name, strrpos($name, '.') + 1);
            $extension2 = strtoupper($extension);
            if(in_array($extension2, $file_formats)){
                if($size < (25 * 1024 * 1024)){
                    if($old_file != ""){ @unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/images/".$old_file); }
                    $imagename = $this->get_force_name_upload($filepath, $filename, strtolower($extension));
                    $tmp = $_FILES['file_image'.$i]['tmp_name'];
                    if(move_uploaded_file($tmp, $filepath.$imagename)){
                            $data = getimagesize($filepath.$imagename);
                            if($data['mime'] == "image/jpeg"){
                                $info['op'] = 1;
                                $info['mensaje'] = "Imagen subida";
                                $info['image'] = $imagename;
                            }else{
                                $info['op'] = 2;
                                $info['mensaje'] = "La imagen no es jpg / jpeg";
                            }
                    }else{
                        $info['op'] = 2;
                        $info['mensaje'] = "No se pudo subir la imagen";
                    }
                }else{
                    $info['op'] = 2;
                    $info['mensaje'] = "Imagen sobrepasa los 25KB establecidos";
                }
            }else{
                $info['op'] = 2;
                $info['mensaje'] = "Formato Invalido";
            }
        }else{
            $info['op'] = 2;
            $info['mensaje'] =  "No ha seleccionado una imagen";
        }
        return $info;

    }
    private function file_name($nombre){
        $n = explode(".", $nombre);
        $res = str_replace(' ', '_', strtolower($n[0]));
        return $res;
    }
    private function upload_pdf($filepath, $filename, $i, $old_file){

        $info['old_file'] = $old_file;
        $filename = ($filename !== null) ? $filename : $this->file_name($_FILES['file_image'.$i.$i]['name']) ;
        $file_formats = array("PDF");
        $name = $_FILES['file_image'.$i.$i]['name'];
        $size = $_FILES['file_image'.$i.$i]['size'];
        if(strlen($name)){
            $extension = substr($name, strrpos($name, '.') + 1);
            $extension2 = strtoupper($extension);
            if(in_array($extension2, $file_formats)){
                if($size < (25 * 1024 * 1024)){
                    if($old_file != ""){ @unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/pdf/".$old_file); }
                    $imagename = $this->get_force_name_upload($filepath, $filename, strtolower($extension));
                    $tmp = $_FILES['file_image'.$i.$i]['tmp_name'];
                    if(move_uploaded_file($tmp, $filepath.$imagename)){
                        $info['op'] = 1;
                        $info['mensaje'] = "Imagen subida";
                        $info['image'] = $imagename;
                    }else{
                        $info['op'] = 2;
                        $info['mensaje'] = "No se pudo subir la imagen";
                    }
                }else{
                    $info['op'] = 2;
                    $info['mensaje'] = "Imagen sobrepasa los 25KB establecidos";
                }
            }else{
                $info['op'] = 2;
                $info['mensaje'] = "Formato Invalido";
            }
        }else{
            $info['op'] = 2;
            $info['mensaje'] =  "No ha seleccionado una imagen";
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
    private function htmlspecialchars($data){
        return $data;
    }
}
