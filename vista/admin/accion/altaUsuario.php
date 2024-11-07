<?php
include_once('../../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto Usuario
$objUsuario = new AbmUsuario();

// Doy de alta al usuario
if ($objUsuario->alta($datos)) {

    // Busco ID del usuario recién creado
    $usnombre['usnombre'] = $datos['usnombre'];
    $colUsuarios = $objUsuario->buscar($usnombre);
    $idusuario = $colUsuarios[0]->getIdUsuario();

    //Creo instancia del objeto AbmUsuarioRol
    $objUsuarioRol = new AbmUsuarioRol();

    // Creo instancia del objeto AbmRol
    $objRol = new AbmRol();
    // Pongo colección de id's de roles recibidos
    $roles = $datos['idrol'];

    // Realizo alta con cada uno de los roles
    foreach ($roles as $rol) {
        // Formo una tupla para darle de alta
        $tupla = ['idusuario' => $idusuario, 'idrol' => $rol];
        $objUsuarioRol->alta($tupla);

        $_SESSION['mensaje'] = "Se realizó el alta con éxito";
        $_SESSION['icono'] = "success";
    }
} else {
    $_SESSION['mensaje'] = "No se pudo realizar el alta";
    $_SESSION['icono'] = "error";
}

// Redirijo al listado de usuarios
header("Location: ../listarUsuario.php");
exit();
