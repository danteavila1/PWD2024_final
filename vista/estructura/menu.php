<?php
$sesion = new Session();

// Verificar si el usuario está autenticado
if ($sesion->activa() && $sesion->getUsuario()) {
    // Usuario autenticado: mostrar menú dinámico
    echo '<nav class="navbar navbar-expand-lg">';
    echo '<div class="container">';
    echo '<a class="navbar-brand" href="' . BASE_URL . 'vista">Kawaii Store</a>';
    echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<span class="navbar-toggler-icon"></span>';
    echo '</button>';
    echo '<div class="collapse navbar-collapse" id="menu">';
    echo '<ul class="navbar-nav ms-auto">';

    // Generar menú dinámico basado en roles
    $roles = $sesion->getRoles();
    if (!empty($roles)) {
        $arrMenu = [];
        $menues = new AbmMenuRol();
        foreach ($roles as $rol) {
            $param = ['idrol' => $rol->getIdRol()];
            $arr = $menues->buscar($param);
            $arrMenu = array_merge($arrMenu, $arr);
        }

        $menu = new Menu();
        foreach ($arrMenu as $menuItem) {
            $menu = $menuItem->getObjMenu();
            echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . $menu->getArchivoMenu() . '">' . $menu->getNombreMenu() . '</a></li>';
        }
    }

    echo '</ul>';
    echo '<a href="' . BASE_URL . 'vista/login/accion/cerrarSesion.php" class="btn btn-primary ms-3">Cerrar sesión</a>';
    echo '</div>';
    echo '</div>';
    echo '</nav>';
} else {
    // Usuario no autenticado: mostrar menú público
?>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>vista">Kawaii Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../vista/index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>vista/productos.php">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>vista/contacto.php">Contacto</a>
                    </li>
                </ul>
                <a href="<?php echo BASE_URL; ?>vista/login/formIniciarSesion.php" class="btn btn-primary ms-3">Iniciar sesión</a>
            </div>
        </div>
    </nav>
<?php
}
