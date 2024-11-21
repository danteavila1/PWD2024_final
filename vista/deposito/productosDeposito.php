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
            <?php

                if (count($productos) > 0) {
                    foreach ($productos as $producto) {
                            echo "<div onclick='rellenar(" . $producto->getIdProducto() . ", `" . $producto->getProNombre() . "`, `" . 
                            $producto->getProDetalle() . "`, " . $producto->getProCantStock() . ", " . $producto->getProPrecio() . 
                            ", `" . $producto->getProImagen() . "`)' class='producto'>";
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
                        <input class="form-control" type="text" id="idProducto" name="idproducto"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="proNombre">Nombre:</label>
                        <br/>
                        <input class="form-control" required type="text" id="proNombre" name="pronombre"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="proDetalle">Detalle:</label>
                        <br/>
                        <input class="form-control" required type="text" id="proDetalle" name="prodetalle"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="proCantStock">Stock:</label>
                        <br/>
                        <input class="form-control" required type="number" id="proCantStock" name="procantstock"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="proPrecio">Precio:</label>
                        <br/>
                        <input step="0.01" class="form-control" required type="number" id="proPrecio" name="proprecio"/>
                        <br/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="foto">Foto:</label>
                        <br/>
                        <input class="form-control" id="foto" name="foto" required type="file" accept="image/png"/>
                        <br/>
                        <!-- Contenedor para la imagen actual -->
                        <img id="fotoPreview" name="proimagen" src="" alt="Imagen del producto" style="display: none; max-width: 200px; max-height: 150px;"/>
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
    
    <script>

        function rellenar(id, nombre, detalle, stock, precio, imagen) {
            // Elementos del formulario
            let idProducto = document.getElementById('idProducto');
            let proNombre = document.getElementById('proNombre');
            let proDetalle = document.getElementById('proDetalle');
            let proCantStock = document.getElementById('proCantStock');
            let proPrecio = document.getElementById('proPrecio');
            let fotoPreview = document.getElementById('fotoPreview'); // Contenedor para mostrar la imagen

            // Rellenar valores
            idProducto.value = id;
            proNombre.value = nombre;
            proDetalle.value = detalle;
            proCantStock.value = stock;
            proPrecio.value = precio;

            // Mostrar la imagen actual del producto
            if (fotoPreview) {
                fotoPreview.src = '../images/' + imagen; // Ruta relativa a la imagen
                fotoPreview.style.display = 'block'; // Asegurar que se vea
            }
        }
    
    </script>
</section>