$(document).on('click', '.bajaMenu', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idmenu = $(this).data('idmenu');
    var menombre = $(this).data('menombre');

    // Preparo los valores para mostrarlos en el modal
    $('span[name="idmenu"]').text(idmenu);
    $('span[name="menombre"]').text(menombre);

    $('#bajaMenu').modal('show');
    $('#bajaMenu .btn-danger').on('click', function () {

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idmenu': idmenu,
        };

        $.ajax({
            url: "accion/bajaMenu.php",
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
                    title: 'Error en el servidor',
                    icon: 'error'
                }).then(() => location.reload());
            }
        });
        $('#bajaMenu').modal('hide');
    });
});
