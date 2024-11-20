<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
$session = new Session();

// Creo instancia del objeto AbmCompra y accedo al método correspondiente
$objCompra = new AbmCompra();
$colCompras = $objCompra->buscar("");

// Incluyo modal
include_once('cambiarEstadoCompra.php');

// Verifico que hayan usuarios en la base de datos
$hayCompras = false;
if (count($colCompras) > 0) {
    $hayCompras = true;
}

?>

<h3> Iniciado como <?php echo $_SESSION['usnombre'] ?></h3>

<div class="justify-content-md-center align-items-center mt-5">
    <div class="card shadow  mx-usuario">
        <div class="card-header">
            <h3>Gestionar compras</h3>
        </div>
        <div class="card-body">
            <?php if ($hayCompras): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID compra</th>
                            <th scope="col">Fecha compra</th>
                            <th scope="col">Ítems</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Fecha fin</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                    // Colección de estados de compra
                    $objCompraEstado = new AbmCompraEstado();
                    $colCompraEstado = $objCompraEstado->buscar("");

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
                        $precio = 0;

                        // Itero los ítems de cada compra
                        foreach ($colItemsCompra as $itemCompra) {
                            $idproducto = $itemCompra->getIdProducto();
                            $cantProducto = $itemCompra->getCiCantidad();

                            $producto = ['idproducto' => $idproducto];
                            $colProductos = $objProducto->buscar($producto);

                            foreach ($colProductos as $producto) {
                                $nombreProducto = $producto->getProNombre();
                                $items[] = $cantProducto . " " . $nombreProducto;
                                $precio += $producto->getProPrecio();
                            }
                        }

                        // Separamos con una "coma" en >> caso de que el cliente tenga más de un producto en la compra <<
                        $totalItemsCompra = implode(", ", $items);

                        // Obtengo las fechas de inicio y fin de la compra
                        $objCompraEstado = new AbmCompraEstado();
                        $compraEstado = $objCompraEstado->buscar($compra);

                        // Guardo el último estado de la compra
                        foreach ($compraEstado as $estado) {
                            $compraEstado = $estado->getObjCompraEstadoTipo()->getCetDescripcion();

                            // Establezco fecha fin en caso de estar enviada o cancelada
                            if ($compraEstado === "enviada" || $compraEstado === "cancelada") {
                                $fechaFin = $estado->getCeFechaFin();
                            } else {
                                $fechaFin = "-";
                            }
                        }
                    ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $idcompra ?></th>
                                <td><?php echo $cofecha ?></td>
                                <td><?php echo $totalItemsCompra ?></td>
                                <td><?php echo "$" . $precio ?></td>
                                <td><?php echo $fechaFin ?></td>
                                <td><?php echo $compraEstado ?>
                                <td>
                                    <?php
                                    // Genero botones para cambiar estado de compra
                                    switch ($compraEstado) {
                                        case 'iniciada':
                                            $accion = "Aceptar";
                                            $color = "info";
                                            break;
                                        case 'aceptada':
                                            $accion = "Enviar";
                                            $color = "success";
                                            break;
                                        case 'enviada':
                                            $mensaje = "Compra finalizada ";
                                            $color = 'success';
                                            $icono = '<i class="bi bi-shield-fill-check">';
                                            break;
                                        case 'cancelada':
                                            $mensaje = "Compra cancelada ";
                                            $color = 'danger';
                                            $icono = '<i class="bi bi-x-square-fill">';
                                            break;
                                    }
                                    ?>
                                    <!-- Genero botones de acción y textos -->
                                    <?php if ($compraEstado == 'enviada' || $compraEstado == 'cancelada') : ?>
                                        <p class="text-<?php echo $color ?> fw-bold"><?php echo $mensaje . $icono ?></i></i></p>
                                    <?php else : ?>
                                        <div class="d-flex">
                                            <button
                                                class="cambiarEstadoCompra btn btn-<?php echo $color ?> w-100 m-1" type="button"
                                                data-idcompra="<?php echo $idcompra; ?>"
                                                data-accion="<?php echo $accion; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cambiarEstadoCompra">
                                                <?php echo $accion; ?>
                                            </button>
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
                        </tbody>
                    <?php endforeach; ?>
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
