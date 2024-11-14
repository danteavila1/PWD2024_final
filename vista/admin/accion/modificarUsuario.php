<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmUsuario
$objUsuario = new AbmUsuario();
$idusuario = $datos['idusuario'];

// Obtengo al usuario actual y sus datos actuales antes de modificarse
$usuario = $objUsuario->buscar(['idusuario' => $idusuario]);
$nombreActual = $usuario[0]->getUsNombre();
$mailActual = $usuario[0]->getUsMail();

// Obtengo los datos recibidos del formulario
$nombreForm = $datos['usnombre'];
$mailForm = $datos['usmail'];

// Obtengo todos los usuarios
$colUsuarios = $objUsuario->buscar("");
$nombreDuplicado = false;
$mailDuplicado = false;
$mismaPass = false;

// Recorro todos los usuarios para ver si ya existen dichos datos
foreach ($colUsuarios as $usuarioExistente) {
    if ($usuarioExistente->getIdUsuario() != $idusuario) {
        if ($usuarioExistente->getUsNombre() == $nombreForm) {
            $nombreDuplicado = true;
        }
        if ($usuarioExistente->getUsMail() == $mailForm) {
            $mailDuplicado = true;
        }
    }
}

// Verifico si es posible modificar
if (!$nombreDuplicado && !$mailDuplicado) {
    if ($objUsuario->modificacion($datos)) {
        $response = ['mensaje' => "Modificación exitosa", 'icono' => "success"];
    } else {
        $response = ['mensaje' => "No se realizaron modificaciones", 'icono' => "info"];
    }
} else {
    if ($nombreDuplicado) {
        $response = ['mensaje' => 'Nombre de usuario existente', 'icono' => 'info'];
    } elseif ($mailDuplicado) {
        $response = ['mensaje' => 'Mail existente', 'icono' => 'info'];
    }
}

echo json_encode($response);
exit();
