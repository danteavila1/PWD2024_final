<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmRol
$objRol = new AbmRol();

$existe = $objRol->existeRol($datos);

// Verifico si existe para poder realizar la modificación
if ($existe) {
    $response = ['mensaje' => 'Rol existente', 'icono' => 'info'];
} else {
    if ($objRol->modificacion($datos)) {
        $response = ['mensaje' => 'Modificación exitosa', 'icono' => 'success'];
    } else {
        $response = ['mensaje' => 'Falló la modificación', 'icono' => 'error'];
    }
}

echo json_encode($response);
exit();
