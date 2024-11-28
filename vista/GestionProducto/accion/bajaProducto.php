<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto ABMProducto
$objProducto = new AbmProducto();

if ($objProducto->baja($datos)) {
    $response = ['mensaje' => "Baja exitosa", 'icono' => "success"];
} else {
    $response = ['mensaje' => "Baja fallida", 'icono' => "error"];
}

echo json_encode($response);
exit();
