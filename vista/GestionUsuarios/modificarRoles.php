<div aria-hidden="true" class="modal fade" id="modificarRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar roles</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="form" method="post" action="accion/modificarRoles.php">
                    <?php
                    // Obtengo todos los roles existentes en la base de datos
                    $objRol = new AbmRol();
                    $colRoles = $objRol->buscar("");
                    foreach ($colRoles as $rol) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="idrol[]" value="<?php echo $rol->getIdRol(); ?>">
                            <label class="form-check-label" for="flexCheckDefault">
                                <?php echo $rol->getRolDescripcion(); ?>
                            </label>
                        </div>
                    <?php endforeach ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">Confirmar</button>
            </div>
        </div>
    </div>
</div>