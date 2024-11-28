<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto Usuario
$objUsuario = new AbmUsuario();
$pudo = $objUsuario->crearCuenta($datos);
$objUsuario->redirigir($pudo);
