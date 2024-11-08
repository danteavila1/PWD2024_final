<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto Usuario
$objRol = new AbmRol();

// Doy de alta al usuario
if ($objRol->alta($datos)) {
    $_SESSION['mensaje'] = "Rol creado con éxito";
    $_SESSION['icono'] = "success";
} else {
    $_SESSION['mensaje'] = "No se pudo crear el rol";
    $_SESSION['icono'] = "error";
}

// Redirijo al listado de usuarios
header("Location: ../listarUsuario.php");
exit();
