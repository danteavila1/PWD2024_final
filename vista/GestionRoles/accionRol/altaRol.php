<?php
include_once('../../../configuracion.php');

// Inicia la sesión
$session = new Session();

// Recibe los datos enviados en el formulario
$datos = data_submitted();
$rolForm = $datos['rodescripcion'];

// Instancia el objeto que maneja la lógica de rol
$objRol = new AbmRol();
$colRoles = $objRol->buscar("");

$existe = false;
foreach ($colRoles as $rol) {
    $rolExistente = $rol->getRolDescripcion();
    if ($rolExistente == $rolForm) {
        $existe = true;
        $response = ['mensaje' => "Rol existente", 'icono' => "info"];
    }
}

if (!$existe) {
    // Realizo el alta de rol
    if ($objRol->alta($datos)) {
        $response = ['mensaje' => "Alta exitosa", 'icono' => "success"];
    } else {
        $response = ['mensaje' => "Alta fallida", 'icono' => "error"];
    }
}

echo json_encode($response);
