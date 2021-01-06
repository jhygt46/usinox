<?php 

    date_default_timezone_set('america/santiago');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $mysqli = new mysqli("localhost", "usinox_usinox", "usinox", "usinox_usinox");
    //$mysqli = new mysqli("localhost", "root", "12345678", "usinox");
    

    $id = 12;
    $mail = "diego@gomez.com";
    if($stmt = $mysqli->prepare("UPDATE bloqueo SET mail=? WHERE id=?")){
        if($stmt->bind_param('si', $mail, $id)){
            if($stmt->execute()){
                $stmt->close();
            }
        }
    }

    /*
    $id = 5;
    if($stmt = $mysqli->prepare("SELECT nombre, foto FROM categorias WHERE id=?")){
        if($stmt->bind_param('i', $id)){
            if($stmt->execute()){
                $res = get_result($stmt);
                echo "<pre>";
                print_r($res);
                echo "</pre>";
            }
        }
    }
    
    function get_result($stmt){
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
    */

?>