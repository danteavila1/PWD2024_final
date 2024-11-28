// Método personalizado para verificar que el input solo permita ingresar letras
$.validator.addMethod("soloLetras", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
});

$(document).ready(function () {
    // Inicializar validación
    $("#formIniciarSesion").validate({
        rules: {
            usnombre: {
                soloLetras: true,
                maxlength: 50,
                required: true
            },
            uspass: {
                maxlength: 50,
                required: true
            }
        },
        messages: {
            usnombre: {
                soloLetras: "<p class='text-danger'>Solo se permiten letras</p>",
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>"
            },
            uspass: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>"
            }
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.closest('.mb-1').find('.mensaje-error'));
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    // Validar antes de enviar
    $("#formIniciarSesion").on("submit", function (e) {
        if (!$(this).valid()) {
            e.preventDefault(); // Evita el envío si no es válido
        }
    });
});
