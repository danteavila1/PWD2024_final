// Método personalizado para verificar que el input solo permita ingresar letras
$.validator.addMethod("soloLetras", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
});

// Valido los campos
$(document).ready(function () {
    $("#formAlta").validate({
        rules: {
            menombre: {
                soloLetras: true,
                maxlength: 50,
                required: true
            },
            medescripcion: {
                soloLetras: true,
                maxlength: 120,
                required: true
            },
            melink: {
                required: true
            }
        },
        //Mensajes de error
        messages: {
            menombre: {
                soloLetras: "<p class='text-danger'>Solo se permiten letras</p>",
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            menombre: {
                soloLetras: "<p class='text-danger'>Solo se permiten letras</p>",
                maxlength: "<p class='text-danger'>Máximo 120 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            melink: {
                required: "<p class='text-danger'>Campo obligatorio</p>",
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
        }
    });
});

$(document).on('click', '.altaMenu', function () {
    // Limpio los campos al abrir el modal (en caso de que antes se hayan manipulado sin confirmar el envío)
    $('#formAlta')[0].reset();
    $('#formAlta').find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
    $('#formAlta').find('input').css('border-color', '');
    $('#formAlta').find('.mensaje-error').empty();

    $('#altaMenu').modal('show');
    $('#altaMenu .btn-success').off('click').on('click', function () {

        // Obtengo el valor de los inputs
        var menombre = $('#menombre').val();
        var medescripcion = $('#medescripcion').val();
        var melink = $('#melink').val();
        var medeshabilitado = null;

        // Verifico si los inputs son válidos antes de mandarlos
        if ($("#formAlta").valid()) {
            // Construyo objeto para mandar a solicitud AJAX
            var formData = {
                'menombre': menombre,
                'medescripcion': medescripcion,
                'melink': melink,
                'medeshabilitado': medeshabilitado
            };

            $.ajax({
                url: "accion/altaMenu.php",
                type: "POST",
                dataType: "json",
                data: formData,

                success: function (res) {
                    // Mostrar el mensaje de éxito o error y recargar la página
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                    // Cierro modal después recargar la página
                    $('#altaMenu').modal('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                    console.log("Detalles del error:", jqXHR.responseText);
                    Swal.fire({
                        title: 'Error en el servidor',
                        icon: 'error'
                    }).then(() => location.reload());
                }
            })
        }
    });
});