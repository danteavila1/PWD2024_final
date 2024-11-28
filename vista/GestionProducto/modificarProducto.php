<div>
    <div aria-hidden="true" class="modal fade" id="modificarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formModificar" name="formModificar" method="post" action="accion/modificarProducto.php" enctype="multipart/form-data">

                        <div class="mb-1">
                            <div class="mb-1 text-center">
                                <img id="imagenModif" class="img-thumbnail" src="" alt="Imagen del producto" class="img-fluid mt-2" style="max-height: 150px;">
                            </div>

                            <div class="mb-1">
                                <label for="idproductoModif">ID producto</label>
                                <input type="text" class="form-control" id="idproductoModif" name="idproductoModif" readonly>
                            </div>

                            <div class="mb-1">
                                <label for="nombreModif">Nombre producto</label>
                                <input type="text" class="form-control" id="nombreModif" name="nombreModif">
                                <div class="mensaje-error"></div>
                            </div>

                            <div class="mb-1">
                                <label for="detalleModif">Detalle</label>
                                <input type="text" class="form-control" id="detalleModif" name="detalleModif">
                                <div class="mensaje-error"></div>
                            </div>

                            <div class="mb-1">
                                <label for="cantStockModif">Cantidad de stock</label>
                                <input type="text" class="form-control" id="cantStockModif" name="cantStockModif">
                                <div class="mensaje-error"></div>
                            </div>

                            <div class="mb-1">
                                <label for="precioModif">Precio</label>
                                <input type="text" class="form-control" id="precioModif" name="precioModif">
                                <div class="mensaje-error"></div>
                            </div>

                            <div class="mb-1">
                                <input type="hidden" id="imagenActual" name="imagenActual">
                            </div>

                            <div class="mb-1">
                                <label for="nuevaImagen" class="form-label">Nueva imagen (Opcional)</label>
                                <input type="file" class="form-control" id="nuevaImagen" name="nuevaImagen">
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