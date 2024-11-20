$(document).on('click', '.cambiarEstadoCompra', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idcompra = $(this).data('idcompra');
    var accion = $(this).data('accion');

    // Preparo los valores para mostrarlos en el modal
    $('span[name="idcompra"]').text(idcompra);
    $('span[name="accion"]').text(accion);

    $('#cambiarEstadoCompra').modal('show');
    $('#cambiarEstadoCompra .btn-danger').on('click', function () {

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idcompra': idcompra,
            'accion': accion
        };

        $.ajax({
            //modificar dsps
            url: "accion/cambiarEstadoCompra.php",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (res) {
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                }).then(() => location.reload());
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                console.log("Detalles del error:", jqXHR.responseText);
                Swal.fire({
                    title: "Error en el servidor",
                    icon: "error"
                }).then(() => location.reload());
            }
        });
        $('#cambiarEstadoCompra').modal('hide');
    });
});
