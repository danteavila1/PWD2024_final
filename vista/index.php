<?php
include_once("../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
?>

<main class="container p-5">

  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
    </div>

    <!-- Image Sliders -->
    <div class="carousel-inner">
      <!-- Image one-->
      <div class="carousel-item active">
        <img src="https://i.pinimg.com/736x/1a/26/ad/1a26ad5a1b362350117d95f38b3f0982.jpg" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
      </div>

      <!-- image two -->
      <div class="carousel-item">
        <img src="https://i.pinimg.com/control2/736x/e7/d4/57/e7d45764b3c0c5e62374105a33aef705.jpg" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
      </div>

      <!-- Image Three -->
      <div class="carousel-item">
        <img src="https://i.pinimg.com/736x/72/e4/29/72e429d4994de67dfb2d8bde768da953.jpg" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
      </div>

      <!-- Image Four -->
      <div class="carousel-item">
        <img src="https://i.pinimg.com/736x/35/3b/ef/353beffae9f092f3c6d19000309b2f9e.jpg" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
      </div>

      <!-- Image Five -->
      <div class="carousel-item">
        <img src="https://i.pinimg.com/control2/736x/41/3f/5c/413f5c806fe8605e2c2126bac44b13bd.jpg" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
      </div>
    </div>

    <!-- Carousel Controls -->
    <section>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>

      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </section>
  </div>
  <!-- CODIGO PUESTO SOLO PARA DEPURAR EL MENU DINAMICO, BORRAR CUANDO SE LOGRE -->
</main>
<?php include_once("productos.php");
