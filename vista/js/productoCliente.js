// Mostrar detalles de un producto en el modal
function verDetalleProducto(idProducto) {
    // Obtener los detalles del producto mediante una solicitud AJAX
    $.ajax({
        url: '../vista/accion/accionProductos.php',
        type: 'POST',
        data: { idProducto: idProducto },
        success: function(response) {
            // Suponiendo que `response` contiene los datos en formato JSON
            const producto = JSON.parse(response);

            // Llenar los campos del modal con los datos del producto
            $('#nombreDetalle').text(producto.nombre);
            $('#descripcionDetalle').text(producto.descripcion);
            $('#cantidadDetalle').text(`Stock disponible: ${producto.stock}`);
            $('#precioDetalle').text(`Precio: $${producto.precio}`);
            $('#fotoDetalle').attr('src', '../vista/images/' + producto.imagen);

            // Mostrar el modal
            $('#modalDetalle').modal('show');
        },
        error: function() {
            alert('Error al obtener los detalles del producto.');
        }
    });
}

// Función para agregar un producto al carrito
function agregarCarrito(idProducto, idUsuario, cantidad) {
    $.ajax({
        url: '../vista/accion/accionProductos.php',
        type: 'POST',
        data: {
            accion: 'agregarCarrito',
            idProducto: idProducto,
            idUsuario: idUsuario,
            cantidad: cantidad
        },
        success: function(response) {
            const resultado = JSON.parse(response);
            if (resultado.exito) {
                alert('Producto agregado al carrito.');
            } else {
                alert('No se pudo agregar el producto al carrito.');
            }
        },
        error: function() {
            alert('Error al agregar el producto al carrito.');
        }
    });
}

// Función para editar un producto
$('.editarProducto').on('click', function() {
    const idProducto = $(this).data('id');
    window.location.href = `editarProducto.php?id=${idProducto}`;
});

// Función para eliminar un producto
$('.eliminarProducto').on('click', function() {
    const idProducto = $(this).data('id');
    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        $.ajax({
            url: '../vista/accion/accionProductos.php',
            type: 'POST',
            data: {
                accion: 'eliminarProducto',
                idProducto: idProducto
            },
            success: function(response) {
                const resultado = JSON.parse(response);
                if (resultado.exito) {
                    alert('Producto eliminado con éxito.');
                    location.reload(); // Recargar la página para actualizar la lista
                } else {
                    alert('No se pudo eliminar el producto.');
                }
            },
            error: function() {
                alert('Error al eliminar el producto.');
            }
        });
    }
});
