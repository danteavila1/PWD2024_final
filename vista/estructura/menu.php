<!-- INICIO MENU PUBLICO -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>vista">Muñecos Kawaii</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>vista/productos.php">Tienda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Novedades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contacto</a>
        </li>
      </ul>
      <a href="<?php echo BASE_URL; ?>vista/login/formIniciarSesion.php" class="btn btn-primary ms-3">Iniciar sesión</a>

      <a href="../cliente/carrito.php" class="ms-3">
        <img src="<?php echo BASE_URL; ?>vista/images/carrito.png" alt="Carrito" class="imgCart me-2" style="height: 2em;">
        <span>
        <?php echo isset($_SESSION['numero']) ? $_SESSION['numero'] : 0; ?>
        </span>
      </a>

    </div>
  </div>
</nav>