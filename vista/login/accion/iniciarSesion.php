<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Guardo los datos recibidos por separado
$usmail = $datos['usmail'];
$passEncriptada = $datos['uspass'];

//Creo objeto de usuario
$objUsuario = new AbmUsuario();

// Verifico su existencia
$colUsuarios = $objUsuario->buscar($datos);

// Si existe y los datos están bien, inicia sesión, sino, redirecciona al inicio de sesión nuevamente
if (!empty($colUsuarios)) {

    $idusuario = $colUsuarios[0]->getIdUsuario();
    $usdeshabilitado = $colUsuarios[0]->getUsDeshabilitado();

    if ($usdeshabilitado == NULL) {
        if ($session->iniciar($usmail, $passEncriptada)) {
            // REDIRECCIONAMIENTO TEMPORAL <<<<<<<<<<
            header("Location: ../../admin/listarUsuario.php");
        }
        exit;
    } else {
        setcookie("mensaje", "La cuenta se encuentra deshabilitada", time() + 60, "/");
        setcookie("icono", "question", time() + 60, "/");
    }
} else {
    header("Location: ../formIniciarSesion.php");
}
