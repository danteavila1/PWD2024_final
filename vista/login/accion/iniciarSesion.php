<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Guardo los datos recibidos por separado
$usnombre = $datos['usnombre'];
$passEncriptada = $datos['uspass'];

// Creo objeto de usuario
$objUsuario = new AbmUsuario();

// Busco al usuario
$colUsuarios = $objUsuario->buscar($datos);

// Si existe, procedo a iniciar sesión
if (!empty($colUsuarios)) {

    $idusuario = $colUsuarios[0]->getIdUsuario();
    $usdeshabilitado = $colUsuarios[0]->getUsDeshabilitado();

    if ($usdeshabilitado == '0000-00-00 00:00:00') {

        // Inicio sesión -> session_start()
        $session = new Session();
        if ($session->iniciar($usnombre, $passEncriptada)) {
            // REDIRECCIONAMIENTO TEMPORAL <<<<<<<<<<
            header("Location: ../../admin/listarUsuario.php");
        }
    } else {
        setcookie("mensaje", "La cuenta se encuentra deshabilitada", time() + 60, "/");
        setcookie("icono", "question", time() + 60, "/");
        header("Location: ../formIniciarSesion.php");
    }
} else {
    header("Location: ../formIniciarSesion.php");
}
