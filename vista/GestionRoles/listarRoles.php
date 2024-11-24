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

<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Listado de roles cargados en la base de datos</h3>
            <div>
                <button class="altaRol btn btn-success me-2" type="button" data-bs-toggle="modal" data-bs-target="#altaRol">
                    Crear rol
                </button>
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
                    <tbody>
                        <?php for ($i = 0; $i < count($colRoles); $i++):
                            $idrol = $colRoles[$i]->getIdRol();
                            $rodescripcion = $colRoles[$i]->getRolDescripcion();
                        ?>
                            <tr>
                                <th scope="row"><?php echo $idrol ?></th>
                                <td><?php echo $rodescripcion ?></td>
                                <td>
                                    <button class="modificarRol btn btn-primary me-2" type="button"
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
                        <?php endfor; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No hay roles cargados en la base de datos.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../js/ajax/altaRol.js"></script>
<script src="../js/ajax/bajaRol.js"></script>
<script src="../js/ajax/modificarRol.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
