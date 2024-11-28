<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmUsuario
$objUsuario = new AbmUsuario();
$response = $objUsuario->crearUsuario($datos);

echo json_encode($response);
exit();
