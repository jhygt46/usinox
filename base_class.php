<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

class Base{
    
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
    private function get_pagina(){

        if($sql = $this->con->prepare("SELECT * FROM _usinox_pagina_url t1, _usinox_paginas t2 WHERE t1.urls=? AND t1.id_pag=t2.id_pag AND t2.eliminado=?")){
            if($sql->bind_param("si", $_SERVER['HTTP_HOST'], $this->eliminado)){
                if($sql->execute()){
                    $data = $this->get_result($sql);
                    $sql->close();
                    if(count($data) == 1){
                        $id_pag = $data[0]['id_pag'];
                        if($sql = $this->con->prepare("SELECT * FROM _usinox_categorias WHERE id_pag=? AND parent_id=? AND eliminado=?")){
                            if($sql->bind_param("iii", $id_pag, $this->eliminado, $this->eliminado)){
                                if($sql->execute()){
                                    $data = $this->get_result($sql);
                                    $sql->close();
                                    return $data;
                                }else{ $this->htmlspecialchars($sql->error); }
                            }else{ $this->htmlspecialchars($sql->error); }
                        }else{ $this->htmlspecialchars($this->con->error); }
                    }else{
                        die("PAGINA NO ENCONTRADA");
                    }
                }else{ $this->htmlspecialchars($sql->error); }
            }else{ $this->htmlspecialchars($sql->error); }
        }else{ $this->htmlspecialchars($this->con->error); }

    }
    private function htmlspecialchars($msg){
        return $msg;
    }

}

?>