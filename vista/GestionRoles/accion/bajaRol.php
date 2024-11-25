<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmRol
$objRol = new AbmRol();

// Realizo la baja del usuario
if ($objRol->baja($datos)) {
    $response = ['mensaje' => "Rol eliminado", 'icono' => "success"];
} else {
    $response = ['mensaje' => "Falló eliminar rol", 'icono' => "error"];
}

echo json_encode($response);
exit();
