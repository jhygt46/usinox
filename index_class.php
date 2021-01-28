<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

class Core{
    
    public $con = null;
    public $eliminado = 0;
    public $id_pag = 0;
    
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
            
            $info['pagina'] = $this->get_pagina();

            if($url[1] == ""){
                $info['tipo'] = "inicio";
                $info['childs_pro'] = $this->get_random_productos(9);
                $info['base'] = $this->get_base();
            }else if($url[1] == "contacto" || $url[1] == "nosotros" || $url[1] == "servicios"){
                $info['tipo'] = "paginas";
                $info['pagina'] = $url[1];
                $info['base'] = $this->get_base();
            }else if($url[1] == "novedades"){
                $info['tipo'] = "novedades";
                $info['base'] = $this->get_base();
                $info['childs_pro'] = $this->get_novedades();
            }else if($url[1] == "ofertas"){
                $info['tipo'] = "ofertas";
                $info['base'] = $this->get_base();
                $info['childs_pro'] = $this->get_ofertas();
            }else if($url[1] == "cotizador"){
                $info['tipo'] = "cotizador";
                $info['base'] = $this->get_base();
            }else if($url[1] == "busqueda"){
                $info['tipo'] = "busqueda";
                $info['base'] = $this->get_base();
                $info['childs_pro'] = $this->busqueda($url[2]);
            }else if($url[1] == "videos"){
                $info['tipo'] = "videos";
                $info['base'] = $this->get_base();
                $info['videos'] = $this->get_videos();
            }else if($url[1] == "noticias"){
                $info['tipo'] = "noticias";
                $info['base'] = $this->get_base();
                $info['noticias'] = $this->get_noticias();
            }else if($url[1] == "proyectos"){
                $info['tipo'] = "proyectos";
                $info['base'] = $this->get_base();
                $info['proyectos'] = $this->get_proyectos();
            }else if($url[1] == "galeria"){
                $info['tipo'] = "galeria";
                $info['base'] = $this->get_base();
                $info['galeria'] = $this->get_galeria();
            }else{
                $info = $this->buscar_cat_pro($url[1]);
            }

