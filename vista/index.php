<?php 
include_once("../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");
?>

<main class="main">
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
                <img src="https://www.dhresource.com/webp/m/0x0/f2/albu/g22/M01/71/17/rBNaEmJSodeAfAaMAAk6o_3hjI8982.jpg" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
              </div>

              <!-- image two -->
              <div class="carousel-item">
                <img src="https://takumiya.fr/cdn/shop/files/Coussin-peluche-kawaii-chat-noir-18cm_9cc2c974-4a01-45d5-a11e-d27e2db5281a.jpg?v=1702217364&width=1445" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
              </div>

              <!-- Image Three -->
              <div class="carousel-item">
                <img src="https://down-mx.img.susercontent.com/file/sg-11134201-23030-x7hy7c9fwwov02" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
              </div>

              <!-- Image Four -->
              <div class="carousel-item">
                <img src="https://m.media-amazon.com/images/I/717B-Oa8QZL.jpg" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
              </div>

              <!-- Image Five -->
              <div class="carousel-item">
                <img src="https://www.infobae.com/resizer/v2/KUKNYFRHSFG3PXCNNFCHGOAUPE.jpg?auth=46bd60a8e48a8c8c112ec73a27022535d5cfb83980d2fee4314c9d84cdbb15ab&smart=true&width=1200&height=1200&quality=85" class="d-block w-100 img-fluid" style="height: 750px; object-fit: cover;" alt="...">
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
    <div id="menu"></div>
</main>
<?php include_once("estructura/footer.php");?>