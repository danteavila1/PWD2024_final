$(document).on('click', '.bajaRol', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idrol = $(this).data('idrol');
    var rodescripcion = $(this).data('rodescripcion');

    // Preparo los valores para mostrarlos en el modal
    $('span[name="idrol"]').text(idrol);
    $('span[name="rodescripcion"]').text(rodescripcion);

    $('#bajaRol').modal('show');
    $('#bajaRol .btn-danger').on('click', function () {

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idrol': idrol,
        };

        $.ajax({
            url: "accion/bajaRol.php",
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
                // console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                // console.log("Detalles del error:", jqXHR.responseText);
                Swal.fire({
                    title: 'Error en el servidor',
                    icon: 'error'
                }).then(() => location.reload());
            }
        });
        $('#bajaRol').modal('hide');
    });
});
