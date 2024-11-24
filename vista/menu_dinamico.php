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
  //echo "<div class='alert alert-danger'>Error: No se encontró el usuario autenticado.</div>";
  echo '<ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="nav-link" href="' . BASE_URL . 'vista/productos.php">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="' . BASE_URL . 'vista/productos.php">Tienda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Novedades</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contacto</a>
      </li>
    </ul>
    <a href="' . BASE_URL . 'vista/login/formIniciarSesion.php" class="btn btn-primary ms-3">Iniciar sesión</a>
    <a href="../cliente/carrito.php" class="ms-3">
      <img src="' . BASE_URL . 'vista/images/carrito.png" alt="Carrito" class="imgCart me-2" style="height: 2em;">
      <span>' . (isset($_SESSION['numero']) ? $_SESSION['numero'] : 0) . '</span>
    </a>';
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
echo '<ul class="navbar-nav ms-auto">';
$arrMenu = [];
$arr = [];
$menues = new AbmMenuRol();
foreach($roles as $rol){
    //De los roles, me traigo los ID de los menu que puede ver
    $param = ['idrol'=>$rol->getIdRol()];
    $arr = $menues->buscar($param);
    array_push($arrMenu,$arr);
}

$men = new Menu();
foreach($arr as $menu){
    //A partir de los id, me traigo los objeto menu y armo el item de la lista.
    $men = $menu->getObjMenu();
    echo '<li class="nav-item"><a class="nav-link" href="'.BASE_URL.$men->getArchivoMenu().'">'.$men->getNombreMenu().'</a></li>';
}
// echo '<a href="../cliente/carrito.php" class="ms-3">
// <img src="' . BASE_URL . 'vista/images/carrito.png" alt="Carrito" class="imgCart me-2" style="height: 2em;">
// <span>' . (isset($_SESSION['numero']) ? $_SESSION['numero'] : 0) . '</span>
// </a>';
echo '<a href="'.BASE_URL.'vista/login/accion/cerrarSesion.php" class="btn btn-primary ms-3">Cerrar sesión</a>';
echo '</ul>';

/**if ($rolDescripcion === 'admin') {
    echo '<li class="list-group-item"><a class="text-decoration-none" href="./admin/listarUsuario.php">Gestión de Usuarios</a></li>';
    echo '<li class="list-group-item"><a class="text-decoration-none" href="./admin/listarRoles.php">Gestión de Roles</a></li>';
    echo '<li class="list-group-item"><a class="text-decoration-none" href="./admin/listarProductos.php">Gestión de Productos</a></li>';
    echo '<li class="list-group-item"><a class="text-decoration-none" href="configuracionGeneral.php">Configuración General</a></li>';
} elseif ($rolDescripcion === 'deposito') {
    echo '<li class="list-group-item"><a class="text-decoration-none" href="./admin/listarProductos.php">Gestión de Productos</a></li>';
} else {
    echo '<li class="list-group-item"><a class="text-decoration-none" href="carrito.php">Mi Carrito</a></li>';
}*/

