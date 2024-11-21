<?php
include_once("../configuracion.php");
include_once(ROOT_PATH . "/vista/estructura/header.php");
include_once(ROOT_PATH . "/vista/accion/accionProductos.php");
?>

<div class="container mt-4">
    <h1 class="mb-4" style="margin-top:5%;">Nuestros Productos</h1>
    <div class="btn btn-outline-success mb-3" onclick="nuevoProducto()">Nuevo Producto</div>
    <div class="row">

        <?php
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- imagen del producto-->
                        <img src="<?php echo BASE_URL . 'vista/images/' . $producto->getProImagen(); ?>" class="card-img-top" alt="<?php echo $producto->getProNombre(); ?>">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Optio dolore provident in? Deleniti magnam harum culpa animi, recusandae totam veritatis commodi quisquam maiores eligendi sapiente neque dolorem sed odit quibusdam.</p>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $producto->getProNombre(); ?></h5>
                            <p class="card-text"><?php echo $producto->getProDetalle(); ?></p>
                            <div class="row">
                                <p class="card-text col">Precio: $<?php echo number_format($producto->getProPrecio(), 2); ?></p>
                                <p class="card-text col">Stock: <?php echo $producto->getProCantStock(); ?></p>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-warning editarProducto" data-id="<?php echo $producto->getIdProducto(); ?>">Editar</button>
                            <button class="btn btn-danger eliminarProducto" data-id="<?php echo $producto->getIdProducto(); ?>">Eliminar</button>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="container p-2">
                <div class="alert alert-info" role="alert">
                    No hay productos cargados!
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php
include_once("./estructura/footer.php");
?>
<script src="<?php echo BASE_URL ?>Vista/js/productoCliente.js"></script>
