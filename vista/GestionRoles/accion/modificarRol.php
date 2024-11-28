<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

$objRol = new AbmRol();
$response = $objRol->modificarRol($datos);

echo json_encode($response);
exit();
