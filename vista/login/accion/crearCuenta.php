<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Extraigo mail recibido
$nombreForm = $datos['usmail'];

// Creo instancia del objeto Usuario
$objUsuario = new AbmUsuario();
$colUsuarios = $objUsuario->buscar("");

// Verifico si ese mail existe en la base de datos
$existe = false;
foreach ($colUsuarios as $usuario) {
    $usuarioExistente = $usuario->getUsNombre();
    if ($usuarioExistente == $nombreForm) {
        $existe = true;
    }
}

// Si no existe, procedo a dar de alta al usuario
if (!$existe) {
    if ($objUsuario->alta($datos)) {

        // Busco ID del usuario recién creado
        $usnombre['usnombre'] = $datos['usnombre'];
        $colUsuarios = $objUsuario->buscar($usnombre);
        $idusuario = $colUsuarios[0]->getIdUsuario();

        // Creo instancia del objeto AbmUsuarioRol
        $objUsuarioRol = new AbmUsuarioRol();

        // Creo al usuario con rol por defecto 'usuario'
        $tupla = ['idusuario' => $idusuario, 'idrol' => 2];
        $objUsuarioRol->alta($tupla);

        setcookie("mensaje", "Cuenta creada con éxito", time() + 60, "/");
        setcookie("icono", "success", time() + 60, "/");
        header("Location: ../formIniciarSesion.php");
    } else {
        setcookie("mensaje", "No se pudo crear la cuenta", time() + 60, "/");
        setcookie("icono", "error", time() + 60, "/");
        header("Location: ../formIniciarSesion.php");
    }
} else {
    // Corregir esto // Corregir esto // Corregir esto // Corregir esto
    setcookie("mensaje", "Nombre de usuario en uso", time() + 60, "/");
    setcookie("icono", "error", time() + 60, "/");
    header("Location: ../formCrearCuenta.php");
}
