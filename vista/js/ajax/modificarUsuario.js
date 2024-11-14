$(document).on('click', '.modificarUsuario', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idusuario = $(this).data('idusuario');
    var usnombre = $(this).data('usnombre');
    var usmail = $(this).data('usmail');

    // Preparo los valores para mostrarlos en el modal
    $('#idusuarioModif').val(idusuario);
    $('#usnombreModif').val(usnombre);
    $('#usmailModif').val(usmail);

    // Vacío campo de contraseña en caso de que se haya manipulado antes 
    // y no se haya enviado la modificación de usuario
    $('#uspass').val('');

    $('#modificarUsuario').modal('show');
    $('#modificarUsuario .btn-success').off('click').on('click', function () {

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idusuario': idusuario,
            'usnombre': $('#usnombreModif').val(),
            'usmail': $('#usmailModif').val()
        };

        // Obtengo el valor de la contraseña
        var uspass = $('#uspass').val();

        // Solo agregamos uspass a formData si tiene un valor (no está vacío)
        if (uspass !== "") {
            var passencriptada = hex_md5(uspass);
            var uspass = passencriptada;
            formData.uspass = uspass;
        }

        $.ajax({
            url: "accion/modificarUsuario.php",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (res) {
                if (res.mensaje === 'Nombre de usuario existente' || res.mensaje === 'Mail existente') {
                    // Muestro alerta sin cerrar el modal
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#modificarUsuario').modal('show');
                    });
                } else {
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                    $('#modificarUsuario').modal('hide');
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
        $('#modificarUsuario').modal('hide');
    });
});
