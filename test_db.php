<?php 
    set_time_limit(0);
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

    echo "<pre>";
    print_r(insert_parents($parents, $mysqli));
    echo "</pre>";

    function insert_parents($parents, $mysqli){

        $eliminado = 0;
        $fotos[] = array();

        for($i=0; $i<count($parents); $i++){
            $id_pag = 1;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_categorias (nombre, urls, parent_id, orden, fecha, id_pag, eliminado) VALUES (?, ?, ?, ?, NOW(), ?, ?)")){
                if($stmt->bind_param('ssiiii', $parents[$i]['nombre'], get_url($parents[$i]['nombre']), $eliminado, $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $parent_id_cat_1 = $stmt->insert_id;
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }
            $id_pag = 2;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_categorias (nombre, urls, parent_id, orden, fecha, id_pag, eliminado) VALUES (?, ?, ?, ?, NOW(), ?, ?)")){
                if($stmt->bind_param('ssiiii', $parents[$i]['nombre'], get_url($parents[$i]['nombre']), $eliminado, $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $parent_id_cat_2 = $stmt->insert_id;
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }
            $cats = get_categorias($parents[$i]['id'], $mysqli);
            for($j=0; $j<count($cats); $j++){

                $file_usi = "";
                $file_nep = "";

                if(file_exists("admin/imagenes/".$cats[$j]['foto'])){
                    $file = explode(".", $cats[$j]['foto']);
                    $fotos[] = $cats[$j]['foto'];
                    //file_get_contents("http://35.202.149.15/get_foto.php?file=".$cats[$j]['foto']);
                    $file_usi = $file[0]."0.".$file[1];
                    $file_nep = $file[0]."1.".$file[1];
                }

                $id_pag = 1;
                if($sql = $mysqli->prepare("INSERT INTO _usinox_categorias (nombre, urls, foto, parent_id, orden, fecha, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)")){
                    if($sql->bind_param('sssiiii', $cats[$j]['nombre'], get_url($cats[$j]['nombre']), $file_usi, $parent_id_cat_1, $j, $id_pag, $eliminado)){
                        if($sql->execute()){
                            $parent_id_pro_1 = $sql->insert_id;
                            $sql->close();
                        }else{ return $sql->error; }
                    }else{ return $sql->error; }
                }else{ return $mysqli->error; }
                $id_pag = 2;
                if($sql = $mysqli->prepare("INSERT INTO _usinox_categorias (nombre, urls, foto, parent_id, orden, fecha, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)")){
                    if($sql->bind_param('sssiiii', $cats[$j]['nombre'], get_url($cats[$j]['nombre']), $file_nep, $parent_id_cat_2, $j, $id_pag, $eliminado)){
                        if($sql->execute()){
                            $parent_id_pro_2 = $sql->insert_id;
                            $sql->close();
                        }else{ return $sql->error; }
                    }else{ return $sql->error; }
                }else{ return $mysqli->error; }
                $prods = get_productos($cats[$j]['id'], $mysqli);
                for($z=0; $z<count($prods); $z++){

                    $file_usis = "";
                    $file_neps = "";
                    if(file_exists("admin/imagenes/".$prods[$z]['foto'])){
                        $files = explode(".", $prods[$z]['foto']);
                        $fotos[] = $prods[$z]['foto'];
                        //file_get_contents("http://35.202.149.15/get_foto.php?file=".$prods[$z]['foto']);
                        $file_usis = $files[0]."0.".$files[1];
                        $file_neps = $files[0]."1.".$files[1];
                    }

                    $id_pag = 1;
                    if($sql = $mysqli->prepare("INSERT INTO _usinox_productos (nombre, urls, descripcion, precio, ficha, manual, oferta, novedad, orden, fecha, id_cat, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)")){
                        if($sql->bind_param('sssissiiiiii', $prods[$z]['titulo'], get_url($prods[$z]['titulo']), $prods[$z]['descripcion'], $prods[$z]['precio'], $prods[$z]['pdf'], $prods[$z]['manual'], $prods[$z]['of'], $prods[$z]['nv'], $z, $parent_id_pro_1, $id_pag, $eliminado)){
                            if($sql->execute()){
                                $id_pro_1 = $sql->insert_id;
                                if($sql2 = $mysqli->prepare("INSERT INTO _usinox_productos_fotos (nombre, id_pro) VALUES (?, ?)")){
                                    if($sql2->bind_param('si', $file_usis, $id_pro_1)){
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
                    if($sql = $mysqli->prepare("INSERT INTO _usinox_productos (nombre, urls, descripcion, precio, ficha, manual, oferta, novedad, orden, fecha, id_cat, id_pag, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)")){
                        if($sql->bind_param('sssissiiiiii', $prods[$z]['titulo'], get_url($prods[$z]['titulo']), $prods[$z]['descripcion'], $prods[$z]['precio'], $prods[$z]['pdf'], $prods[$z]['manual'], $prods[$z]['of'], $prods[$z]['nv'], $z, $parent_id_pro_2, $id_pag, $eliminado)){
                            if($sql->execute()){
                                $id_pro_2 = $sql->insert_id;
                                if($sql2 = $mysqli->prepare("INSERT INTO _usinox_productos_fotos (nombre, id_pro) VALUES (?, ?)")){
                                    if($sql2->bind_param('si', $file_neps, $id_pro_2)){
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
        $videos = get_videos($mysqli);
        for($i=0; $i<count($videos); $i++){

            $id_pag = 1;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_videos (urls, orden, id_pag, eliminado) VALUES (?, ?, ?, ?)")){
                if($stmt->bind_param('siii', $videos[$i]['url'], $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }

            $id_pag = 2;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_videos (urls, orden, id_pag, eliminado) VALUES (?, ?, ?, ?)")){
                if($stmt->bind_param('siii', $videos[$i]['url'], $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }

        }
        $noticias = get_noticias($mysqli);
        for($i=0; $i<count($noticias); $i++){

            $id_pag = 1;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_noticias (nombre, descripcion, fecha, orden, id_pag, eliminado) VALUES (?, ?, NOW(), ?, ?, ?)")){
                if($stmt->bind_param('ssiii', $noticias[$i]['nombre'], $noticias[$i]['text'], $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $id_not = $stmt->insert_id;
                        for($j=1; $j<=6; $j++){
                            $foto_not = ($j == 1) ? $noticias[$i]['foto'] : $noticias[$i]['foto'.$j] ;
                            if($foto_not != ""){
                                $fotos[] = $foto_not;
                                if($stmt2 = $mysqli->prepare("INSERT INTO _usinox_noticias_fotos (nombre, id_not) VALUES (?, ?)")){
                                    if($stmt2->bind_param('si', $foto_not, $id_not)){
                                        if($stmt2->execute()){
                                            $stmt2->close();
                                        }else{ return $stmt2->error; }
                                    }else{ return $stmt2->error; }
                                }else{ return $mysqli->error; }
                            }
                        }
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }

            $id_pag = 2;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_noticias (nombre, descripcion, fecha, orden, id_pag, eliminado) VALUES (?, ?, NOW(), ?, ?, ?)")){
                if($stmt->bind_param('ssiii', $noticias[$i]['nombre'], $noticias[$i]['text'], $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $id_not = $stmt->insert_id;
                        for($j=1; $j<=6; $j++){
                            $foto_not = ($j == 1) ? $noticias[$i]['foto'] : $noticias[$i]['foto'.$j] ;
                            if($foto_not != ""){
                                if($stmt2 = $mysqli->prepare("INSERT INTO _usinox_noticias_fotos (nombre, id_not) VALUES (?, ?)")){
                                    if($stmt2->bind_param('si', $foto_not, $id_not)){
                                        if($stmt2->execute()){
                                            
                                            $stmt2->close();
                                        }else{ return $stmt2->error; }
                                    }else{ return $stmt2->error; }
                                }else{ return $mysqli->error; }
                            }
                        }
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }

        }
        $proyectos = get_proyectos($mysqli);
        for($i=0; $i<count($proyectos); $i++){

            $id_pag = 1;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_proyectos (nombre, descripcion, fecha, orden, id_pag, eliminado) VALUES (?, ?, NOW(), ?, ?, ?)")){
                if($stmt->bind_param('ssiii', $proyectos[$i]['nombre'], $proyectos[$i]['text'], $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $id_proy = $stmt->insert_id;
                        for($j=1; $j<=6; $j++){
                            $foto_proy = ($j == 1) ? $proyectos[$i]['foto'] : $proyectos[$i]['foto'.$j] ;
                            if($foto_proy != ""){
                                $fotos[] = $foto_proy;
                                if($stmt2 = $mysqli->prepare("INSERT INTO _usinox_proyectos_fotos (nombre, id_pro) VALUES (?, ?)")){
                                    if($stmt2->bind_param('si', $foto_proy, $id_proy)){
                                        if($stmt2->execute()){
                                            $stmt2->close();
                                        }else{ return $stmt2->error; }
                                    }else{ return $stmt2->error; }
                                }else{ return $mysqli->error; }
                            }
                        }
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }

            $id_pag = 2;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_proyectos (nombre, descripcion, fecha, orden, id_pag, eliminado) VALUES (?, ?, NOW(), ?, ?, ?)")){
                if($stmt->bind_param('ssiii', $proyectos[$i]['nombre'], $proyectos[$i]['text'], $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $id_proy = $stmt->insert_id;
                        for($j=1; $j<=6; $j++){
                            $foto_proy = ($j == 1) ? $proyectos[$i]['foto'] : $proyectos[$i]['foto'.$j] ;
                            if($foto_proy != ""){
                                if($stmt2 = $mysqli->prepare("INSERT INTO _usinox_proyectos_fotos (nombre, id_pro) VALUES (?, ?)")){
                                    if($stmt2->bind_param('si', $foto_proy, $id_proy)){
                                        if($stmt2->execute()){
                                            $stmt2->close();
                                        }else{ return $stmt2->error; }
                                    }else{ return $stmt2->error; }
                                }else{ return $mysqli->error; }
                            }
                        }
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }

        }
        $galeria = get_galeria($mysqli);
        for($i=0; $i<count($galeria); $i++){

            $fotos[] = $galeria[$i]['foto'];

            $id_pag = 1;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_galeria (nombre, alt, orden, id_pag, eliminado) VALUES (?, ?, ?, ?, ?)")){
                if($stmt->bind_param('ssiii', $galeria[$i]['foto'], $galeria[$i]['nombre'], $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }

            $id_pag = 2;
            if($stmt = $mysqli->prepare("INSERT INTO _usinox_galeria (nombre, alt, orden, id_pag, eliminado) VALUES (?, ?, ?, ?, ?)")){
                if($stmt->bind_param('ssiii', $galeria[$i]['foto'], $galeria[$i]['nombre'], $i, $id_pag, $eliminado)){
                    if($stmt->execute()){
                        $stmt->close();
                    }else{ return $stmt->error; }
                }else{ return $stmt->error; }
            }else{ return $mysqli->error; }

        }

        file_put_contents("lista_fotos.json", json_encode($fotos));

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
    function get_videos($mysqli){
        $id = 0;
        if($stmt = $mysqli->prepare("SELECT * FROM videos WHERE id>?")){
            if($stmt->bind_param('i', $id)){
                if($stmt->execute()){
                    $res = get_result($stmt);
                    $stmt->close();
                    return $res;
                }
            }
        }
    }
    function get_noticias($mysqli){
        $id = 0;
        if($stmt = $mysqli->prepare("SELECT * FROM noticias WHERE id>?")){
            if($stmt->bind_param('i', $id)){
                if($stmt->execute()){
                    $res = get_result($stmt);
                    $stmt->close();
                    return $res;
                }
            }
        }
    }
    function get_proyectos($mysqli){
        $id = 0;
        if($stmt = $mysqli->prepare("SELECT * FROM proyectos WHERE id>?")){
            if($stmt->bind_param('i', $id)){
                if($stmt->execute()){
                    $res = get_result($stmt);
                    $stmt->close();
                    return $res;
                }
            }
        }
    }
    function get_galeria($mysqli){
        $id = 0;
        if($stmt = $mysqli->prepare("SELECT * FROM imagenes WHERE id>?")){
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