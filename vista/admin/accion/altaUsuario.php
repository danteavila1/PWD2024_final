<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Extraigo nombre de usuario y mail recibido
$nombreForm = $datos['usnombre'];
$mailForm = $datos['usmail'];

// Creo instancia del objeto Usuario
$objUsuario = new AbmUsuario();
$colUsuarios = $objUsuario->buscar("");

// Verifico si existe el nombre de usuario y email existen en la base de datos
$existeNombre = false;
$existeMail = false;
foreach ($colUsuarios as $usuario) {
    $usuarioExistente = $usuario->getUsNombre();
    if ($usuarioExistente == $nombreForm) {
        $existeNombre = true;
        $response = ['mensaje' => 'Nombre de usuario en uso', 'icono' => 'info'];
    }
    $usuarioExistente = $usuario->getUsMail();
    if ($usuarioExistente == $mailForm) {
        $existeMail = true;
        $response = ['mensaje' => 'Mail en uso', 'icono' => 'info'];
    }
}

// Si no existe, procedo a dar de alta al usuario
if (!$existeNombre && !$existeMail) {
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
        }
        $response = ['mensaje' => 'Alta exitosa', 'icono' => 'success'];
    } else {
        $response = ['mensaje' => 'Alta fallida', 'icono' => 'error'];
    }
}

echo json_encode($response);
exit;
