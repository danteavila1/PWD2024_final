<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmUsuario
$objUsuario = new AbmUsuario();

// Realizo la baja del usuario
if ($objUsuario->baja($datos)) {
    $response = ['mensaje' => "Borrado lógico con éxito", 'icono' => "success"];
} else {
    $response = ['mensaje' => "Borrado lógico fallido", 'icono' => "error"];
}

echo json_encode($response);
exit();
