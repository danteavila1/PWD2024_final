<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
$session = new Session();

// Incluyo modales
include_once('altaRol.php');
include_once('bajaRol.php');
include_once('modificarRol.php');

// Creo instancia del objeto AbmUsuario y accedo al método correspondiente
$objRol = new AbmRol();
$colRoles = $objRol->buscar("");

// Verifico que hayan usuarios en la base de datos
$hayRoles = false;
if (count($colRoles) > 0) {
    $hayRoles = true;
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
                    <a class="nav-link" href="listarUsuario.php">Administrar usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Administrar roles</a>
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
            <h3>Listado de roles cargados en la base de datos</h3>
            <div class="d-flex">
                <button class="altaRol btn btn-success me-2" type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#altaRol">
                    Crear rol
                </button>
                <a href="../login/accion/cerrarSesion.php">
                    <input type="submit" class="btn btn-secondary me-2" value="Cerrar sesión">
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if ($hayRoles): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID rol</th>
                            <th scope="col">Rol descripción</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                    for ($i = 0; $i < count($colRoles); $i++):
                        $idrol = $colRoles[$i]->getIdRol();
                        $rodescripcion = $colRoles[$i]->getRolDescripcion();
                    ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $idrol ?></th>
                                <td><?php echo $rodescripcion ?></td>
                                <td>
                                    <button class="modificarRol btn btn-primary" type="button"
                                        data-idrol="<?php echo $idrol; ?>"
                                        data-rodescripcion="<?php echo $rodescripcion; ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modificarRol">
                                        Modificar
                                    </button>

                                    <button class="bajaRol btn btn-danger" type="button"
                                        data-idrol="<?php echo $idrol; ?>"
                                        data-rodescripcion="<?php echo $rodescripcion; ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#bajaRol">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    <?php endfor; ?>
                </table>
            <?php else: ?>
                <p><?php echo "No hay roles cargados en la base de datos."; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../js/ajax/altaRol.js"></script>
<script src="../js/ajax/bajaRol.js"></script>
<script src="../js/ajax/modificarRol.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
