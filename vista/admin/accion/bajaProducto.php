<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto ABMProducto
$objProducto = new AbmProducto();

// Realizo la baja del producto
if ($objProducto->baja($datos)) {
    $response = ['mensaje' => "Producto eliminado", 'icono' => "success"];
} else {
    $response = ['mensaje' => "Falló eliminar producto", 'icono' => "error"];
}

echo json_encode($response);
exit();
