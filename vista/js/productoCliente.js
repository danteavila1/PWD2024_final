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

function agregarCarrito(idProducto, idUsuario) {
    console.log("entra a agregarCarrito");
    console.log(idProducto);
    console.log(idUsuario);

    // Crear un objeto con los datos necesarios
    let datosProducto = {
        idproducto: idProducto,
        idusuario: idUsuario,
        cantidad: 1 // Por ahora, agregamos una cantidad fija de 1
    };

    // Enviar los datos al servidor usando AJAX
    $.ajax({
        url: '../vista/GestionCompras/accion/accionCarrito.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datosProducto),
        success: function(response) {
            // Suponiendo que el servidor devuelve una respuesta en formato JSON
            try {
                const data = JSON.parse(response);
                console.log('Respuesta del servidor:', data); // Procesa el JSON devuelto por el servidor
            } catch (e) {
                console.error('Error al parsear la respuesta del servidor:', e);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error); // Manejo de errores
        }
    });
}

function redirigir(){
    location.href="../vista/login/formIniciarSesion.php";
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
