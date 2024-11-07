<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Extraigo la opción elegida
$opcion = $datos['opcion'];

if ($opcion == "si") {
    // Creo instancia del objeto AbmUsuario
    $objUsuario = new AbmUsuario();

    // Realizo la baja del usuario
    if ($objUsuario->baja($datos)) {
        $_SESSION['mensaje'] = "Borrado lógico con éxito";
        $_SESSION['icono'] = "success";
    } else {
        $_SESSION['mensaje'] = "Falló el borrado lógico";
        $_SESSION['icono'] = "error";
    }
}

// Redirijo al listado de usuarios
header("Location: ../listarUsuario.php");
exit();
