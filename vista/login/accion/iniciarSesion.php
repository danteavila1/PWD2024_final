<?php
include_once('../../../configuracion.php');

$datos = data_submitted();

$objSession = new Session();
$response = $objSession->loguear($datos);
