<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmUsuario
$objUsuario = new AbmUsuario();

// Compruebo si existe el usuario
$existeMail = $objUsuario->existeMail($datos);
$existeUsuario = $objUsuario->existeUsuario($datos);

// Respuestas en caso de que existan los datos
if ($existeUsuario) {
    $response = ['mensaje' => 'Nombre de usuario existente', 'icono' => 'info'];
} elseif ($existeMail) {
    $response = ['mensaje' => 'Mail existente', 'icono' => 'info'];
}

// Modificación
if (!$existeMail && !$existeUsuario) {
    if ($objUsuario->modificacion($datos)) {
        $response = ['mensaje' => 'Modificación exitosa', 'icono' => 'success'];
    } else {
        $response = ['mensaje' => 'Falló la modificación', 'icono' => 'success'];
    }
}

echo json_encode($response);
exit;
