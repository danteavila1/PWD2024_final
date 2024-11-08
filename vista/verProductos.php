<?php
// Incluir archivos de configuración y encabezado
include_once("../configuracion.php");

// Incluir clases ABM necesarias
include_once("../control/AbmProducto.php");

// Cre una instancia del ABM para obtener los datos de los productos
$abmProducto = new AbmProducto();
$productos = $abmProducto->buscar(null); // Obtiene todos los productos
?>

<body class="bg-dark">

    <main class="container-fluid tablas container text-center text-light">
        <h1>Productos</h1>
        <div class="btn btn-outline-success mb-3" onclick="nuevoProducto()">Nuevo Producto</div>

        <table class="table table-dark table-striped" id="tablaProductos">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Detalle</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($productos)) {
                    foreach ($productos as $producto) {
                        echo "<tr>";
                        echo "<td>" . $producto->getIdProducto() . "</td>";
                        echo "<td>" . $producto->getProNombre() . "</td>";
                        echo "<td>" . $producto->getProDetalle() . "</td>";
                        echo "<td>$" . number_format($producto->getPrecio(), 2) . "</td>";
                        echo "<td class='stockProducto'>" . $producto->getProCantStock() . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-warning editarProducto' data-id='" . $producto->getIdProducto() . "'>Editar</button> ";
                        echo "<button class='btn btn-danger eliminarProducto' data-id='" . $producto->getIdProducto() . "'>Eliminar</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay productos registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="./js/productos/gestionProductos.js"></script>
    <script type="text/javascript" src="./js/productos/estilosProductos.js"></script>
</body>
</html>
