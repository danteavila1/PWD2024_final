<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmMenu
$objMenu = new AbmMenu();

$response = $objMenu->deshabilitar($datos);

echo json_encode($response);
exit;
