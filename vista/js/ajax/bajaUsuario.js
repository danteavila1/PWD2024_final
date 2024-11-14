$(document).on('click', '.bajaUsuario', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idusuario = $(this).data('idusuario');
    var usnombre = $(this).data('usnombre');
    var roles = $(this).data('roles');

    // Preparo los valores para mostrarlos en el modal
    $('span[name="idusuario"]').text(idusuario);
    $('span[name="usnombre"]').text(usnombre);
    $('span[name="roles"]').text(roles);

    $('#bajaUsuario').modal('show');
    $('#bajaUsuario .btn-danger').on('click', function () {

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idusuario': idusuario,
        };

        $.ajax({
            url: "accion/bajaUsuario.php",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (res) {
                console.log(res);
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                }).then(() => location.reload());
            },
            error: function (res, jqXHR, textStatus, errorThrown) {
                console.log(res);
                // console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                // console.log("Detalles del error:", jqXHR.responseText);
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                }).then(() => location.reload());
            }
        });
        $('#bajaUsuario').modal('hide');
    });
});






// $(document).on('click', '.deshabilitar', function () {
//     var idusuario = $(this).data('idusuario');
//     var usnombre = $(this).data('usnombre');

//     if (!idusuario) {
//         Swal.fire({
//             title: "No se pudo obtener el ID",
//             icon: "error"
//         });
//         return;
//     }

//     // Cerrar cualquier SweetAlert abierto antes de mostrar el nuevo
//     Swal.close();

//     // Crear la notificación de confirmación
//     Swal.fire({
//         title: 'Acción irreversible',
//         text: "ID usuario " + idusuario + " - Nombre usuario " + usnombre,
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Deshabilitar',
//         cancelButtonText: 'Cancelar',
//         cancelButtonColor: '#70747c',
//         confirmButtonColor: '#e03444'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: "accion/bajaUsuario.php",
//                 type: "POST",
//                 dataType: "json",
//                 data: { idusuario: idusuario }
//             })
//                 .done(function (res) {
//                     Swal.fire({
//                         title: res.mensaje,
//                         icon: res.icono
//                     }).then(() => location.reload());
//                 })
//                 .fail(function (res, jqXHR, textStatus, errorThrown) {
//                     Swal.fire({
//                         title: res.mensaje,
//                         icon: res.icono
//                     }).then(() => location.reload());
//                 });
//         }
//     });
// });
