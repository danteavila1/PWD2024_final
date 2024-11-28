// Método personalizado para verificar que el input solo permita ingresar letras
$.validator.addMethod("soloLetras", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
});

// Valido los campos
$(document).ready(function () {
    $("#formAlta").validate({
        rules: {
            rodescripcion: {
                soloLetras: true,
                maxlength: 50,
                required: true
            },
        },
        //Mensajes de error
        messages: {
            rodescripcion: {
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

$(document).on('click', '.altaRol', function () {
    // Limpio los campos al abrir el modal (en caso de que antes se hayan manipulado sin confirmar el envío)
    $('#formAlta')[0].reset();
    $('#formAlta').find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
    $('#formAlta').find('input').css('border-color', '');
    $('#formAlta').find('.mensaje-error').empty();

    $('#altaRol').modal('show');
    $('#altaRol .btn-success').off('click').on('click', function () {

        // Obtengo el valor del input
        var rodescripcion = $('#rodescripcion').val();

        // Verifico si los inputs son válidos antes de mandarlos
        if ($("#formAlta").valid()) {
            // Construyo objeto para mandar a solicitud AJAX
            var formData = {
                'rodescripcion': rodescripcion,
            };

            $.ajax({
                url: "accion/altaRol.php",
                type: "POST",
                dataType: "json",
                data: formData,

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
        }
    });
});