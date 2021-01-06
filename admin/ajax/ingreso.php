<?php

header('Content-type: text/json');
header('Content-type: application/json');

require_once "../class/ingreso_class.php";
$ingreso = new Ingreso();
$info = $ingreso->ingresar_user();
echo json_encode($info);

?>