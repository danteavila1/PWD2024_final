<div aria-hidden="true" class="modal fade" id="altaProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAlta" name="formAlta" method="post" action="accion/altaProducto.php" enctype="multipart/form-data">

                    <div class="mb-1">
                        <label for="nombreAlta">Nombre producto</label>
                        <input type="text" class="form-control" id="nombreAlta" name="nombreAlta">
                        <div class="mensaje-error"></div>
                    </div>

                    <div class="mb-1">
                        <label for="detalleAlta">Detalle</label>
                        <input type="text" class="form-control" id="detalleAlta" name="detalleAlta">
                        <div class="mensaje-error"></div>
                    </div>

                    <div class="mb-1">
                        <label for="cantStockAlta">Cantidad de stock</label>
                        <input type="text" class="form-control" id="cantStockAlta" name="cantStockAlta">
                        <div class="mensaje-error"></div>
                    </div>

                    <div class="mb-1">
                        <label for="precioAlta">Precio</label>
                        <input type="text" class="form-control" id="precioAlta" name="precioAlta">
                        <div class="mensaje-error"></div>
                    </div>

                    <div class="mb-1">
                        <label for="nuevaImagen" class="form-label">Imagen del producto</label>
                        <input type="file" class="form-control" id="proimagen" name="proimagen">
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