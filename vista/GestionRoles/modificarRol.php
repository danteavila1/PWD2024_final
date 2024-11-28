<div aria-hidden="true" class="modal fade" id="modificarRol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar rol</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" name="form" method="post" action="accion/modificarRol.php">

                    <div class="mb-1">
                        <label for="idusuario">ID rol</label>
                        <input type="text" class="form-control" id="idrolModif" name="idrolModif" readonly>
                        <div class="mensaje-error"></div>
                    </div>

                    <div class="mb-1">
                        <label for="usnombre">Rol descripción</label>
                        <input type="text" class="form-control" id="rodescripcionModif" name="rodescripcionModif">
                        <div class="mensaje-error"></div>
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