<?php
include_once('../../../configuracion.php');

// Recibe los datos enviados en el formulario
$datos = data_submitted();

$objRol = new AbmRol();
$response = $objRol->crearRol($datos);

echo json_encode($response);
exit;
