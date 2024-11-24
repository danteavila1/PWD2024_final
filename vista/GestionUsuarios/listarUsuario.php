<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
$session = new Session();

// Incluyo modales
include_once('./modificarUsuario.php');
include_once('./bajaUsuario.php');
include_once('./altaUsuario.php');
include_once('../GestionRoles/modificarRoles.php');

// Creo instancia del objeto AbmUsuario y accedo al método correspondiente
$objUsuario = new AbmUsuario();
$colUsuarios = $objUsuario->buscar("");

// Verifico que hayan usuarios en la base de datos
$hayUsuarios = false;
if (count($colUsuarios) > 0) {
    $hayUsuarios = true;
}

?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Listado de usuarios cargados en la base de datos</h3>
            <div>
                <button class="altaUsuario btn btn-success me-2" type="button" data-bs-toggle="modal" data-bs-target="#altaUsuario">
                    Crear usuario
                </button>
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
                    <tbody>
                        <?php for ($i = 0; $i < count($colUsuarios); $i++):
                            $idusuario = $colUsuarios[$i]->getIdUsuario();
                            $usnombre = $colUsuarios[$i]->getUsNombre();
                            $usmail = $colUsuarios[$i]->getUsMail();

                            $objUsuarioRol = new AbmUsuarioRol();
                            $usuario = ['idusuario' => $idusuario];
                            $colUsuarioRol = $objUsuarioRol->buscar($usuario);
                            $cantRoles = count($colUsuarioRol);

                            $colRoles = [];
                            if ($cantRoles >= 1) {
                                foreach ($colUsuarioRol as $rol) {
                                    $roldescripcion = $rol->getObjRol()->getRolDescripcion();
                                    $colRoles[] = $roldescripcion;
                                }
                                $roles = implode(", ", $colRoles);
                            } else {
                                $roles = "-";
                            }

                            $usdeshabilitado = $colUsuarios[$i]->getUsDeshabilitado();
                            $usdeshabilitado = ($usdeshabilitado == '0000-00-00 00:00:00') ? "Activo" : $usdeshabilitado;
                        ?>
                            <tr>
                                <th scope="col"><?php echo $idusuario ?></th>
                                <td><?php echo $usnombre ?></td>
                                <td><?php echo $usmail ?></td>
                                <td><?php echo $roles ?></td>
                                <td><?php echo $usdeshabilitado ?></td>
                                <td>
                                    <?php if ($usdeshabilitado == "Activo") : ?>
                                        <div class="d-flex">
                                            <button class="modificarRoles btn btn-primary me-2" type="button"
                                                data-idusuario="<?php echo $idusuario; ?>"
                                                data-usnombre="<?php echo $usnombre; ?>"
                                                data-roles="<?php echo $roles; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modificarRoles">
                                                Modificar roles
                                            </button>
                                            <button class="modificarUsuario btn btn-primary me-2" type="button"
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
                        <?php endfor; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No hay usuarios cargados en la base de datos.</p>
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
