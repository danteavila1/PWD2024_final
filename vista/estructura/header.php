<!DOCTYPE html>
<html lang="es">
<?php


$sesion = new Session();

// Definir páginas públicas que no requieren control de acceso
$publicas = ['index.php', 'login.php', 'productos.php']; 

// Verificar si la página actual requiere autenticación
if (!in_array(basename($_SERVER['PHP_SELF']), $publicas)) {
    // Si no tiene permisos para acceder, redirige al usuario
    if (!$sesion->verificarPagSegura()) {
        header('Location: ' . BASE_URL . './vista/login/formIniciarSesion.php'); // lo mandamos al login
        exit();
    }
}
?>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Muñecos Kawaii</title>
    <?php include_once ("links.php");?>
</head>
<body>

  <header class="header-kawaii">
  <?php include_once ("menu.php");?>
  </header>