            return $info;

        }

    }
    private function get_proyectos(){

        if($sqls = $this->con->prepare("SELECT t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_proyectos t1 LEFT JOIN _usinox_proyectos_fotos t2 ON t1.id_pro=t2.id_pro WHERE t1.id_pag=? AND t1.eliminado=? ORDER BY t1.orden")){
            if($sqls->bind_param("ii", $this->id_pag, $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    for($i=0; $i<count($datas); $i++){
                        $id = $datas[$i]["id_pro"];
                        $res[$id]["nombre"] = $datas[$i]["nombre"];
                        $res[$id]["descripcion"] = $datas[$i]["descripcion"];
                        if($datas[$i]["foto_nombre"] != null){
                            $res[$id]["fotos"][] = $datas[$i]["foto_nombre"];
                        }else{
                            $res[$id]["fotos"][0] = "sin_imagen.jpg";
                        }
                    }
                    return $res;

                }else{ return $this->htmlspecialchars($sqls->error); }
            }else{ return $this->htmlspecialchars($sqls->error); }
        }else{ return $this->htmlspecialchars($this->con->error); }

    }
    private function get_galeria(){
        if($sqls = $this->con->prepare("SELECT * FROM _usinox_galeria WHERE id_pag=? AND eliminado=? ORDER BY orden")){
            if($sqls->bind_param("ii", $this->id_pag, $this->eliminado)){
                if($sqls->execute()){
                    $res = $this->get_result($sqls);
                    $sqls->close();
                }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
            }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
        }else{ $res['in'] = $this->htmlspecialchars($this->con->error); }
        return $res;
    }
    private function get_noticias(){

        if($sqls = $this->con->prepare("SELECT t1.id_not, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_noticias t1 LEFT JOIN _usinox_noticias_fotos t2 ON t1.id_not=t2.id_not WHERE t1.id_pag=? AND t1.eliminado=? ORDER BY t1.orden")){
            if($sqls->bind_param("ii", $this->id_pag, $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    for($i=0; $i<count($datas); $i++){
                        $id = $datas[$i]["id_not"];
                        $res[$id]["nombre"] = $datas[$i]["nombre"];
                        $res[$id]["descripcion"] = $datas[$i]["descripcion"];
                        if($datas[$i]["foto_nombre"] != null){
                            $res[$id]["fotos"][] = $datas[$i]["foto_nombre"];
                        }else{
                            $res[$id]["fotos"][0] = "sin_imagen.jpg";
                        }
                    }
                    return $res;

                }else{ return $this->htmlspecialchars($sqls->error); }
            }else{ return $this->htmlspecialchars($sqls->error); }
        }else{ return $this->htmlspecialchars($this->con->error); }

    }
    private function get_videos(){
        if($sqls = $this->con->prepare("SELECT urls FROM _usinox_videos WHERE id_pag=? AND eliminado=? ORDER BY orden")){
            if($sqls->bind_param("ii", $this->id_pag, $this->eliminado)){
                if($sqls->execute()){
                    $res = $this->get_result($sqls);
                    $sqls->close();
                }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
            }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
        }else{ $res['in'] = $this->htmlspecialchars($this->con->error); }
        return $res;
    }
    private function busqueda($busqueda){

        if($busqueda{strlen($busqueda)-1} == "s"){
            $busqueda = substr ($busqueda, 0, strlen($busqueda) - 1);
        }
        $bus = utf8_decode($busqueda);
        $val = "%".$bus."%";

        if($sqls = $this->con->prepare("SELECT t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1, _usinox_productos_fotos t2 WHERE t1.id_pro=t2.id_pro AND t1.nombre LIKE ? AND t1.disp=? AND t1.eliminado=?")){
            if($sqls->bind_param("sii", $val, $this->eliminado, $this->eliminado)){
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
                }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
            }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
        }else{ $res['in'] = $this->htmlspecialchars($this->con->error); }
        return $res;

    }
    private function get_ofertas(){
        $val = 1;
        if($sqls = $this->con->prepare("SELECT t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1, _usinox_productos_fotos t2 WHERE t1.id_pro=t2.id_pro AND t1.id_pag=? AND t1.oferta=? AND t1.disp=? AND t1.eliminado=?")){
            if($sqls->bind_param("iiii", $this->id_pag, $val, $this->eliminado, $this->eliminado)){
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
                }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
            }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
        }else{ $res['in'] = $this->htmlspecialchars($this->con->error); }
        return $res;
    }
    private function get_novedades(){
        $val = 1;
        if($sqls = $this->con->prepare("SELECT t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1, _usinox_productos_fotos t2 WHERE t1.id_pro=t2.id_pro AND t1.id_pag=? AND t1.novedad=? AND t1.disp=? AND t1.eliminado=?")){
            if($sqls->bind_param("iiii", $this->id_pag, $val, $this->eliminado, $this->eliminado)){
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
                }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
            }else{ $res['in'] = $this->htmlspecialchars($sqls->error); }
        }else{ $res['in'] = $this->htmlspecialchars($this->con->error); }
        return $res;
    }
    private function get_pagina(){

        if($sql = $this->con->prepare("SELECT * FROM _usinox_pagina_url t1, _usinox_paginas t2 WHERE t1.urls=? AND t1.id_pag=t2.id_pag AND t2.eliminado=?")){
            if($sql->bind_param("si", $_SERVER['HTTP_HOST'], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 1){
                        $this->id_pag = $data[0]['id_pag'];
                        return $data[0];
                    }else{
                        die("PAGINA NO ENCONTRADA");
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    private function get_base(){

        if($sql = $this->con->prepare("SELECT * FROM _usinox_categorias WHERE id_pag=? AND parent_id=? AND eliminado=?")){
            if($sql->bind_param("iii", $this->id_pag, $this->eliminado, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    return $data;
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    public function get_prod($id){
        if($sqls = $this->con->prepare("SELECT t1.id_pro, t1.nombre, t1.urls, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1 LEFT JOIN _usinox_productos_fotos t2 ON t1.id_pro=t2.id_pro WHERE t1.id_pro=? AND t1.eliminado=? LIMIT 1")){
            if($sqls->bind_param("ii", $id, $this->eliminado)){
                if($sqls->execute()){
                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    if(count($datas) == 1){
                        $res["id_pro"] = $datas[0]["id_pro"];
                        $res["nombre"] = $datas[0]["nombre"];
                        $res["descripcion"] = $datas[0]["descripcion"];
                        $res["foto_nombre"] = ($datas[0]["foto_nombre"] == null) ? 'sin_imagen.jpg' : $datas[0]["foto_nombre"] ;
                    }
                    return $res;
                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    private function get_random_productos(){
        if($sqls = $this->con->prepare("SELECT t1.urls, t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1, _usinox_productos_fotos t2 WHERE t1.id_pro=t2.id_pro AND t1.id_pag=? AND t1.eliminado=? ORDER BY RAND() LIMIT 9")){
            if($sqls->bind_param("ii", $this->id_pag, $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();

                    for($i=0; $i<count($datas); $i++){
                        $id = $datas[$i]["id_pro"];
                        $res[$id]["id_pro"] = $datas[$i]["id_pro"];
                        $res[$id]["nombre"] = $datas[$i]["nombre"];
                        $res[$id]["descripcion"] = $datas[$i]["descripcion"];
                        $res[$id]["urls"] = $datas[$i]["urls"];
                        $res[$id]["fotos"][] = $datas[$i]["foto_nombre"];
                    }

                    return $res;
                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
    }
    private function child_prods($id_cat){
        if($sqls = $this->con->prepare("SELECT t1.id_pro, t1.nombre, t1.urls, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1 LEFT JOIN _usinox_productos_fotos t2 ON t1.id_pro=t2.id_pro WHERE t1.id_cat=? AND t1.eliminado=?")){
            if($sqls->bind_param("ii", $id_cat, $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    for($i=0; $i<count($datas); $i++){
                        $id = $datas[$i]["id_pro"];
                        $res[$id]["id_pro"] = $datas[$i]["id_pro"];
                        $res[$id]["nombre"] = $datas[$i]["nombre"];
                        $res[$id]["urls"] = $datas[$i]["urls"];
                        $res[$id]["descripcion"] = $datas[$i]["descripcion"];
                        if($datas[$i]["foto_nombre"] != null){
                            $res[$id]["fotos"][] = $datas[$i]["foto_nombre"];
                        }else{
                            $res[$id]["fotos"][0] = "sin_imagen.jpg";
                        }
                    }
                    return $res;

                }else{ return $this->htmlspecialchars($sqls->error); }
            }else{ return $this->htmlspecialchars($sqls->error); }
        }else{ return $this->htmlspecialchars($this->con->error); }
    }
    private function child_categoria($data, $id){
        $res = array();
        for($i=0; $i<count($data); $i++){
            if($data[$i]['parent_id'] == $id){
                $res[] = $data[$i];
            }
        }
        return $res;
    }
    private function get_relacionados($id_cat){

        if($sqls = $this->con->prepare("SELECT t1.urls, t1.id_pro, t1.nombre, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1, _usinox_productos_fotos t2 WHERE t1.id_cat=? AND t1.id_pro=t2.id_pro AND t1.eliminado=? ORDER BY RAND() LIMIT 4")){
            if($sqls->bind_param("ii", $id_cat, $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();
                    for($i=0; $i<count($datas); $i++){
                        $id = $datas[$i]["id_pro"];
                        $res[$id]["id_pro"] = $datas[$i]["id_pro"];
                        $res[$id]["nombre"] = $datas[$i]["nombre"];
                        $res[$id]["descripcion"] = $datas[$i]["descripcion"];
                        $res[$id]["url"] = $datas[$i]["urls"];
                        $res[$id]["fotos"][] = $datas[$i]["foto_nombre"];
                    }
                    return $res;

                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    private function process_producto($data, $url){

        if($sqls = $this->con->prepare("SELECT t1.id_cat, t1.id_pro, t1.nombre, t1.urls, t1.descripcion, t2.nombre as foto_nombre FROM _usinox_productos t1 LEFT JOIN _usinox_productos_fotos t2 ON t1.id_pro=t2.id_pro WHERE t1.urls=? AND t1.id_pag=?  AND t1.eliminado=?")){
            if($sqls->bind_param("sii", $url, $this->id_pag, $this->eliminado)){
                if($sqls->execute()){

                    $datas = $this->get_result($sqls);
                    $sqls->close();

                    if(count($datas) > 0){
                        $res['pro']["id_pro"] = $datas[0]["id_pro"];
                        $res['pro']["nombre"] = $datas[0]["nombre"];
                        $res['pro']["descripcion"] = $datas[0]["descripcion"];
                        for($i=0; $i<count($datas); $i++){
                            if($datas[$i]["foto_nombre"] != null){
                                $res['pro']["fotos"][] = $datas[$i]["foto_nombre"];
                            }else{
                                $res['pro']["fotos"][0] = "sin_imagen.jpg";
                            }
                        }
                        $res['parents'] = $this->resp_categorias($data, $datas[0]["id_cat"], 1);
                        $res['pro']['relacionados'] = $this->get_relacionados($datas[0]['id_cat']);
                    }
                    
                }else{ $this->htmlspecialchars($sqls->error); }
            }else{ $this->htmlspecialchars($sqls->error); }
        }else{ $this->htmlspecialchars($this->con->error); }
        return $res;

    }
    private function process_categoria($data, $url){
        for($i=0; $i<count($data); $i++){
            if($data[$i]['urls'] == $url){
                
                $res['nombre'] = $data[$i]['nombre'];
                if($data[$i]['parent_id'] > 0){
                    $res['parents'] = $this->resp_categorias($data, $data[$i]['parent_id'], 0);
                }
                $childs_cat = $this->child_categoria($data, $data[$i]['id_cat']);
                if(count($childs_cat) > 0){
                    $res['tipo'] = 'categorias';
                    $res['childs_cat'] = $childs_cat;
                }else{
                    $childs_prod = $this->child_prods($data[$i]['id_cat']);
                    if(count($childs_prod) > 0){
                        $res['tipo'] = 'productos';
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
    public function resp_categorias($data, $id_cat, $pro){

        $id_aux_cat = $id_cat;
        $n = array();
        $exit = 0;
        $res = "";
        while($exit == 0){
            for($i=0; $i<count($data); $i++){
                if($id_aux_cat == $data[$i]["id_cat"]){
                    $aux['nombre'] = $data[$i]["nombre"];
                    $aux['url'] = $data[$i]["urls"];
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
        $rev = array_reverse($n);
        for($i=0; $i<count($rev); $i++){
            $res .= "<a href='".$rev[$i]['url']."'>".$rev[$i]['nombre']."</a>";
            if($pro == 0 || ($pro == 1 && $i < count($rev) - 1)){ $res.= " > "; }
        }
        return $res;
    }
    private function buscar_cat_pro($url){

        echo "<pre>";
        print_r($url);
        echo "</pre>";

        if($sql = $this->con->prepare("SELECT id_cat, nombre, urls, foto, parent_id FROM _usinox_categorias WHERE id_pag=? AND eliminado=?")){
            if($sql->bind_param("ii", $this->id_pag, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    $cat = $this->process_categoria($data, $url);
                    if($cat == null){
                        $pro = $this->process_producto($data, $url);
                        if($pro == null){
                            header("HTTP/1.1 404 Not Found");
                            include '404.php';
                            exit;
                        }else{
                            $pro['tipo'] = "producto";
                            $pro['base'] = $this->get_base();
                            return $pro;
                        }
                    }else{
                        $cat['base'] = $this->get_base();
                        return $cat;
                    }
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
    private function htmlspecialchars($msg){
        return $msg;
    }

}

?>