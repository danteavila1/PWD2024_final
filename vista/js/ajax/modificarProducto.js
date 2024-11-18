$(document).on('click', '.modificarProducto', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idproducto = $(this).data('idproducto');
    var nombre = $(this).data('nombre');
    var detalle = $(this).data('detalle');
    var cantStock = $(this).data('cantstock');
    var precio = $(this).data('precio');
    var imagen = $(this).data('imagen');

    // Preparo los valores para mostrarlos en el modal
    $('#idproductoModif').val(idproducto);
    $('#nombreModif').val(nombre);
    $('#detalleModif').val(detalle);
    $('#cantStockModif').val(cantStock);
    $('#precioModif').val(precio);
    $('#imagenModif').attr('src', '../images/' + imagen);

    $('#modificarProducto').modal('show');

    $('#modificarProducto .btn-success').off('click').on('click', function () {

        // Construyo objeto para mandar a solicitud AJAX
        var formData = new FormData();
        formData.append('idproducto', idproducto);
        formData.append('pronombre', $('#nombreModif').val());
        formData.append('prodetalle', $('#detalleModif').val());
        formData.append('procantstock', $('#cantStockModif').val());
        formData.append('proprecio', $('#precioModif').val());

        // Si se seleccionó una nueva imagen, la agregamos al formData, sino
        // enviamos la que ya tenía
        var nuevaImagen = $('#nuevaImagen')[0].files[0];
        if (nuevaImagen) {
            formData.append('nuevaImagen', nuevaImagen);
        } else {
            formData.append('proimagen', imagen);
        }

        $.ajax({
            url: "accion/modificarProducto.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (res) {
                if (res.mensaje === 1) {
                    // Muestro alerta sin cerrar el modal
                    Swal.fire({
                        title: 'Solo se permite formato jpg, jpeg y png',
                        icon: res.icono,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#modificarProducto').modal('show');
                    });
                } else if (res.mensaje === 2) {
                    Swal.fire({
                        title: 'Subida de imagen fallida',
                        icon: res.icono,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#modificarProducto').modal('show');
                    });
                } else {
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                    $('#modificarProducto').modal('hide');
                }
            },
            error: function (res, jqXHR, textStatus, errorThrown) {
                // console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                // console.log("Detalles del error:", jqXHR.responseText);
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                });
            }
        });
        $('#modificarProducto').modal('hide');
    });
});
