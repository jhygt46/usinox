<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

class Admin {
    
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
    public function verificar_super_usuario(){
        if($sql = $this->con->prepare("SELECT id_pag FROM _usinox_usuarios WHERE id_user=? AND secure_hash=? AND eliminado=?")){
            if($sql->bind_param("isi", $_COOKIE['id_user'], $_COOKIE['secure_hash'], $this->eliminado)){
                if($sql->execute()){
                    $usuarios = $this->get_result($sql);
                    if(count($usuarios) == 1 && $usuarios[0]["id_pag"] == 0){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    }
    public function verificar_usuario(){
        if($sql = $this->con->prepare("SELECT nombre, correo, id_pag FROM _usinox_usuarios WHERE id_user=? AND secure_hash=? AND eliminado=?")){
            if($sql->bind_param("isi", $_COOKIE['id_user'], $_COOKIE['secure_hash'], $this->eliminado)){
                if($sql->execute()){
                    $usuarios = $this->get_result($sql);
                    if(count($usuarios) == 1){
                        $res['op'] = true;
                        $res['data'] = $usuarios[0];
                    }else{
                        $res['op'] = false;
                    }
                    return $res;
                }
            }
        }
    }
    public function resp_categorias($data, $id_cat){
        $id_aux_cat = $id_cat;
        $n = array();
        $exit = 0;
        while($exit == 0){
            for($i=0; $i<count($data); $i++){
                if($id_aux_cat == $data[$i]["id_cat"]){
                    $n[] = $data[$i]["nombre"];
                    $p_id = $data[$i]["parent_id"];
                }
            }
            if($p_id == 0){
                $exit = 1;
            }else{
                $id_aux_cat = $p_id;
            }
        }
        return "en ".implode(" > ", array_reverse($n));
    }
    private function get_categoria_diferente_sql($i){
        if($sql = $this->con->prepare("SELECT id_cat, nombre, parent_id FROM _usinox_categorias WHERE id_pag=? AND eliminado=?")){
            if($sql->bind_param("ii", $i, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data;
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_relaciones($id){
        if($sql = $this->con->prepare("SELECT * FROM _usinox_prod_rel t1, _usinox_productos t2 WHERE t1.id_pro1=? AND t1.id_pro2=t2.id_pro AND t2.eliminado=?")){
            if($sql->bind_param("ii", $i, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    $res[] = $data;
                }else{ $res['db'] = $this->htmlspecialchars($sql->error); }
            }else{ $res['db'] = $this->htmlspecialchars($sql->error); }
        }else{ $res['db'] = $this->htmlspecialchars($this->con->error); }
        if($sql = $this->con->prepare("SELECT * FROM _usinox_prod_rel t1, _usinox_productos t2 WHERE t1.id_pro2=? AND t1.id_pro1=t2.id_pro AND t2.eliminado=?")){
            if($sql->bind_param("ii", $i, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    $res[] = $data;
                }else{ $res['db'] = $this->htmlspecialchars($sql->error); }
            }else{ $res['db'] = $this->htmlspecialchars($sql->error); }
        }else{ $res['db'] = $this->htmlspecialchars($this->con->error); }
        return $res;
    }
    public function get_categoria_diferente_pagina(){

        if($_SESSION["id_pag"] == 1){
            $aux["id"] = 2;
            $aux["nombre"] = "Neptuno";
            $aux["categorias"] = $this->get_categoria_diferente_sql(2);
            $res[] = $aux;
        }else if($_SESSION["id_pag"] == 2){
            $aux["id"] = 1;
            $aux["nombre"] = "Neptuno";
            $aux["categorias"] = $this->get_categoria_diferente_sql(1);
            $res[] = $aux;
        }else{
            $res = array();
        }
        return $res;

    }
    public function get_titulo_padre_prod($id_cat){
        if($sql = $this->con->prepare("SELECT id_cat, nombre, parent_id FROM _usinox_categorias WHERE id_pag=? AND eliminado=?")){
            if($sql->bind_param("ii", $_SESSION["id_pag"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $this->resp_categorias($data, $id_cat);
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_titulo_padre($id){
        if($id == 0){
            return "";
        }else{
            if($sql = $this->con->prepare("SELECT id_cat, nombre, parent_id FROM _usinox_categorias WHERE id_pag=? AND eliminado=?")){
                if($sql->bind_param("ii", $_SESSION["id_pag"], $this->eliminado)){
                    if($sql->execute()){
                        $data = $this->get_result($sql);
                        $sql->close();
                        return $this->resp_categorias($data, $id);
                    }else{ $this->htmlspecialchars($sql->error); }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($this->con->error); }
        }
    }
    public function get_paginas(){
        if($sql = $this->con->prepare("SELECT * FROM _usinox_paginas WHERE eliminado=?")){
            if($sql->bind_param("i", $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data;
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_usuarios(){
        if($sql = $this->con->prepare("SELECT * FROM _usinox_usuarios WHERE eliminado=?")){
            if($sql->bind_param("i", $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data;
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_usuario($id){
        if($sql = $this->con->prepare("SELECT nombre, correo, id_pag FROM _usinox_usuarios WHERE id_user=? AND eliminado=?")){
            if($sql->bind_param("ii", $id, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data[0];
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_productos($id_cat){
        if($sql = $this->con->prepare("SELECT * FROM _usinox_productos WHERE id_cat=? AND id_pag=? AND eliminado=?")){
            if($sql->bind_param("iii", $id_cat, $_SESSION["id_pag"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data;
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_producto($id_pro){
        if($sql = $this->con->prepare("SELECT * FROM _usinox_productos WHERE id_pro=? AND id_pag=? AND eliminado=?")){
            if($sql->bind_param("iii", $id_pro, $_SESSION["id_pag"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data[0];
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_categorias($id){
        if($sql = $this->con->prepare("SELECT id_cat, nombre, parent_id FROM _usinox_categorias WHERE parent_id=? AND id_pag=? AND eliminado=? ORDER BY orden")){
            if($sql->bind_param("iii", $id, $_SESSION["id_pag"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();

                    for($i=0; $i<count($data); $i++){

                        if($sqls = $this->con->prepare("SELECT id_cat FROM _usinox_categorias WHERE parent_id=? AND id_pag=? AND eliminado=?")){
                            if($sqls->bind_param("iii", $data[$i]["id_cat"], $_SESSION["id_pag"], $this->eliminado)){
                                if($sqls->execute()){
                                    $datac = $this->get_result($sqls);
                                    $sqls->close();
                                    if(count($datac) > 0){
                                        $data[$i]["sub_cat"] = 1;
                                        $data[$i]["sub_prod"] = 0;
                                    }else{
                                        $data[$i]["sub_cat"] = 0;
                                        if($sqlp = $this->con->prepare("SELECT id_pro FROM _usinox_productos WHERE id_cat=? AND id_pag=? AND eliminado=?")){
                                            if($sqlp->bind_param("iii", $data[$i]["id_cat"], $_SESSION["id_pag"], $this->eliminado)){
                                                if($sqlp->execute()){
                                                    $datap = $this->get_result($sqlp);
                                                    $sqlp->close();
                                                    if(count($datap) == 0){
                                                        $data[$i]["sub_prod"] = 0;
                                                    }else{
                                                        $data[$i]["sub_prod"] = 1;
                                                    }
                                                }else{ $this->htmlspecialchars($sqlp->error); }
                                            }else{ $this->htmlspecialchars($sqlp->error); }
                                        }else{ $this->htmlspecialchars($this->con->error); }
                                    }
                                }else{ $this->htmlspecialchars($sqls->error); }
                            }else{ $this->htmlspecialchars($sqls->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                        

                    }
                    return $data;
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_foto_producto($id){
        if($sql = $this->con->prepare("SELECT * FROM _usinox_productos_fotos WHERE id_pro=?")){
            if($sql->bind_param("i", $id)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data;
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    public function get_categoria($id){
        if($sql = $this->con->prepare("SELECT nombre, urls, parent_id, id_pag FROM _usinox_categorias WHERE id_cat=? AND id_pag=? AND eliminado=?")){
            if($sql->bind_param("iii", $id, $_SESSION["id_pag"], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data[0];
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
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

?>