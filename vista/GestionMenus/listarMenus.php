<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
$session = new Session();

// Incluyo modales
include_once('altaMenu.php');
include_once('bajaMenu.php');
include('modificarMenu.php');

// Creo instancia del objeto AbmUsuario y accedo al método correspondiente
$objMenu = new AbmMenu();
$colMenus = $objMenu->buscar("");

// Verifico que hayan usuarios en la base de datos
$hayMenus = false;
if (count($colMenus) > 0) {
    $hayMenus = true;
}

?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Listado de menús cargados en la base de datos</h3>
            <div>
                <button class="altaMenu btn btn-success me-2" type="button" data-bs-toggle="modal" data-bs-target="#altaMenu">
                    Crear menú
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if ($hayMenus): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID menú</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Link</th>
                            <th scope="col">Deshabilitado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($colMenus); $i++):
                            $idmenu = $colMenus[$i]->getIdMenu();
                            $nombre = $colMenus[$i]->getMeNombre();
                            $descripcion = $colMenus[$i]->getMeDescripcion();
                            $link = $colMenus[$i]->getMeLink();
                            $deshabilitado = $colMenus[$i]->getMeDeshabilitado();

                            if ($deshabilitado == '0000-00-00 00:00:00') {
                                $deshabilitado = "Activo";
                            }
                        ?>
                            <tr>
                                <th scope="row"><?php echo $idmenu ?></th>
                                <td><?php echo $nombre ?></td>
                                <td><?php echo $descripcion ?></td>
                                <td><?php echo $link ?></td>
                                <td><?php echo $deshabilitado ?></td>
                                <td>
                                    <?php if ($deshabilitado == "Activo") : ?>
                                        <button class="modificarMenu btn btn-primary me-2" type="button"
                                            data-idmenu="<?php echo $idmenu; ?>"
                                            data-menombre="<?php echo $nombre; ?>"
                                            data-medescripcion="<?php echo $descripcion; ?>"
                                            data-melink="<?php echo $link; ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modificarMenu">
                                            Modificar
                                        </button>
                                        <button class="bajaMenu btn btn-danger" type="button"
                                            data-idmenu="<?php echo $idmenu; ?>"
                                            data-menombre="<?php echo $nombre; ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#bajaMenu">
                                            Deshabilitar
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No hay menús cargados en la base de datos.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../js/ajax/altaMenu.js"></script>
<script src="../js/ajax/bajaMenu.js"></script>
<script src="../js/ajax/modificarMenu.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
