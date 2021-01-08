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
                $info = $this->buscar_categoria_productos($sitio, $url[1]);
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
    private function buscar_categoria_productos($id_pag, $url){

        if($sql = $this->con->prepare("SELECT * FROM _usinox_categorias WHERE id_pag=? AND urls=? AND eliminado=?")){
            if($sql->bind_param("isi", $id_pag, $url, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);

                    echo "<pre>";
                    print_r($data);
                    echo "</pre>";

                    if(!count($data) == 0){
                        $info['tipo'] = "categoria";
                        $info['data'] = $data[0];
                    }else{
                        if($sqls = $this->con->prepare("SELECT * FROM _usinox_productos WHERE id_pag=? AND urls=? AND eliminado=?")){
                            if($sqls->bind_param("isi", $id_pag, $url, $this->eliminado)){
                                if($sqls->execute()){
                                    $datas = $this->get_result($sqls);
                                    echo "<pre>";
                                    print_r($datas);
                                    echo "</pre>";
                                    if(!count($datas) == 0){
                                        $info['tipo'] = "producto";
                                        $info['data'] = $datas[0];
                                    }else{
                                        //header("HTTP/1.1 404 Not Found");
                                        //require '404.php';
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