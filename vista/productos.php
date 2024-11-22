<?php
include_once("../configuracion.php");
include_once(ROOT_PATH . "/vista/estructura/header.php");

$sesion = new Session();
$productos = new AbmProducto();
$dir = 'images/';
$listaProductos = $productos->buscar(null);
?>

<div class="container p-3 mb-5">
    <h1 class="mb-4 text-center">Nuestros productos</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (count($listaProductos) > 0): ?>
            <?php foreach ($listaProductos as $producto): ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <!-- Imagen más grande y responsiva -->
                        <img src="<?php echo $dir . $producto->getProimagen(); ?>" class="card-img-top img-fluid" alt="Imagen de producto" style="height: 300px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto->getProNombre()); ?></h5>
                            <p class="card-text text-muted"><?php echo htmlspecialchars($producto->getProDetalle()); ?></p>
                            <div class="row g-0">
                                <div class="col-6">
                                    <p class="card-text"><strong>Precio:</strong> $<?php echo htmlspecialchars($producto->getProPrecio()); ?></p>
                                </div>
                                <div class="col-6">
                                    <p class="card-text text-end"><strong>Disponible:</strong> <?php echo htmlspecialchars($producto->getProCantStock()); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center">
                            <button class="btn btn-primary w-100 mb-2 ver-detalle">Ver detalle</button>
                            <?php if ($listaProductos): ?>
                                <button class="btn btn-success w-100">Agregar al carrito</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                No hay productos cargados.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para detalle de producto -->
<div class="modal fade" id="modalDetalle" tabindex="-1" aria-labelledby="detalleModalToggle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImagen" class="img-fluid mb-3" src="" alt="Detalle del producto">
                <h3 id="modalNombre"></h3>
                <p id="modalDescripcion"></p>
                <p id="modalPrecio"></p>
                <p id="modalStock"></p>
            </div>

            <!-- !!!!!!!!!!!!!!!!!!!!! -->
            <!-- !!!!!!!!!!!!!!!!!!!!! -->
            <!-- Esta parte anda mal, en el código de fuente de la página se ve el error. No se ve el footer -->
            <div class="modal-footer">
                <?php if ($sesion->getRoles() !== null && $sesion->getRoles()[0]->getRolDescripcion() === "Cliente"): ?>
                    <button class="btn btn-success" id="agregarCarritoModal">Agregar al carrito</button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php include_once(ROOT_PATH . "/vista/estructura/footer.php"); ?>

<script src="<?php echo BASE_URL ?>vista/js/productos.js"></script>