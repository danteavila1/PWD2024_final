<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
$session = new Session();

// Incluyo modales
include_once('modificarUsuario.php');
include_once('bajaUsuario.php');
include_once('altaUsuario.php');
include_once('modificarRoles.php');

// Creo instancia del objeto AbmUsuario y accedo al método correspondiente
$objUsuario = new AbmUsuario();
$colUsuarios = $objUsuario->buscar("");

// Verifico que hayan usuarios en la base de datos
$hayUsuarios = false;
if (count($colUsuarios) > 0) {
    $hayUsuarios = true;
}

?>

<h3> Iniciado como <?php echo $_SESSION['usnombre'] ?></h3>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Administrar usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listarRoles.php">Administrar roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listarProductos.php">Administrar productos</a>
                <li class="nav-item">
                    <a class="nav-link" href="#">Administrar menús</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="justify-content-md-center align-items-center mt-5">
    <div class="card shadow  mx-usuario">
        <div class="card-header">
            <h3>Listado de usuarios cargados en la base de datos</h3>
            <div class="d-flex">
                <button class="altaUsuario btn btn-success me-2" type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#altaUsuario">
                    Crear usuario
                </button>
                <a href="../login/accion/cerrarSesion.php">
                    <input type="submit" class="btn btn-secondary me-2" value="Cerrar sesión">
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if ($hayUsuarios): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID usuario</th>
                            <th scope="col">Nombre usuario</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Deshabilitado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                    for ($i = 0; $i < count($colUsuarios); $i++):
                        $idusuario = $colUsuarios[$i]->getIdUsuario();
                        $usnombre = $colUsuarios[$i]->getUsNombre();
                        $usmail = $colUsuarios[$i]->getUsMail();

                        // Creo instancia del objeto AbmUsuarioRol para mostrar los roles de los usuarios
                        $objUsuarioRol = new AbmUsuarioRol();

                        $usuario = ['idusuario' => $idusuario];
                        // $usuario = ['idusuario' => 1];
                        $colUsuarioRol = $objUsuarioRol->buscar($usuario);
                        $cantRoles = count($colUsuarioRol);

                        // Creamos array para guardar los roles del usuario
                        $colRoles = [];

                        // Recorremos todos los roles del usuario
                        if ($cantRoles >= 1) {
                            foreach ($colUsuarioRol as $rol) {
                                $roldescripcion = $rol->getObjRol()->getRolDescripcion();
                                $colRoles[] = $roldescripcion;
                            }

                            // Separamos con una "coma" en >> caso de que un usuario tenga más de un rol <<
                            $roles = implode(", ", $colRoles);
                        } else {
                            $roles = "-";
                        }

                        $usdeshabilitado = $colUsuarios[$i]->getUsDeshabilitado();
                        if ($usdeshabilitado == '0000-00-00 00:00:00') {
                            $usdeshabilitado = "Activo";
                        }
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $idusuario ?></td>
                                <td><?php echo $usnombre ?></td>
                                <td><?php echo $usmail ?></td>
                                <td><?php echo $roles ?></td>
                                <td><?php echo $usdeshabilitado ?></td>
                                <td>
                                    <?php if ($usdeshabilitado == "Activo") : ?>
                                        <div class="d-flex">
                                            <button class="modificarRoles btn btn-primary" type="button"
                                                data-idusuario="<?php echo $idusuario; ?>"
                                                data-usnombre="<?php echo $usnombre; ?>"
                                                data-roles="<?php echo $roles; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modificarRoles">
                                                Modificar roles
                                            </button>

                                            <button class="modificarUsuario btn btn-primary" type="button"
                                                data-idusuario="<?php echo $idusuario; ?>"
                                                data-usnombre="<?php echo $usnombre; ?>"
                                                data-usmail="<?php echo $usmail; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modificarUsuario">
                                                Modificar datos
                                            </button>

                                            <button class="bajaUsuario btn btn-danger" type="button"
                                                data-idusuario="<?php echo $idusuario; ?>"
                                                data-usnombre="<?php echo $usnombre; ?>"
                                                data-roles="<?php echo $roles; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#bajaUsuario">
                                                Deshabilitar
                                            </button>

                                        </div>
                                    <?php endif ?>
                                </td>
                            </tr>
                        </tbody>
                    <?php endfor; ?>
                </table>
            <?php else: ?>
                <p><?php echo "No hay usuarios cargados en la base de datos."; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../js/md5.js"></script>
<script src="../js/verPass.js"></script>
<script src="../js/ajax/bajaUsuario.js"></script>
<script src="../js/ajax/modificarRoles.js"></script>
<script src="../js/ajax/modificarUsuario.js"></script>
<script src="../js/ajax/altaUsuario.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
