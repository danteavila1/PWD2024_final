<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

$idusuario = $datos['idusuario'];

// Creo instancia del objeto AbmUsuario
$objUsuario = new AbmUsuario();

// Realizo la modificación del usuario
if ($objUsuario->modificacion($datos)) {
    $_SESSION['mensaje'] = "Modificación con éxito";
    $_SESSION['icono'] = "success";
} else {
    $_SESSION['mensaje'] = "Falló la modificación";
    $_SESSION['icono'] = "error";
}


// Redirijo al listado de usuarios
header("Location: ../listarUsuario.php");
exit();
