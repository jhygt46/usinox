<?php

header('Content-type: text/json');
header('Content-type: application/json');

require_once "../class/guardar_class.php";
$guardar = new Guardar();
$data = $guardar->process();
echo json_encode($data);


?>