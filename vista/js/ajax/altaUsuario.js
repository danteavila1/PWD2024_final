// Método personalizado para verificar que el input solo permita ingresar letras
$.validator.addMethod("soloLetras", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
});

// Método personalizado para verificar que el input solo permita un mail válido
$.validator.addMethod("mailValido", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value);
});

// Valido los campos
$(document).ready(function () {
    $("#formAlta").validate({
        rules: {
            usnombreAlta: {
                soloLetras: true,
                maxlength: 50,
                required: true
            },
            usmailAlta: {
                mailValido: true,
                maxlength: 50,
                required: true
            },
            uspassAlta: {
                maxlength: 20,
                required: true
            },
            'idrol[]': {
                required: function () {
                    return $('input[name="idrol[]"]:checked').length === 0;
                }
            }
        },
        //Mensajes de error
        messages: {
            usnombreAlta: {
                soloLetras: "<p class='text-danger'>Solo se permiten letras</p>",
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            usmailAlta: {
                mailValido: "<p class='text-danger'>Ingrese un mail válido. Formato 'example@example.example'</p>",
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            uspassAlta: {
                maxlength: "<p class='text-danger'>Máximo 20 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            'idrol[]': {
                required: "<p class='text-danger'>Seleccione al menos uno</p>",
            }
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
        },

        // Estilos de validación para los roles
        highlight: function (element) {
            if ($(element).attr("name") === "idrol[]") {
                $(element).closest('.mb-1').addClass('is-invalid').removeClass("is-valid");
            } else {
                $(element).addClass('is-invalid').removeClass("is-valid");
            }
        },
        unhighlight: function (element) {
            if ($(element).attr("name") === "idrol[]") {
                $(element).closest('.mb-1').removeClass('is-invalid').addClass("is-valid");
            } else {
                $(element).removeClass('is-invalid').addClass("is-valid");
            }
        },
        errorPlacement: function (error, element) {
            if ($(element).attr("name") === "idrol[]") {
                error.appendTo(element.closest('.mb-1').find('.mensaje-error'));
            } else {
                error.appendTo(element.closest('.mb-1').find('.mensaje-error'));
            }
        }
    });
});

$(document).on('click', '.altaUsuario', function () {
    // Limpio los campos al abrir el modal (en caso de que antes se hayan manipulado sin confirmar el envío)
    $('#formAlta')[0].reset();
    $('#formAlta').find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
    $('#formAlta').find('input').css('border-color', '');
    $('#formAlta').find('.mensaje-error').empty();

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

        // Verifico si los inputs son válidos antes de mandarlos
        if ($("#formAlta").valid()) {
            // Construyo objeto para mandar a solicitud AJAX
            var formData = {
                'usnombre': usnombre,
                'usmail': usmail,
                'uspass': uspass,
                'idrol': roles
            };
            console.log(formData)

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
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                    console.log("Detalles del error:", jqXHR.responseText);
                    Swal.fire({
                        title: 'Error en el servidor',
                        icon: 'error'
                    });
                }
            });
        }
    });
});
