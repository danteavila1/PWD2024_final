<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia de objeto AbmCompraEstado para acceder a las funciones
$objCompra = new AbmCompraEstado();

// Extraigo la acción elegida
$accion = $datos['accion'];

// Ejecuto funciones dependiendo la acción y muestro mensajes
if ($accion == 'Aceptar') {
    // Preparo array con mensajes éxito o error
    $mensaje = $objCompra->aceptarCompra($datos);
    if ($mensaje['exito']) {
        $response = ['mensaje' => $mensaje['msj'], 'icono' => 'success'];
    } else {
        $response = ['mensaje' => $mensaje['msj'], 'icono' => 'error'];
    }
} elseif ($accion == 'Enviar') {
    // Preparo array con mensajes éxito o error
    $mensaje = $objCompra->enviarCompra($datos);
    if ($mensaje['exito']) {
        $response = ['mensaje' => $mensaje['msj'], 'icono' => 'success'];
    } else {
        $response = ['mensaje' => $mensaje['msj'], 'icono' => 'error'];
    }
} else {
    // Preparo array con mensajes éxito o error
    $mensaje = $objCompra->cancelarCompra($datos);
    if ($mensaje['exito']) {
        $response = ['mensaje' => $mensaje['msj'], 'icono' => 'success'];
    } else {
        $response = ['mensaje' => $mensaje['msj'], 'icono' => 'error'];
    }
}

echo json_encode($response);
exit;
