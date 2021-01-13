<?php
    session_start();


    if($_POST["accion"] == "cotizar"){

        $count = 0;
        $esta = false;

        for($i=0; $i<count($_SESSION["prods"]); $i++){
            if($_SESSION["prods"][$i]['id'] == $_POST['id']){
                if($_POST['cant'] == 1){
                    $_SESSION["prods"][$i]['cant'] = $_SESSION["prods"][$i]['cant'] + 1;
                }
                if($_POST['cant'] == 0){
                    $_SESSION["prods"][$i]['cant'] = 0;
                }
                if($_POST['cant'] > 1){
                    $_SESSION["prods"][$i]['cant'] = $_POST['cant'];
                }
                $esta = true;
            }
            $count = $count + $_SESSION["prods"][$i]['cant'];
        }

        if(!$esta){

            $count = $count + $_POST['cant'];
            $ids = count($_SESSION["prods"]);
            $_SESSION["prods"][$ids]['id'] = $_POST['id'];
            $_SESSION["prods"][$ids]['cant'] = $_POST['cant'];

        }

        $data['count'] = $count;
        echo json_encode($data);

    }

?>
