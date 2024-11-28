<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
$session = new Session();

// Creo instancia del objeto AbmCompra y accedo al método correspondiente
$objCompra = new AbmCompra();
$idusuario = ['idusuario' => $_SESSION['idusuario']];
$colCompras = $objCompra->buscar($idusuario);

// Incluyo modal
include_once('cambiarEstadoCompra.php');

// Verifico que hayan usuarios en la base de datos
$hayCompras = false;
if (count($colCompras) > 0) {
    $hayCompras = true;
}

?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Mis compras</h3>
        </div>
        <div class="card-body">
            <?php if ($hayCompras): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID compra</th>
                            <th scope="col">Fecha compra</th>
                            <th scope="col">Ítems</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha inicio</th>
                            <th scope="col">Fecha fin</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Colección de estados de compra
                        $objCompraEstado = new AbmCompraEstado();

                        // Itero sobre todas las compras
                        foreach ($colCompras as $compra):

                            // Ids de compra
                            $idcompra = $compra->getIdCompra();
                            $compra = ['idcompra' => $idcompra];

                            // Fecha que se inició la compra por parte del cliente
                            $compraFecha = $objCompra->buscar($compra);
                            $cofecha = $compraFecha[0]->getCoFecha();

                            // Colección de ítems de cada compra
                            $objCompraItem = new AbmCompraItem();
                            $colItemsCompra = $objCompraItem->buscar($compra);

                            $objProducto = new AbmProducto();
                            $items = [];
                            $monto = 0;

                            // Itero los ítems de cada compra
                            foreach ($colItemsCompra as $itemCompra) {
                                $idproducto = $itemCompra->getIdProducto();
                                $cantProducto = $itemCompra->getCiCantidad();

                                $producto = ['idproducto' => $idproducto];
                                $colProductos = $objProducto->buscar($producto);

                                // Voy guardando datos de productos comprados y el monto total de la compra
                                foreach ($colProductos as $producto) {
                                    $nombreProducto = $producto->getProNombre();
                                    $items[] = $cantProducto . " " . $nombreProducto;
                                    $monto += $producto->getProPrecio();
                                }
                            }

                            // Separamos con una "coma" en caso de que el cliente tenga más de un producto
                            $totalItemsCompra = implode(", ", $items);

                            // Obtengo las fechas de inicio y fin de la compra
                            $compraEstado = $objCompraEstado->buscar($compra);

                            // Guardo el último estado de la compra y las fechas
                            foreach ($compraEstado as $estado) {
                                $estadoDescripcion = $estado->getObjCompraEstadoTipo()->getCetDescripcion();
                                $fechaInicio = $estado->getCeFechaIni();

                                // Establezco fecha fin en caso de estar enviada o cancelada
                                if ($estadoDescripcion === "enviada" || $estadoDescripcion === "cancelada") {
                                    $fechaFin = $estado->getCeFechaFin();
                                } else {
                                    $fechaFin = "-";
                                }
                            }

                            // Excluir compras con estado "carrito"
                            if ($estadoDescripcion === "carrito") {
                                continue;
                            }
                        ?>
                            <tr>
                                <th scope="row"><?php echo $idcompra ?></th>
                                <td><?php echo $cofecha ?></td>
                                <td><?php echo $totalItemsCompra ?></td>
                                <td><?php echo "$" . $monto ?></td>
                                <td><?php echo $estadoDescripcion ?></td>
                                <td><?php echo $fechaInicio ?></td>
                                <td><?php echo $fechaFin ?></td>
                                <td>
                                    <?php
                                    // Genero botones para cambiar estado de compra
                                    switch ($estadoDescripcion) {
                                        case 'enviada':
                                            $mensaje = "Compra finalizada ";
                                            $color = 'success';
                                            $icono = '<i class="bi bi-shield-fill-check"></i>';
                                            break;
                                        case 'cancelada':
                                            $mensaje = "Compra cancelada ";
                                            $color = 'danger';
                                            $icono = '<i class="bi bi-x-square-fill"></i>';
                                            break;
                                    }
                                    ?>
                                    <!-- Genero botones de acción y textos -->
                                    <?php if ($estadoDescripcion == 'enviada' || $estadoDescripcion == 'cancelada') : ?>
                                        <p class="text-<?php echo $color ?> fw-bold"><?php echo $mensaje . $icono ?></p>
                                    <?php else : ?>
                                        <div class="d-flex">
                                            <button
                                                class="cambiarEstadoCompra btn btn-danger w-100 m-1" type="button"
                                                data-idcompra="<?php echo $idcompra; ?>"
                                                data-accion="Cancelar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cambiarEstadoCompra">
                                                Cancelar
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><?php echo "Historial de compras vacío."; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../js/ajax/cambiarEstadoCompra.js"></script>
<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
?>

