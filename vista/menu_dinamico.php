<?php
include_once("../configuracion.php");
include_once(ROOT_PATH . "modelo/Usuario.php");

// Inicializamos sesion
$sesion = new Session();

// Verificamos si el usuario está logueado
if (!$sesion->activa()) {
    echo "<div class='alert alert-danger'>Error: Usuario no autenticado.</div>";
    exit;
}

// Obtenemos al usuario logueado
$usuario = $sesion->getUsuario();
if (!$usuario) {
    echo "<div class='alert alert-danger'>Error: No se encontró el usuario autenticado.</div>";
    exit;
}

// Obtenemos información del usuario
$roles = $sesion->getRoles();
if (empty($roles)) {
    echo "<div class='alert alert-danger'>Error: No se encontraron roles asignados para este usuario.</div>";
    exit;
}

$rolDescripcion = $roles[0]->getRolDescripcion(); // Consideramos el primer rol del usuario

// Generamos el contenido del menú dinámico
echo '<ul class="list-group">';
if ($rolDescripcion === 'admin') {
    echo '<li class="list-group-item"><a class="text-decoration-none" href="./admin/listarUsuario.php">Gestión de Usuarios</a></li>';
    echo '<li class="list-group-item"><a class="text-decoration-none" href="./admin/listarRoles.php">Gestión de Roles</a></li>';
    echo '<li class="list-group-item"><a class="text-decoration-none" href="./admin/listarProductos.php">Gestión de Productos</a></li>';
    echo '<li class="list-group-item"><a class="text-decoration-none" href="configuracionGeneral.php">Configuración General</a></li>';
} elseif ($rolDescripcion === 'deposito') {
    echo '<li class="list-group-item"><a class="text-decoration-none" href="./admin/listarProductos.php">Gestión de Productos</a></li>';
} else {
    echo '<li class="list-group-item"><a class="text-decoration-none" href="carrito.php">Mi Carrito</a></li>';
}
echo '</ul>';
