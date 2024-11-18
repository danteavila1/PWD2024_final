$(document).on('click', '.modificarRol', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idrol = $(this).data('idrol');
    var rodescripcion = $(this).data('rodescripcion');

    // Preparo los valores para mostrarlos en el modal
    $('#idrolModif').val(idrol);
    $('#rodescripcionModif').val(rodescripcion);

    $('#modificarRol').modal('show');
    $('#modificarRol .btn-success').off('click').on('click', function () {

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idrol': idrol,
            'rodescripcion': $('#rodescripcionModif').val(),
        };

        $.ajax({
            url: "accion/modificarRol.php",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (res) {
                if (res.mensaje === 'Rol existente') {
                    // Muestro alerta sin cerrar el modal
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#modificarRol').modal('show');
                    });
                } else {
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                    $('#modificarRol').modal('hide');
                }
            },
            error: function (res, jqXHR, textStatus, errorThrown) {
                // console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                // console.log("Detalles del error:", jqXHR.responseText);
                Swal.fire({
                    title: "Modificación fallida",
                    icon: error
                }).then(() => location.reload());
            }
        });
        $('#modificarRol').modal('hide');
    });
});
