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

<h3> Iniciado como <?php echo $_SESSION['usnombre'] ?></h3>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="listarUsuario.php">Administrar usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listarRoles.php">Administrar roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Administrar productos</a>
                <li class="nav-item">
                    <a class="nav-link" href="#">Administrar menús</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="justify-content-md-center align-items-center mt-5">
    <div class="card shadow  mx-usuario">
        <div class="card-header">
            <h3>Listado de productos cargados en la base de datos</h3>
            <div class="d-flex">
                <button class="altaProducto btn btn-success me-2" type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#altaProducto">
                    Crear producto
                </button>
                <a href="../login/accion/cerrarSesion.php">
                    <input type="submit" class="btn btn-secondary me-2" value="Cerrar sesión">
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if ($hayProductos): ?>
                <table class="table">
                    <thead>
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
                    <?php
                    for ($i = 0; $i < count($colProductos); $i++):
                        $idproducto = $colProductos[$i]->getIdProducto();
                        $nombre = $colProductos[$i]->getProNombre();
                        $detalle = $colProductos[$i]->getProDetalle();
                        $cantStock = $colProductos[$i]->getProCantStock();
                        $precio = $colProductos[$i]->getProPrecio();
                        $imagen =  $colProductos[$i]->getProImagen();
                    ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $idproducto ?></th>
                                <td>
                                    <img src="../images/<?php echo $imagen ?>" alt="Producto" style="max-width: 60px; max-height: 60px;">
                                </td>
                                <td><?php echo $nombre ?></td>
                                <td><?php echo $detalle ?></td>
                                <td><?php echo $cantStock ?></td>
                                <td><?php echo $precio ?></td>
                                <td>
                                    <button class="modificarProducto btn btn-primary" type="button"
                                        data-idproducto=<?php echo $idproducto; ?>
                                        data-nombre=<?php echo $nombre; ?>
                                        data-detalle=<?php echo $detalle; ?>
                                        data-cantstock=<?php echo $cantStock; ?>
                                        data-precio=<?php echo $precio; ?>
                                        data-imagen=<?php echo $imagen; ?>
                                        data-bs-toggle="modal"
                                        data-bs-target="#modificarProducto">
                                        Modificar
                                    </button>

                                    <button class="bajaProducto btn btn-danger" type="button"
                                        data-idproducto=<?php echo $idproducto; ?>
                                        data-nombre=<?php echo $nombre; ?>
                                        data-bs-toggle="modal"
                                        data-bs-target="#bajaProducto">
                                        Eliminar
                                    </button>

                                </td>
                            </tr>
                        </tbody>
                    <?php endfor; ?>
                </table>
            <?php else: ?>
                <p><?php echo "No hay productos cargados en la base de datos."; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../js/ajax/altaProducto.js"></script>
<script src="../js/ajax/bajaProducto.js"></script>
<script src="../js/ajax/modificarProducto.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
