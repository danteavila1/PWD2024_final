$(document).on('click', '.bajaProducto', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idproducto = $(this).data('idproducto');
    var nombre = $(this).data('nombre');

    // Preparo los valores para mostrarlos en el modal
    $('span[name="idproducto"]').text(idproducto);
    $('span[name="nombre"]').text(nombre);

    $('#bajaProducto').modal('show');
    $('#bajaProducto .btn-danger').on('click', function () {

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idproducto': idproducto,
        };

        console.log(formData)

        $.ajax({
            url: "accion/bajaProducto.php",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (res) {
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                }).then(() => location.reload());
            },
            error: function (res, jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                console.log("Detalles del error:", jqXHR.responseText);
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                }).then(() => location.reload());
            }
        });
        $('#bajaProducto').modal('hide');
    });
});
