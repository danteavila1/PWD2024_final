<?php 
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");

$abmProducto = new AbmProducto;
$productos = array();
$productos = $abmProducto->buscar(null);

$datos = data_submitted();
?>

        
<section>
        <h2> Productos </h2>
        <div>
            <button class="btn btn-primary"><a href="realizaReporte.php">Reporte PDF</a></button>
        </div>
            <?php

                if (count($productos) > 0) {
                    foreach ($productos as $producto) {
                            echo "<div onclick='rellenar(" . $producto->getIdProducto() . ", `" . $producto->getProNombre() . "`, `" . 
                            $producto->getProImagen() . "`, " . $producto->getProCantStock() . ", " . $producto->getProPrecio() . 
                            ")' class='producto'>";
                            echo "<p>" . $producto->getProNombre() . "</p>";
                            echo "<img width='250' height='150' src='../images/" . $producto->getProImagen() . "' />";
                            echo '<br/>';
                            echo "$" . $producto->getProPrecio();
                            echo "<br/>";
                            echo "<p>" . $producto->getProCantStock() . " unidades <br/>";
                            echo "id: " . $producto->getIdProducto() . "</P>";
                            echo "</div>";
                        }
                    }
                 else{
                    echo "<h4>No hay productos cargados</h4>";
                }
            ?>

    <div class="agregarEditarProducto">
        <div class="col-md-6">
            <h2 class="mb-4">Agregar/Editar producto</h2>
                <form method="post" action="../accion/agregarEditarProducto.php" enctype="multipart/form-data">
                    <div class="mb-1">
                        <label class="form-label" for="idProducto">Id para editar:</label>
                        <br/>
                        <input class="form-control" type="text" id="idProducto" name="idProducto"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="proNombre">Nombre:</label>
                        <br/>
                        <input class="form-control" required type="text" id="proNombre" name="proNombre"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="proDetalle">detalle:</label>
                        <br/>
                        <input class="form-control" required type="text" id="proDetalle" name="proDetalle"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="proCantStock">Stock:</label>
                        <br/>
                        <input class="form-control" required type="number" id="proCantStock" name="proCantStock"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="proPrecio">Precio:</label>
                        <br/>
                        <input step="0.01" class="form-control" required type="number" id="proPrecio" name="proPrecio"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="foto">Foto:</label>
                        <br/>
                        <input class="form-control" id="foto" name="foto" required type="file" accept="image/png"/>
                        <br/>
                    </div>
                    <input type="submit" class="btn btn-primary" value="enviar"/>
                </form>
            </div>
    </div>
    <br/>
    <div class="eliminarProductos">
        <div class="col-md-6">
            <h2 class="mb-4">Eliminar producto</h2>
            <form method="get" action="../accion/eliminarProducto.php">
                <label class="form-label" for="idProducto">Id del producto:</label>
                <br/>
                <input required class="form-control" type="number" id="idProducto" name="idProducto"/>
                <br/>
                <input type="submit" class="btn btn-primary" value="enviar"/>
            </form>
        </div>
    </div>
        
</section>