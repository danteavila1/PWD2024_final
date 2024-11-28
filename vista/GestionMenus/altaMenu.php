<div aria-hidden="true" class="modal fade" id="altaMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo menú</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAlta" name="formAlta" method="post" action="accion/altaMenu.php">
                    <div class="mb-1">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="menombre" name="menombre">
                        <div class="mensaje-error"></div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="medescripcion" name="medescripcion">
                        <div class="mensaje-error"></div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Link</label>
                        <input type="text" class="form-control" id="melink" name="melink">
                        <div class="mensaje-error"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">Crear</button>

            </div>
        </div>
    </div>
</div>