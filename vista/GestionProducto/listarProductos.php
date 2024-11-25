<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
$session = new Session();

// Incluyo modales
include_once('altaProducto.php');
include_once('bajaProducto.php');
include_once('modificarProducto.php');

// Creo instancia del objeto AbmProducto y listo todos los productos
$objProducto = new AbmProducto();
$colProductos = $objProducto->buscar("");

// Verifico que hayan usuarios en la base de datos
$hayProductos = false;
if (count($colProductos) > 0) {
    $hayProductos = true;
}
?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Listado de productos cargados en la base de datos</h3>
            <div>
                <button class="altaProducto btn btn-success me-2" type="button" data-bs-toggle="modal" data-bs-target="#altaProducto">
                    Crear producto
                </button>
                <button class="btn btn-primary">
                    <a href="realizaReporte.php" class="text-white text-decoration-none">Reporte PDF</a>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if ($hayProductos): ?>
                <table class="table">
                    <thead class="table">
                        <tr>
                            <th scope="col">ID producto</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Detalle</th>
                            <th scope="col">Cantidad stock</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($colProductos); $i++):
                            $idproducto = $colProductos[$i]->getIdProducto();
                            $nombre = $colProductos[$i]->getProNombre();
                            $detalle = $colProductos[$i]->getProDetalle();
                            $cantStock = $colProductos[$i]->getProCantStock();
                            $precio = $colProductos[$i]->getProPrecio();
                            $imagen = $colProductos[$i]->getProImagen();
                        ?>
                            <tr>
                                <th scope="row"><?php echo $idproducto ?></th>
                                <td>
                                    <img src="../images/<?php echo $imagen ?>" alt="Producto" class="img-thumbnail" style="max-width: 50px;">
                                </td>
                                <td><?php echo $nombre ?></td>
                                <td><?php echo $detalle ?></td>
                                <td><?php echo $cantStock ?></td>
                                <td><?php echo $precio ?></td>
                                <td>
                                    <button class="modificarProducto btn btn-primary me-2" type="button"
                                        data-idproducto="<?php echo $idproducto; ?>"
                                        data-nombre="<?php echo $nombre; ?>"
                                        data-detalle="<?php echo $detalle; ?>"
                                        data-cantstock="<?php echo $cantStock; ?>"
                                        data-precio="<?php echo $precio; ?>"
                                        data-imagen="<?php echo $imagen; ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modificarProducto">
                                        Modificar
                                    </button>
                                    <button class="bajaProducto btn btn-danger" type="button"
                                        data-idproducto="<?php echo $idproducto; ?>"
                                        data-nombre="<?php echo $nombre; ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#bajaProducto">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No hay productos cargados en la base de datos.</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<script src="../js/ajax/altaProducto.js"></script>
<script src="../js/ajax/bajaProducto.js"></script>
<script src="../js/ajax/modificarProducto.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
