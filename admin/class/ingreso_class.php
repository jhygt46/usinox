<?php


require_once "../../config.php";

class Ingreso {
    
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
    public function verificar_usuario(){
        if($sql = $this->con->prepare("SELECT * FROM _usinox_usuarios WHERE id_user=? AND secure_hash=?  AND eliminado=?")){
            if($sql->bind_param("isi", $_COOKIE['id_user'], $_COOKIE['secure_hash'], $this->eliminado)){
                if($sql->execute()){
                    $usuarios = $this->get_result($sql);
                    if(count($usuarios) == 1){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    }
    public function ingresar_user(){
        if(filter_var($_POST['user'], FILTER_VALIDATE_EMAIL)){
            if($sql = $this->con->prepare("SELECT * FROM _usinox_usuarios WHERE correo=? AND eliminado=?")){
                if($sql->bind_param("si", $_POST["user"], $this->eliminado)){
                    if($sql->execute()){
                        $usuarios = $this->get_result($sql);
                        if(count($usuarios) == 0){
                            $info['op'] = 2;
                            $info['message'] = "Error: Usuario no existe";
                        }
                        if(count($usuarios) == 1){
                            $id_user = $usuarios[0]["id_user"];
                            $acciones = $this->get_acciones($id_user, 1);
                            if($acciones < 5){
                                $pass = $usuarios[0]["password"];
                                if($pass == md5($_POST['pass'])){
                                    $secure = $usuarios[0]["secure_hash"];
                                    $tiempo = time() + 10 * 365 * 24 * 60 * 60;
                                    if($secure == ""){
                                        $secure_hash = $this->pass_generate(60);
                                        if($stmt = $this->con->prepare("UPDATE _usinox_usuarios SET secure_hash=? WHERE id_user=?")){
                                            if($stmt->bind_param('si', $secure_hash, $id_user)){
                                                if($stmt->execute()){
                                                    $stmt->close();
                                                    setcookie('id_user', $id_user, $tiempo, '/admin2', '', true, true);
                                                    setcookie('secure_hash', $secure_hash, $tiempo, '/admin2', '', true, true);
                                                    $info['op'] = 1;
                                                    $info['tipo'] = 0;
                                                    $info['message'] = "Ingreso Exitoso";
                                                }
                                            }
                                        }
                                    }else{
                                        setcookie('id_user', $id_user, $tiempo, '/admin2', '', true, true);
                                        setcookie('secure_hash', $secure, $tiempo, '/admin2', '', true, true);
                                    }
                                }else{
                                    $this->set_acciones($id_user, 1);
                                    $info['op'] = 2;
                                    $info['message'] = "Contrase&ntilde;a Invalida";
                                }
                            }else{
                                $info['op'] = 2;
                                $info['message'] = "Contrase&ntilde;a Bloqueada";
                            }
                        }
                    }else{ echo htmlspecialchars($sql->error); }
                }else{ echo htmlspecialchars($sql->error); }
            }else{ echo htmlspecialchars($this->con->error); }
        }
        return $info;
    }
    private function get_acciones($id_user, $tipo){
        if($sql = $this->con->prepare("SELECT * FROM _usinox_acciones WHERE id_user=? AND tipo=? AND fecha > DATE_ADD(NOW(), INTERVAL -1 DAY)")){
            if($sql->bind_param("ii", $id_user, $tipo)){
                if($sql->execute()){
                    $res = $this->get_result($sql);
                    $sql->free_result();
                    $sql->close();
                    return count($res);
                }else{ $this->registrar(6, 0, 0, 'get_acciones() #1a '.$sql->error); }
            }else{ $this->registrar(6, 0, 0, 'get_acciones() #1b '.$sql->error); }
        }else{ $this->registrar(6, 0, 0, 'get_acciones() #1c '.$this->con->error); }
    }
    private function set_acciones($id_user, $tipo){
        if($sql = $this->con->prepare("INSERT INTO _usinox_acciones (tipo, fecha, id_user) VALUES (?, now(), ?)")){
            if($sql->bind_param("ii", $tipo, $id_user)){
                if($sql->execute()){
                    $sql->close();
                }else{ $this->registrar(6, 0, 0, 'set_acciones() #1a '.$sql->error); }
            }else{ $this->registrar(6, 0, 0, 'set_acciones() #1b '.$sql->error); }
        }else{ $this->registrar(6, 0, 0, 'set_acciones() #1c '.$this->con->error); }
    }
    private function pass_generate($n){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $r = "";
        for($i=0; $i<$n; $i++){
            $r .= $chars{rand(0, strlen($chars)-1)};
        }
        return $r;
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