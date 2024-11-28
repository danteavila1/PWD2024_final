<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia de objeto AbmMenu para acceder a las funciones
$objCompra = new AbmMenu();
if ($objCompra->alta($datos)) {
    $response = ['mensaje' => 'Alta exitosa', 'icono' => 'success'];
} else {
    $response = ['mensaje' => 'Alta fallida', 'icono' => 'success'];
}

echo json_encode($response);
