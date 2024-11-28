// Método personalizado para verificar que el input solo permita ingresar letras, incluyendo ñ y tildes
$.validator.addMethod("soloLetras", function (value, element) {
    return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value);
});

// Valido los campos
$(document).ready(function () {
    $("#formModificar").validate({
        rules: {
            nombreModif: {
                soloLetras: true,
                maxlength: 50,
                required: true
            },
            descripcionModif: {
                soloLetras: true,
                maxlength: 120,
                required: true
            },
            linkModif: {
                required: true
            }
        },
        //Mensajes de error
        messages: {
            nombreModif: {
                soloLetras: "<p class='text-danger'>Solo se permiten letras</p>",
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            descripcionModif: {
                soloLetras: "<p class='text-danger'>Solo se permiten letras</p>",
                maxlength: "<p class='text-danger'>Máximo 120 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            linkModif: {
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

$(document).on('click', '.modificarMenu', function () {
    // Quito los estilos de las validaciones
    $('#formModificar').find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
    $('#formModificar').find('input').css('border-color', '');
    $('#formModificar').find('.mensaje-error').empty();

    // Pongo en variables los datos que traje al apretar el botón
    var idmenuModif = $(this).data('idmenu');
    var nombreModif = $(this).data('menombre');
    var descripcionModif = $(this).data('medescripcion');
    var linkModif = $(this).data('melink');

    // Preparo los valores para mostrarlos en el modal
    $('#idmenuModif').val(idmenuModif);
    $('#nombreModif').val(nombreModif);
    $('#descripcionModif').val(descripcionModif);
    $('#linkModif').val(linkModif);

    $('#modificarMenu').modal('show');
    $('#modificarMenu .btn-success').off('click').on('click', function () {
        // Verifico si los inputs son válidos antes de mandarlos
        if ($("#formModificar").valid()) {
            // Construyo objeto para mandar a solicitud AJAX
            var formData = {
                idmenu: $('#idmenuModif').val(),
                menombre: $('#nombreModif').val(),
                medescripcion: $('#descripcionModif').val(),
                melink: $('#linkModif').val(),
                medeshabilitado: '0000-00-00 00:00:00'
            }

            $.ajax({
                url: "accion/modificarMenu.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    Swal.fire({
                        title: res.mensaje,
                        icon: res.icono
                    }).then(() => location.reload());
                    $('#modificarMenu').modal('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                    // console.log("Detalles del error:", jqXHR.responseText);
                    Swal.fire({
                        title: 'Error en el servidor',
                        icon: 'error'
                    }).then(() => location.reload());
                }
            });
        }
    });
});
