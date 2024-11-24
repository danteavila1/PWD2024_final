<div aria-hidden="true" class="modal fade" id="modificarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="form" method="post" action="accion/modificarProducto.php" enctype="multipart/form-data">

                    <label for="idproducto">ID producto</label>
                    <input type="text" class="form-control" id="idproductoModif" name="idproductoModif" readonly>

                    <label for="pronombre">Nombre producto</label>
                    <input type="text" class="form-control" id="nombreModif" name="nombreModif">

                    <label for="prodetalle">Detalle</label>
                    <input type="text" class="form-control" id="detalleModif" name="detalleModif">

                    <label for="procantstock">Cantidad de stock</label>
                    <input type="text" class="form-control" id="cantStockModif" name="cantStockModif">

                    <label for="proprecio">Precio</label>
                    <input type="text" class="form-control" id="precioModif" name="precioModif">

                    <div class="d-flex">
                        <label for="imagenModif" class="form-label">Imagen del Producto</label>
                        <img id="imagenModif" src="" alt="Imagen del producto" style="max-width: 100%; max-height: 200px;">

                    </div>

                    <label for="nuevaImagen" class="form-label">Nueva Imagen</label>
                    <input type="file" class="form-control" id="nuevaImagen" name="nuevaImagen" accept="image/jpeg/png">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">Modificar</button>
            </div>
        </div>
    </div>
</div>