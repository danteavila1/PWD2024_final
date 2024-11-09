<?php
include_once("../configuracion.php");


$productos = new AbmProducto();
$listaProductos = $productos->buscar(null);
if (count($listaProductos) > 0) {
	?>

	<div class="container mt-4" >
		<h1 class="mb-4" style="margin-top:5%;">Nuestros Productos</h1>
		<div class="row">

			<?php
			foreach ($listaProductos as $producto) {
					?>

				<div class="col-md-4 mb-4">
					<div class="card " onclick="verDetalle(this)">
						<div class="" data-bs-toggle="modal" href="#modalDetalle" role="button">
							<div class="card-body">
								<h5 class="card-title" id= "nombreProducto"><?php echo $producto->getProNombre(); ?></h5>
								<p class="card-text" id= "descripcionProducto"><?php echo $producto->getProDetalle(); ?></p>
								<div class="row">
									<p class="card-text col" id= "precioProducto">Precio: $<?php echo $producto->getPrecio(); ?></p>
									<p class="card-text col" id= "stock">Disponible: <?php echo $producto->getProCantStock(); ?></p>
								</div>
							</div>
						</div>
						<div class="card-footer z-3">
							<form method="get" action="#">

								<div class="row align-content-end">
									<div class="input-group mb-3 col">
										<!-- <span class="input-group-text" id="inputGroup-sizing-default">Cantidad:</span>
										<input type="number" class="form-control " id= "cantidadProducto" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="1"> -->
										<input type="number" class="form-control d-none" id= "cantidadProducto" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="1" value=1> 
									</div>
									<?php
											if ($sesion->getRolActivo()!== null) {
												if ($sesion->getRolActivo()->getRolDescripcion() == "Cliente") {
													?>
													<div class="col-3">
														<button tytpe="submit" class="btn btn-primary" id="sumarCarrito" data-id="<?php echo $producto->getIdproducto(); ?>" 
														onclick = "agregarCarrito(<?php echo $producto->getIdproducto(); ?>,<?php echo $sesion->getIdUsuario(); ?>, 1)">
														<i class="bi bi-cart-plus-fill"></i>
													</button>
												</div>
												<?php
												} 
											}else {
												?>
												<div class="col-3">
													<button class="btn btn-primary" tytpe="submit" id="sumarCarrito" data-id="<?php echo $producto->getIdproducto(); ?>" onclick = "Swal.fire({
      icon: 'error',
      title: 'Hay que iniciar sesion para agregar al carrito',
      showConfirmButton: false,
      timer: 1500
    })

  setTimeout(function () {
      location.href = base_url+'Vista/public/login.php';
  }, 1500);"><i class="bi bi-cart-plus-fill"></i></button>
												</div>
												<?php
											}
											?>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php
			}
			?>

		</div>
	</div>
	<?php
} else { 
	?>
	<div class="container p-2">
		<div class="alert alert-info" role="alert">
				No hay productos cargados!
		</div>
	</div>
        
<?php
 }
 ?>



<!-- MODAL DETALLE DE PRODUCTO -->

<div class="modal fade" id="modalDetalle" aria-hidden="true" aria-labelledby="detalleModalToggle" tabindex="-1">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title" id="detalleModalToggle">Detalle del Producto</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body row">
				<div class="col-md-4">
					<img id="fotoDetalle" class="img-thumbnail" src="" alt="">
				</div>
				<div class="col">
					<h3 id="nombreDetalle"></h3>
					<p id="descripcionDetalle"></p>
					<p id="cantidadDetalle"></p>
				</div>
			</div>
			<div>
				<p id="precioDetalle"></p>
			</div>
			<div class="modal-footer">
				<form method="post" action="#" class="needs-validation" novalidate>
					<input type="text" name="idProducto" id="idDetalle" class="d-none">
					<div>
						<input type="number" name="ciCantidad" id="cantidadInput" min="1" class="form-control" placeholder="Ingrese la cantidad que desea comprar" required>
						<div class="invalid-feedback mb-1">
							No hay stock suficiente!
						</div>
						<div class="valid-feedback">
							Correcto!
						</div>
					</div>
					<input class="btn btn-success me-2"  name="boton_enviar" id="boton_enviar" value="Agregar al Carrito" onclick = "agregarCarrito(<?php echo $producto->getIdproducto(); ?>,<?php echo $sesion->getIdUsuario(); ?>, 1)">
					<!-- <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cerrar</button> -->
				</form>
			</div>
		</div>
	</div>
</div>


<!-- MODAL CARRITO -->



<?php
include_once("../estructura/footer.php");
?>
<script src="<?php echo BASE_URL ?>Vista/js/productoCliente.js"></script>
