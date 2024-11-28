<div>
    <div aria-hidden="true" class="modal fade" id="modificarMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formModificar" name="formModificar" method="post" action="accion/modificarMenu.php" enctype="multipart/form-data">

                        <div class="mb-1">
                            <div class="mb-1">
                                <label for="idmenuModif">ID menú</label>
                                <input type="text" class="form-control" id="idmenuModif" name="idmenuModif" readonly>
                            </div>

                            <div class="mb-1">
                                <label for="nombreModif">Nombre</label>
                                <input type="text" class="form-control" id="nombreModif" name="nombreModif">
                                <div class="mensaje-error"></div>
                            </div>

                            <div class="mb-1">
                                <label for="descripcionModif">Descripción</label>
                                <input type="text" class="form-control" id="descripcionModif" name="descripcionModif">
                                <div class="mensaje-error"></div>
                            </div>

                            <div class="mb-1">
                                <label for="linkModif">Link</label>
                                <input type="text" class="form-control" id="linkModif" name="linkModif">
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
</div>