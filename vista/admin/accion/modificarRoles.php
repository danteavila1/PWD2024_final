<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

$idusuario = $datos['idusuario'];

// Creo instancia del objeto AbmUsuario
$objUsuario = new AbmUsuario();

// Creo instancia del objeto AbmUsuarioRol
$objUsuarioRol = new AbmUsuarioRol();
$param = ['idusuario' => $idusuario];

// Acá están todos los roles del usuario antes de alterarlos
$colRolesActuales = $objUsuarioRol->buscar($param);
$colRolesForm = $datos['idrol'];

if (count($colRolesActuales) >= 1) {
    // Recorro roles actuales para darles de baja a todos
    foreach ($colRolesActuales as $rolesActuales) {
        $rolActual = $rolesActuales->getObjRol()->getIdRol();

        // Formo una tupla para darle de baja al rol
        $tupla = ['idusuario' => $idusuario, 'idrol' => $rolActual];
        $objUsuarioRol->baja($tupla);
    }

    // Acá están todos los roles que el admin eligió poner/sacar
    $colRolesForm = $datos['idrol'];

    // Recorro roles elegidos para darles de alta a todos
    foreach ($colRolesForm as $rolForm) {
        // Formo una tupla para darle de alta al rol
        $tupla = ['idusuario' => $idusuario, 'idrol' => $rolForm];
        $objUsuarioRol->alta($tupla);
    }
    $response = ['mensaje' => "Modificación de roles exitosa", 'icono' => "success"];
} else {
    $response = ['mensaje' => "Modificación de roles fallida", 'icono' => "error"];
}

echo json_encode($response);
exit();
