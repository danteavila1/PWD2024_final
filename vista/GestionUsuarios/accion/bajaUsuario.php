<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

$objUsuario = new AbmUsuario();

if ($objUsuario->baja($datos)) {
    $response = ['mensaje' => "Borrado lógico exitoso", 'icono' => "success"];
} else {
    $response = ['mensaje' => "Borrado lógico fallido", 'icono' => "error"];
}

echo json_encode($response);
exit();
