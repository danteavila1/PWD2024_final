<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Guardo los datos recibidos por separado
$usnombre = $datos['usnombre'];
$passEncriptada = $datos['uspass'];

// Creo objeto de usuario
$objUsuario = new AbmUsuario();

// Busco al usuario
$colUsuarios = $objUsuario->buscar($datos);

// Si existe, procedo a iniciar sesión
if (!empty($colUsuarios)) {

    $idusuario = $colUsuarios[0]->getIdUsuario();
    $usdeshabilitado = $colUsuarios[0]->getUsDeshabilitado();

    if ($usdeshabilitado == '0000-00-00 00:00:00') {

        // Inicio sesión -> session_start()
        $session = new Session();
        if ($session->iniciar($usnombre, $passEncriptada)) {
            // Obtener roles del usuario
            $roles = $session->getRoles();

            if (!empty($roles)) {
                $rolPrincipal = $roles[0]->getRolDescripcion(); // Supone que el primer rol es el principal

                // Redirigir según el rol del usuario
                if ($rolPrincipal === "admin") {
                    header("Location: ../../GestionUsuarios/listarUsuario.php");
                } elseif ($rolPrincipal === "deposito") {
                    header("Location: ../../GestionCompras/listarCompras.php");
                } elseif ($rolPrincipal === "usuario") {
                    header("Location: ../../productos.php");
                } else {
                    // Si el rol no está definido, redirigir a una página genérica
                    header("Location: ../../index.php");
                }
                exit();
            } else {
                // Si no tiene roles asignados
                setcookie("mensaje", "No tiene roles asignados", time() + 60, "/");
                setcookie("icono", "error", time() + 60, "/");
                header("Location: ../formIniciarSesion.php");
                exit();
            }
        }
    } else {
        setcookie("mensaje", "La cuenta se encuentra deshabilitada", time() + 60, "/");
        setcookie("icono", "question", time() + 60, "/");
        header("Location: ../formIniciarSesion.php");
    }
} else {
    setcookie("mensaje", "Usuario o contraseña incorrectos", time() + 60, "/");
    setcookie("icono", "error", time() + 60, "/");
    header("Location: ../formIniciarSesion.php");
    exit();
}

