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
    $("#formModificar").validate({
        rules: {
            nombreModif: {
                maxlength: 50,
                required: true
            },
            detalleModif: {
                maxlength: 50,
                required: true
            },
            cantStockModif: {
                maxlength: 50,
                soloNumeros: true,
                required: true
            },
            precioModif: {
                maxlength: 50,
                numerosPuntos: true,
                required: true
            },
            nuevaImagen: {
                formatoArchivo: ["jpg", "jpeg", "png"],
            }
        },
        //Mensajes de error
        messages: {
            nombreModif: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            detalleModif: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            cantStockModif: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                soloNumeros: "<p class-'text-danger'>Ingrese solo números</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            precioModif: {
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                numerosPuntos: "<p class-'text-danger'>Solo se permiten números y un punto</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            nuevaImagen: {
                formatoArchivo: "<p class='text-danger'>Solo se permiten formatos jpg, jpeg y png</p>",
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

$(document).on('click', '.modificarProducto', function () {


    var idproducto = $(this).data('idproducto');
    var nombre = $(this).data('nombre');
    var detalle = $(this).data('detalle');
    var cantStock = $(this).data('cantstock');
    var precio = $(this).data('precio');
    var imagen = $(this).data('imagen');

    $('#idproductoModif').val(idproducto);
    $('#nombreModif').val(nombre);
    $('#detalleModif').val(detalle);
    $('#cantStockModif').val(cantStock);
    $('#precioModif').val(precio);
    $('#imagenModif').attr('src', '../images/' + imagen);

    // Asigna la ruta de la imagen actual al campo oculto
    $('#imagenActual').val(imagen);

    $('#modificarProducto').modal('show');
    $('#modificarProducto .btn-success').off('click').on('click', function () {
        // Verifico si los inputs son válidos antes de mandarlos
        if ($("#formModificar").valid()) {
            var formData = new FormData();
            formData.append('idproducto', $('#idproductoModif').val());
            formData.append('pronombre', $('#nombreModif').val());
            formData.append('prodetalle', $('#detalleModif').val());
            formData.append('procantstock', $('#cantStockModif').val());
            formData.append('proprecio', $('#precioModif').val());

            // Verifica si se seleccionó una nueva imagen
            var nuevaImagen = $('#nuevaImagen')[0].files[0];
            if (nuevaImagen) {
                formData.append('proimagen', nuevaImagen);
            } else {
                // Si no hay nueva imagen, manda la imagen actual
                formData.append('proimagen', $('#imagenActual').val());
            }

            $.ajax({
                url: "accion/modificarProducto.php",
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
                    $('#modificarProducto').modal('hide');
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
