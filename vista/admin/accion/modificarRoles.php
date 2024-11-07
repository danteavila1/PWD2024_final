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

// Recorro roles actuales para darles de baja a todos
if (count($colRolesActuales) >= 1) {
    foreach ($colRolesActuales as $rolesActuales) {
        $rolActual = $rolesActuales->getObjRol()->getIdRol();

        // Formo una tupla para darle de baja al rol
        $tupla = ['idusuario' => $idusuario, 'idrol' => $rolActual];
        $objUsuarioRol->baja($tupla);
        $_SESSION['mensaje'] = "Roles borrados con éxito";
        $_SESSION['icono'] = "success";
    }
}

// Acá están todos los roles que el admin eligió poner/sacar
$colRolesForm = $datos['idrol'];

// Recorro roles elegidos para darles de alta a todos
foreach ($colRolesForm as $rolElegido) {

    // Formo una tupla para darle de alta al rol
    $tupla = ['idusuario' => $idusuario, 'idrol' => $rolElegido];
    $objUsuarioRol->alta($tupla);
    $_SESSION['mensaje'] = "Roles modificados con éxito";
    $_SESSION['icono'] = "success";
}

// Redirijo al listado de usuarios
header("Location: ../listarUsuario.php");
exit();
