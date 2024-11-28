<?php
include_once("../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
$session = new Session();

// Creo instancia del objeto AbmCompra y accedo al método correspondiente
$objCompra = new AbmCompra();
$idusuario = ['idusuario' => $_SESSION['idusuario']];
$colCompras = $objCompra->buscar($idusuario);


// Verifico que hayan usuarios en la base de datos
$hayCompras = false;
if (count($colCompras) > 0) {
    $hayCompras = true;
}

?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Carrito</h3>
        </div>
        <div class="card-body">
            <?php if ($hayCompras): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $montoTotalGeneral = 0; // Variable para el monto total de todos los ítems

                        // Itero sobre todas las compras
                        foreach ($colCompras as $compra):

                            // Id de la compra actual
                            $idcompra = $compra->getIdCompra();
                            $compraParams = ['idcompra' => $idcompra];

                            // Verifico el estado de la compra
                            $objCompraEstado = new AbmCompraEstado();
                            $colCompraEstado = $objCompraEstado->buscar($compraParams);

                            // Obtengo el último estado de la compra
                            $estadoCompra = '';
                            foreach ($colCompraEstado as $compraEstado) {
                                $estadoCompra = $compraEstado->getObjCompraEstadoTipo()->getCetDescripcion();
                            }

                            // Solo procesar compras en estado "carrito"
                            if ($estadoCompra !== "carrito") {
                                continue;
                            }

                            // Colección de ítems de la compra en estado "carrito"
                            $objCompraItem = new AbmCompraItem();
                            $colItemsCompra = $objCompraItem->buscar($compraParams);

                            $objProducto = new AbmProducto();

                            // Itero los ítems de la compra en estado "carrito"
                            foreach ($colItemsCompra as $itemCompra) {
                                $idproducto = $itemCompra->getIdProducto();
                                $cantProducto = $itemCompra->getCiCantidad();

                                $producto = ['idproducto' => $idproducto];
                                $colProductos = $objProducto->buscar($producto);

                                // Procesamos cada producto encontrado
                                foreach ($colProductos as $producto) {
                                    $nombreProducto = $producto->getProNombre();
                                    $precioProducto = $producto->getProPrecio();
                                    $montoTotalGeneral += $precioProducto * $cantProducto; // Sumar al total general
                        ?>
                                    <tr data-idcompra="<?php echo $idcompra; ?>">
                                        <td><?php echo $nombreProducto; ?></td>
                                        <td><?php echo $cantProducto; ?></td>
                                        <td><?php echo "$" . ($precioProducto * $cantProducto); ?></td>
                                    </tr>
                        <?php
                                }
                            }
                        endforeach;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total:</strong></td>
                            <td><strong><?php echo "$" . $montoTotalGeneral; ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary" id="comprarBtn" onclick="iniciarCompraCarrito()">Comprar</button>
                </div>
            <?php else: ?>
                <p><?php echo "Historial de compras vacío."; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
?>
