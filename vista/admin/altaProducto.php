<div aria-hidden="true" class="modal fade" id="altaProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="form" method="post" action="accion/altaProducto.php" enctype="multipart/form-data">

                    <label for="pronombre">Nombre producto</label>
                    <input type="text" class="form-control" id="pronombre" name="pronombre">

                    <label for="prodetalle">Detalle</label>
                    <input type="text" class="form-control" id="prodetalle" name="prodetalle">

                    <label for="procantstock">Cantidad de stock</label>
                    <input type="text" class="form-control" id="procantstock" name="procantstock">

                    <label for="proprecio">Precio</label>
                    <input type="text" class="form-control" id="proprecio" name="proprecio">

                    <label for="nuevaImagen" class="form-label">Imagen del producto</label>
                    <input type="file" class="form-control" id="proimagen" name="proimagen" accept="image/jpeg/png/jpeg">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">Crear</button>
            </div>
        </div>
    </div>
</div>