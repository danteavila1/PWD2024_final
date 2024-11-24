<div aria-hidden="true" class="modal fade" id="altaUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="form" method="post" action="accion/altaUsuario.php">
                    <label for="usnombre">Nombre usuario</label>
                    <input type="text" class="form-control" id="usnombreAlta" name="usnombreAlta">

                    <label for="usmail">Email</label>
                    <input type="text" class="form-control" id="usmailAlta" name="usmail">

                    <label for="uspass">Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="uspassAlta" name="uspass">
                        <button type="button" class="btn btn-secondary"
                            onmousedown="mostrarPass(true)"
                            onmouseup="mostrarPass(false)"
                            onmouseleave="mostrarPass(false)">
                            <i id="toggleIcon" class="bi bi-eye-slash"></i>
                        </button>
                    </div>

                    <h5>Rol/es</h5>
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
                <button type="button" class="btn btn-success">Crear</button>
            </div>
        </div>
    </div>
</div>