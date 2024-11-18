$(document).on('click', '.altaProducto', function () {
    // Limpio los campos al abrir el modal
    $('#pronombre').val('');
    $('#prodetalle').val('');
    $('#procantstock').val('');
    $('#proprecio').val('');
    $('#proimagen').val('');

    $('#altaProducto').modal('show');

    $('#altaProducto .btn-success').off('click').on('click', function () {
        // Construyo objeto FormData para enviar datos y archivo
        var formData = new FormData();
        formData.append('pronombre', $('#pronombre').val());
        formData.append('prodetalle', $('#prodetalle').val());
        formData.append('procantstock', $('#procantstock').val());
        formData.append('proprecio', $('#proprecio').val());

        // Verifico si se seleccionó un archivo
        var nuevaImagen = $('#proimagen')[0].files[0];
        if (nuevaImagen) {
            formData.append('proimagen', nuevaImagen);
        }

        $.ajax({
            url: "accion/altaProducto.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (res) {
                if (res.mensaje === 1) {
                    Swal.fire({
                        title: 'Solo se permite formato jpg, jpeg y png',
                        icon: res.icono,
                        confirmButtonText: 'OK'
                    });
                } else if (res.mensaje === 2) {
                    Swal.fire({
                        title: 'Subida de imagen fallida',
                        icon: res.icono,
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                }
                $('#altaProducto').modal('hide');
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
    });
});
