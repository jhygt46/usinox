<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

class Core{
    
    public $con = null;
    public $eliminado = 0;
    
    public function __construct(){

        global $db_host;
        global $db_user;
        global $db_password;
        global $db_database;
        $this->con = new mysqli($db_host, $db_user, $db_password, $db_database);

    }
    public function iniciar(){

        $host = explode(".", $_SERVER['HTTP_HOST']);
        $url = explode("/", $_SERVER['REQUEST_URI']);

        $domain = (count($host) == 2) ? "www.".$_SERVER['HTTP_HOST'] : $_SERVER['HTTP_HOST'] ;

        if($_SERVER['HTTPS'] != "on" && $_SERVER['HTTP_HOST'] != "35.202.149.15"){
            $redirect = "https://".$domain.$_SERVER['REQUEST_URI'];
            header("Location: ".$redirect);
        }else{

            if($domain == "www.usinox.cl"){ 
                $sitio = 1;
            }
            if($domain == "www.marmitas.cl"){ 
                $sitio = 1;
            }
            if($domain == "www.equiposgastronomicosneptuno.cl"){ 
                $sitio = 2;
            }
            if($domain == "www.egneptuno.cl"){ 
                $sitio = 2;
            }

            if($_SERVER['HTTP_HOST'] == "35.202.149.15"){
                $sitio = 1;
            }
            
            //$info["config"] = $this->get_config($sitio);

            if($url[1] == ""){
                $info['tipo'] = "inicio";
                $info['productos'] = $this->get_random_productos(9);
            }else if($url[1] == "contacto" || $url[1] == "nosotros" || $url[1] == "servicios"){
                $info['tipo'] = "pagina";
                $info['pagina'] = $url[1];
            }else{
                $info = $this->buscar_cat_pro($sitio, $url[1]);
            }

            return $info;

        }

    }
    private function get_random_productos(){
        if($sqls = $this->con->prepare("SELECT t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1, _usinox_productos_fotos t2 WHERE t1.id_pro=t2.id_pro AND t1.eliminado=? ORDER BY RAND() LIMIT 9")){
            if($sqls->bind_param("i", $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();

                    for($i=0; $i<count($datas); $i++){
                        $id = $datas[$i]["id_pro"];
                        $res[$id]["id_pro"] = $datas[$i]["id_pro"];
                        $res[$id]["nombre"] = $datas[$i]["nombre"];
                        $res[$id]["descripcion"] = $datas[$i]["descripcion"];
                        $res[$id]["fotos"][] = $datas[$i]["foto_nombre"];
                    }

                    return $res;
                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    private function child_categoria($data, $id){
        $res = array();
        for($i=0; $i<count($data); $i++){
            if($data[$i]['parent_id'] == $id){

            }
        }
        return $res;
    }
    private function get_relacionados($id_cat){

        if($sqls = $this->con->prepare("SELECT t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1, _usinox_productos_fotos t2 WHERE t1.id_cat=? AND t1.id_pro=t2.id_pro AND t1.eliminado=? ORDER BY RAND() LIMIT 4")){
            if($sqls->bind_param("ii", $id_cat, $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    for($i=0; $i<count($datas); $i++){
                        $id = $datas[$i]["id_pro"];
                        $res[$id]["id_pro"] = $datas[$i]["id_pro"];
                        $res[$id]["nombre"] = $datas[$i]["nombre"];
                        $res[$id]["descripcion"] = $datas[$i]["descripcion"];
                        $res[$id]["fotos"][] = $datas[$i]["foto_nombre"];
                    }
                    return $res;

                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    private function process_producto($data, $url){

        if($sqls = $this->con->prepare("SELECT t1.id_cat, t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1, _usinox_productos_fotos t2 WHERE t1.urls=? AND t1.id_pro=t2.id_pro AND t1.eliminado=? ORDER BY RAND() LIMIT 4")){
            if($sqls->bind_param("si", $url, $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    $id = $datas[0]["id_pro"];
                    $res[$id]["id_pro"] = $datas[0]["id_pro"];
                    $res[$id]["nombre"] = $datas[0]["nombre"];
                    $res[$id]["descripcion"] = $datas[0]["descripcion"];
                    for($i=0; $i<count($datas); $i++){
                        $res[$id]["fotos"][] = $datas[$i]["foto_nombre"];
                    }
                    $res['parents'] = $this->resp_categorias($data, $datas[0]["id_cat"]);
                    $res[$id]['relacionados'] = $this->get_relacionados($datas[0]['id_cat']);
                    return $res;

                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
        return null;

    }
    private function process_categoria($data, $url){
        for($i=0; $i<count($data); $i++){
            if($data[$i]['urls'] == $url){
                $res['tipo'] = 'categoria';
                $res['nombre'] = $data[$i]['nombre'];
                if($data[$i]['parent_id'] > 0){
                    $res['parents'] = $this->resp_categorias($data, $data[$i]['parent_id']);
                }
                $childs_cat = $this->child_categoria($data, $data[$i]['id_cat']);
                if(count($childs_cat) > 0){
                    $res['childs_cat'] = $childs_cat;
                }else{
                    $childs_prod = $this->child_prods($data[$i]['id_cat']);
                    if(count($childs_prod) > 0){
                        $res['childs_pro'] = $childs_prod;
                    }else{
                        $res['mensaje'] = "No tiene categorias o productos hijos";
                    }
                }
                return $res;
            }
        }
        return null;
    }
    public function resp_categorias($data, $id_cat){
        $id_aux_cat = $id_cat;
        $n = array();
        $exit = 0;
        while($exit == 0){
            for($i=0; $i<count($data); $i++){
                if($id_aux_cat == $data[$i]["id_cat"]){
                    $aux['nombre'] = $data[$i]["nombre"];
                    $aux['url'] = $data[$i]["url"];
                    $n[] = $aux;
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
    private function buscar_cat_pro($id_pag, $url){

        if($sql = $this->con->prepare("SELECT id_cat, nombre, urls, foto, parent_id FROM _usinox_categorias WHERE id_pag=? AND eliminado=?")){
            if($sql->bind_param("ii", $id_pag, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    $cat = $this->process_categoria($data, $url);
                    if($cat == null){
                        return $this->process_producto($data, $url);
                    }else{
                        return $cat;
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    private function buscar_categoria_productos($id_pag, $url){

        if($sql = $this->con->prepare("SELECT id_cat, nombre, urls, foto, parent_id FROM _usinox_categorias WHERE id_pag=? AND urls=? AND eliminado=?")){
            if($sql->bind_param("isi", $id_pag, $url, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    if(!count($data) == 0){
                        $info['tipo'] = "categoria";
                        $info['data'] = $data[0];
                    }else{
                        if($sqls = $this->con->prepare("SELECT id_pro, nombre, urls, descripcion, marca, modelo, precio, ficha, manual FROM _usinox_productos WHERE id_pag=? AND urls=? AND eliminado=?")){
                            if($sqls->bind_param("isi", $id_pag, $url, $this->eliminado)){
                                if($sqls->execute()){
                                    $datas = $this->get_result($sqls);
                                    if(!count($datas) == 0){
                                        $info['tipo'] = "producto";
                                        $info['data'] = $datas[0];
                                        if($sqlr = $this->con->prepare("SELECT nombre FROM _usinox_productos_fotos WHERE id_pro=?")){
                                            if($sqlr->bind_param("i", $info['data']['id_pro'])){
                                                if($sqlr->execute()){
                                                    $datar = $this->get_result($sqlr);
                                                    if(count($datar) > 0){
                                                        $info['data']['fotos'] = $datar;
                                                    }
                                                    $sqls->close();
                                                }else{ $this->htmlspecialchars($sqlr->error); }
                                            }else{ $this->htmlspecialchars($sqlr->error); }
                                        }else{ $this->htmlspecialchars($this->con->error); }
                                    }else{
                                        header("HTTP/1.1 404 Not Found");
                                        require '404.php';
                                        exit;
                                    }
                                    $sqls->close();
                                }else{ $this->htmlspecialchars($sqls->error); }
                            }else{ $this->htmlspecialchars($sqls->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                    }
                    $sql->close();
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
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

}

?>