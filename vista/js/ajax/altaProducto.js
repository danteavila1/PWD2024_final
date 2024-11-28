// Método personalizado para verificar que el input solo permita ingresar números
$.validator.addMethod("soloNumeros", function (value, element) {
    return this.optional(element) || /^[0-9]+$/.test(value);
});

// Método personalizado para verificar que el input solo permita ingresar números y un punto
$.validator.addMethod("numerosPuntos", function (value, element) {
    return this.optional(element) || /^[0-9.]+$/.test(value);
});

// Método personalizado para verificar formatos de archivo
$.validator.addMethod("formatoArchivo", function (value, element, formatosPermitidos) {
    if (value) {
        // Obtengo la extensión del archivo
        var extension = value.split('.').pop().toLowerCase();
        // Verifico si la extensión está permitida
        return formatosPermitidos.includes(extension);
    }
    return true; // Si no hay archivo, no valido
});

// Valido los campos
$(document).ready(function () {
    $("#formAlta").validate({
        rules: {
            nombreAlta: {
                maxlength: 50,
                required: true
            },
            detalleAlta: {
                maxlength: 50,
                required: true
            },
            cantStockAlta: {
                maxlength: 50,
                soloNumeros: true,
                required: true
            },
            precioAlta: {
                maxlength: 50,
                numerosPuntos: true,
                required: true
            },
            proimagen: {
                formatoArchivo: ["jpg", "jpeg", "png"],
                required: true
            },
        },
        //Mensajes de error
        messages: {
            nombreAlta: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            detalleAlta: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            cantStockAlta: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                soloNumeros: "<p class-'text-danger'>Ingrese solo números</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            precioAlta: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                numerosPuntos: "<p class-'text-danger'>Solo se permiten números y un punto</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            proimagen: {
                formatoArchivo: "<p class='text-danger'>Solo se permiten formatos jpg, jpeg y png</p>",
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

$(document).on('click', '.altaProducto', function () {
    // Limpio los campos al abrir el modal (en caso de que antes se hayan manipulado sin confirmar el envío)
    $('#formAlta')[0].reset();
    $('#formAlta').find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
    $('#formAlta').find('input').css('border-color', '');
    $('#formAlta').find('.mensaje-error').empty();

    $('#altaProducto').modal('show');
    $('#altaProducto .btn-success').off('click').on('click', function () {

        // Verifico si los inputs son válidos antes de mandarlos
        if ($("#formAlta").valid()) {
            // Construyo objeto FormData para enviar datos y archivo
            var formData = new FormData();
            formData.append('pronombre', $('#nombreAlta').val());
            formData.append('prodetalle', $('#detalleAlta').val());
            formData.append('procantstock', $('#cantStockAlta').val());
            formData.append('proprecio', $('#precioAlta').val());

            // Verifico si se seleccionó un archivo
            var nuevaImagen = $('#proimagen')[0].files[0];
            if (nuevaImagen) {
                formData.append('proimagen', nuevaImagen);
            }

            $.ajax({
                url: "accion/altaProducto.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                    $('#altaProducto').modal('hide');
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
        };
    });
});

