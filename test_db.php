<?php 

    date_default_timezone_set('america/santiago');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $mysqli = new mysqli("localhost", "usinox_usinox", "usinox", "usinox_usinox");
    //$mysqli = new mysqli("localhost", "root", "12345678", "usinox");
    
    $parents[0]['id'] = 1;
    $parents[0]['nombre'] = "Cocina Caliente";
    $parents[1]['id'] = 2;
    $parents[1]['nombre'] = "Cocina Fria";
    $parents[2]['id'] = 3;
    $parents[2]['nombre'] = "Zona Lavado";
    $parents[3]['id'] = 4;
    $parents[3]['nombre'] = "Zona snack";
    $parents[4]['id'] = 5;
    $parents[4]['nombre'] = "Autoservicio";
    $parents[5]['id'] = 6;
    $parents[5]['nombre'] = "Bodega y Almacenaje";
    $parents[6]['id'] = 7;
    $parents[6]['nombre'] = "Zona Bar";
    $parents[7]['id'] = 8;
    $parents[7]['nombre'] = "Equipamento Menor";
    $parents[8]['id'] = 9;
    $parents[8]['nombre'] = "Food Truck";

    /*
    echo "<pre>";
    print_r(insert_parents($parents, $mysqli));
    echo "</pre>";
    */

    function insert_parents($parents, $mysqli){
        
        for($i=0; $i<count($parents); $i++){
            $eliminado = 0;
            $id_pag = 1;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_categorias (nombre, urls, parent_id, orden, fecha, id_pag, eliminado) VALUES (?, ?, ?, ?, NOW(), ?, ?)")){
                if($stmt->bind_param('ssiiii', $parents[$i]['nombre'], get_url($parents[$i]['nombre']), $eliminado, $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $parent_id_cat_1 = $stmt->insert_id;
                        echo "parent_id_cat_1: ".$parent_id_cat_1."<br/>";
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }
            $id_pag = 2;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_categorias (nombre, urls, parent_id, orden, fecha, id_pag, eliminado) VALUES (?, ?, ?, ?, NOW(), ?, ?)")){
                if($stmt->bind_param('ssiiii', $parents[$i]['nombre'], get_url($parents[$i]['nombre']), $eliminado, $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $parent_id_cat_2 = $stmt->insert_id;
                        echo "parent_id_cat_2: ".$parent_id_cat_2."<br/>";
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }
            
            $cats = get_categorias($parents[$i]['id'], $mysqli);
            for($j=0; $j<count($cats); $j++){
                $id_pag = 1;
                if($sql = $mysqli->prepare("INSERT INTO _usinox_categorias (nombre, urls, parent_id, orden, fecha, id_pag, eliminado) VALUES (?, ?, ?, ?, NOW(), ?, ?)")){
                    if($sql->bind_param('ssiiii', $cats[$j]['nombre'], get_url($cats[$j]['nombre']), $parent_id_cat_1, $j, $id_pag, $eliminado)){
                        if($sql->execute()){
                            $parent_id_pro_1 = $sql->insert_id;
                            $sql->close();
                        }else{ return $sql->error; }
                    }else{ return $sql->error; }
                }else{ return $mysqli->error; }
                $id_pag = 2;
                if($sql = $mysqli->prepare("INSERT INTO _usinox_categorias (nombre, urls, parent_id, orden, fecha, id_pag, eliminado) VALUES (?, ?, ?, ?, NOW(), ?, ?)")){
                    if($sql->bind_param('ssiiii', $cats[$j]['nombre'], get_url($cats[$j]['nombre']), $parent_id_cat_2, $j, $id_pag, $eliminado)){
                        if($sql->execute()){
                            $parent_id_pro_2 = $sql->insert_id;
                            $sql->close();
                        }else{ return $sql->error; }
                    }else{ return $sql->error; }
                }else{ return $mysqli->error; }
                $prods = get_productos($cats[$j]['id'], $mysqli);
                for($z=0; $z<count($prods); $z++){
                    $id_pag = 1;
                    if($sql = $mysqli->prepare("INSERT INTO _usinox_productos (nombre, urls, descripcion, precio, ficha, manual, orden, fecha, id_cat, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)")){
                        if($sql->bind_param('sssissiiii', $prods[$z]['titulo'], get_url($prods[$z]['titulo']), $prods[$z]['descripcion'], $prods[$z]['precio'], $prods[$z]['pdf'], $prods[$z]['manual'], $z, $parent_id_pro_1, $id_pag, $eliminado)){
                            if($sql->execute()){
                                $id_pro_1 = $sql->insert_id;
                                if($sql2 = $mysqli->prepare("INSERT INTO _usinox_productos_fotos (nombre, id_pro) VALUES (?, ?)")){
                                    if($sql2->bind_param('si', $prods[$z]['foto'], $id_pro_1)){
                                        if($sql2->execute()){
                                            $sql2->close();
                                        }else{ return $sql2->error; }
                                    }else{ return $sql2->error; }
                                }else{ return $mysqli->error; }
                                $sql->close();
                            }else{ return $sql->error; }
                        }else{ return $sql->error; }
                    }else{ return $mysqli->error; }
                    $id_pag = 2;
                    if($sql = $mysqli->prepare("INSERT INTO _usinox_productos (nombre, urls, descripcion, precio, ficha, manual, orden, fecha, id_cat, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)")){
                        if($sql->bind_param('sssissiiii', $prods[$z]['titulo'], get_url($prods[$z]['titulo']), $prods[$z]['descripcion'], $prods[$z]['precio'], $prods[$z]['pdf'], $prods[$z]['manual'], $z, $parent_id_pro_2, $id_pag, $eliminado)){
                            if($sql->execute()){
                                $id_pro_2 = $sql->insert_id;
                                if($sql2 = $mysqli->prepare("INSERT INTO _usinox_productos_fotos (nombre, id_pro) VALUES (?, ?)")){
                                    if($sql2->bind_param('si', $prods[$z]['foto'], $id_pro_2)){
                                        if($sql2->execute()){
                                            $sql2->close();
                                        }else{ return $sql2->error; }
                                    }else{ return $sql2->error; }
                                }else{ return $mysqli->error; }
                                $sql->close();
                            }else{ return $sql->error; }
                        }else{ return $sql->error; }
                    }else{ return $mysqli->error; }
                    if($sql = $mysqli->prepare("INSERT INTO _usinox_prod_rel (id_pro1, id_pro2) VALUES (?, ?)")){
                        if($sql->bind_param('ii', $id_pro_1, $id_pro_2)){
                            if($sql->execute()){
                                $sql->close();
                            }else{ return $sql->error; }
                        }else{ return $sql->error; }
                    }else{ return $mysqli->error; }
                }
            }
            
        }
    }
    function get_productos($id, $mysqli){
        if($stmt = $mysqli->prepare("SELECT * FROM productos WHERE id_ficha=? ORDER BY orden")){
            if($stmt->bind_param('i', $id)){
                if($stmt->execute()){
                    $res = get_result($stmt);
                    $stmt->close();
                    return $res;
                }
            }
        }
    }
    function get_categorias($id, $mysqli){
        if($stmt = $mysqli->prepare("SELECT * FROM ficha WHERE tipo=? ORDER BY orden")){
            if($stmt->bind_param('i', $id)){
                if($stmt->execute()){
                    $res = get_result($stmt);
                    $stmt->close();
                    return $res;
                }
            }
        }
    }
    function get_url($n){
        return str_replace(' ', '-', strtolower($n));
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
    

?>