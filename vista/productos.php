<?php
include_once("../configuracion.php");
include_once(ROOT_PATH."/vista/estructura/header.php");

$sesion = new Session();
$productos = new AbmProducto();

$dir = 'images/';
$listaProductos = $productos->buscar(null);


?>


<div class="container mt-4">
    <h1 class="mb-4" style="margin-top:5%;">Nuestros Productos</h1>
    <div class="row">
    
        <?php
        if (count($listaProductos) > 0): ?>
            <?php foreach ($listaProductos as $producto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card" data-id="<?php echo $producto->getIdproducto(); ?>" data-nombre="<?php echo htmlspecialchars($producto->getProNombre()); ?>" data-detalle="<?php echo htmlspecialchars($producto->getProDetalle()); ?>" data-precio="<?php echo htmlspecialchars($producto->getProPrecio()); ?>" data-stock="<?php echo htmlspecialchars($producto->getProCantStock()); ?>" data-imagen="<?php echo $dir . $producto->getProimagen(); ?>">
                        <img src="<?php echo $dir . $producto->getProimagen(); ?>" class="card-img-top object-fit-cover" height="200" alt="Imagen de producto">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto->getProNombre()); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($producto->getProDetalle()); ?></p>
                            <div class="row">
                                <p class="card-text col">Precio: $<?php echo htmlspecialchars($producto->getProPrecio()); ?></p>
                                <p class="card-text col">Disponible: <?php echo htmlspecialchars($producto->getProCantStock()); ?></p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary ver-detalle">Ver Detalle</button>
                            <?php
                            $user = $sesion->getUsuario();
                            $idUsuario = $user->getIdUsuario();
                             if ($listaProductos): ?>
                                <button class="btn btn-success agregar-carrito" onclick="agregarCarrito(<?php echo $producto->getIdproducto(); ?>, <?php echo $idUsuario; ?>)">Agregar al carrito</button>
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
            <div class="modal-footer">
                <?php if ($sesion->getRoles() !== null && $sesion->getRoles()[0]->getRolDescripcion() === "Cliente"): ?>
                    <button class="btn btn-success" id="agregarCarritoModal">Agregar al carrito</button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php include_once(ROOT_PATH."/vista/estructura/footer.php"); ?>