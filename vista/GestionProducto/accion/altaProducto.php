<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmProducto
$objProducto = new AbmProducto();
$response = $objProducto->crearProducto($datos);

echo json_encode($response);
exit;
