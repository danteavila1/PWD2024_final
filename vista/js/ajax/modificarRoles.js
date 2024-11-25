$(document).on('click', '.modificarRoles', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idusuario = $(this).data('idusuario');
    var usnombre = $(this).data('usnombre');
    var roles = $(this).data('roles');

    // Preparo los valores para mostrarlos en el modal
    $('span[name="idusuario"]').text(idusuario);
    $('span[name="usnombre"]').text(usnombre);
    $('span[name="roles"]').text(roles);

    $('#modificarRoles').modal('show');
    $('#modificarRoles .btn-success').on('click', function () {

        // Acá pongo todos los roles elegidos del modal
        var idrol = $("input[name='idrol[]']:checked").map(function () {
            return $(this).val();
        }).get();

        // Verifico que se haya elegido al menos uno
        if (idrol.length == 0) {
            Swal.fire({
                title: "Error",
                text: "Seleccione al menos un rol",
                icon: "error"
            });
            return;
        }

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idusuario': idusuario,
            'idrol': idrol
        };

        $.ajax({
            url: "accion/modificarRoles.php",
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
                // console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                // console.log("Detalles del error:", jqXHR.responseText);
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                }).then(() => location.reload());
            }
        });

        $('#modificarRoles').modal('hide');
    });
});
