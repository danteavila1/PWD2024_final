$(document).on('click', '.altaUsuario', function () {
    // Limpio los campos al abrir el modal (en caso de que antes se hayan manipulado sin confirmar el envío)
    $('#usnombreAlta').val('');
    $('#usmailAlta').val('');
    $('#uspassAlta').val('');
    $('input[name="idrol[]"]').prop('checked', false);

    $('#altaUsuario').modal('show');
    $('#altaUsuario .btn-success').off('click').on('click', function () {

        // Obtengo valor de los inputs 
        var usnombre = $('#usnombreAlta').val();
        var usmail = $('#usmailAlta').val();
        var passencriptada = hex_md5($('#uspassAlta').val());
        var uspass = passencriptada;

        // Obtengo los roles seleccionados
        var roles = [];
        $('input[name="idrol[]"]:checked').each(function () {
            roles.push($(this).val());
        });

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'usnombre': usnombre,
            'usmail': usmail,
            'uspass': uspass,
            'idrol': roles
        };

        $.ajax({
            url: "accion/altaUsuario.php",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (res) {
                if (res.mensaje === "Nombre de usuario en uso" || res.mensaje === "Mail en uso") {
                    // Muestro alerta sin cerrar el modal
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#altaUsuario').modal('show');
                    });
                } else {
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                    $('#altaUsuario').modal('hide');
                }
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
        $('#altaUsuario').modal('hide');
    });
});
