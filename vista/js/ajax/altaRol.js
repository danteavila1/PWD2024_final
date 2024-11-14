$(document).on('click', '.altaRol', function () {
    // Muestro el modal
    $('#altaRol').modal('show');

    // Se envían los datos al clickear "Crear" en el modal
    $('#altaRol .btn-success').off('click').on('click', function () {

        // Obtengo el valor del input
        var rodescripcion = $('#rodescripcion').val();

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'rodescripcion': rodescripcion,
        };

        $.ajax({
            url: "accion/altaRol.php",
            type: "POST",
            dataType: "json",
            data: formData,
            async: false,

            success: function (res) {
                if (res.mensaje === "Rol existente") {
                    // Muestro alerta sin cerrar el modal
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reabro modal después de la alerta
                        $('#altaRol').modal('show');
                    });
                } else {
                    // Mostrar el mensaje de éxito o error y recargar la página
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                    // Cierro modal después recargar la página
                    $('#altaRol').modal('hide');
                }
            },
            error: function (res, jqXHR, textStatus, errorThrown) {
                // console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                // console.log("Detalles del error:", jqXHR.responseText);
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                }).then(() => location.reload());
            }
        });
        // Cierro el modal
        $('#altaRol').modal('hide');
    });
});