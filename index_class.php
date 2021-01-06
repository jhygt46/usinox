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

        if($_SERVER['HTTPS'] != "on"){
            $redirect = "https://".$domain.$_SERVER['REQUEST_URI'];
            header("Location: ".$redirect);
        }else{

            if($domain == "www.usinox.cl"){ 
                $sitio = 0; 
            }
            if($domain == "www.marmitas.cl"){ 
                $sitio = 0; 
            }
            if($domain == "www.equiposgastronomicosneptuno.cl"){ 
                $sitio = 1; 
            }
            if($domain == "www.egneptuno.cl"){ 
                $sitio = 1; 
            }
            
            //$info["config"] = $this->get_config($sitio);

            if($url[1] == ""){
                $info['tipo'] = "inicio";
            }else if($url[1] == "contacto" || $url[1] == "nosotros" || $url[1] == "servicios"){
                $info['tipo'] = "pagina";
                $info['pagina'] = $url[1];
            }else{
                $info = $this->buscar_categoria_productos($sitio, $url[1]);
            }

            return $info;
                    
            

        }

    }
    private function buscar_categoria_productos($sitio, $url){

        if($sql = $this->con->prepare("SELECT * FROM _usinox_categorias WHERE sitio=? AND urls=? AND eliminado=?")){
            if($sql->bind_param("isi", $sitio, $url, $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);

                    if(!count($data) == 0){
                        $info['tipo'] = "categoria";
                        $info['data'] = $data[0];
                    }else{
                        if($sqls = $this->con->prepare("SELECT * FROM _usinox_productos WHERE sitio=? AND urls=? AND eliminado=?")){
                            if($sqls->bind_param("isi", $sitio, $url, $this->eliminado)){
                                if($sqls->execute()){
                                    $datas = $this->get_result($sqls);
                                    if(!count($datas) == 0){
                                        $info['tipo'] = "producto";
                                        $info['data'] = $datas[0];
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