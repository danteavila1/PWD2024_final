// Método personalizado para verificar que el input solo permita ingresar letras
$.validator.addMethod("soloLetras", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
});

// Valido los campos
$(document).ready(function () {
    $("#form").validate({
        rules: {
            rodescripcionModif: {
                soloLetras: true,
                maxlength: 50,
                required: true
            },
        },
        //Mensajes de error
        messages: {
            rodescripcionModif: {
                soloLetras: "<p class='text-danger'>Solo se permiten letras</p>",
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
            $(element).removeClass("is-valid");
            $(element).css("border-color", "red");
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid');
            $(element).removeClass("is-invalid");
            $(element).css("border-color", "");
        },
        errorPlacement: function (error, element) {
            // Inserta el mensaje de error en el contenedor .mensaje-error
            error.appendTo(element.closest('.mb-1').find('.mensaje-error'));
        }
    });
});

$(document).on('click', '.modificarRol', function () {

    // Pongo en variables los datos que traje al apretar el botón
    var idrol = $(this).data('idrol');
    var rodescripcion = $(this).data('rodescripcion');

    // Preparo los valores para mostrarlos en el modal
    $('#idrolModif').val(idrol);
    $('#rodescripcionModif').val(rodescripcion);

    $('#modificarRol').modal('show');
    $('#modificarRol .btn-success').off('click').on('click', function () {
        // Verifico si los inputs son válidos antes de mandarlos
        if ($("#form").valid()) {
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
        }
    });
});
