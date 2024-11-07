<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

$pudo = $session->cerrar();
if ($pudo) {
    header("Location: ../formIniciarSesion.php");
} else {
    // Arreglar esto xdd
    header("Location: ../formIniciarSesion.php");
}
