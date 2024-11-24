<div aria-hidden="true" class="modal fade" id="modificarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="form" method="post" onsubmit="encriptar()" action="accion/modificarUsuario.php">

                    <label for="idusuario">ID usuario</label>
                    <input type="text" class="form-control" id="idusuarioModif" name="idusuarioModif" readonly>

                    <label for="usnombre">Nombre usuario</label>
                    <input type="text" class="form-control" id="usnombreModif" name="usnombreModif">

                    <label for="usmail">Mail</label>
                    <input type="text" class="form-control" id="usmailModif" name="usmailModif">

                    <label for="uspass">Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="uspass" name="uspass" placeholder="Opcional">
                        <button type="button" class="btn btn-secondary"
                            onmousedown="mostrarPass(true)"
                            onmouseup="mostrarPass(false)"
                            onmouseleave="mostrarPass(false)">
                            <i id="toggleIcon" class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">Modificar</button>
            </div>
        </div>
    </div>
</div>