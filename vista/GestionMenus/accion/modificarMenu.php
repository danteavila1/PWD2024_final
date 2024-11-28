<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia de objeto AbmMenu para acceder a las funciones
$objCompra = new AbmMenu();
if ($objCompra->modificacion($datos)) {
    $response = ['mensaje' => 'Modificación exitosa', 'icono' => 'success'];
} else {
    $response = ['mensaje' => 'Modificación fallida', 'icono' => 'error'];
}

echo json_encode($response);
exit;
