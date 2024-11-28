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
    $("#form").validate({
        rules: {
            usnombreModif: {
                soloLetras: true,
                maxlength: 50,
                required: true
            },
            usmailModif: {
                mailValido: true,
                maxlength: 50,
                required: true
            }
        },
        //Mensajes de error
        messages: {
            usnombreModif: {
                soloLetras: "<p class='text-danger'>Solo se permiten letras</p>",
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
                required: "<p class='text-danger'>Campo obligatorio</p>",
            },
            usmailModif: {
                mailValido: "<p class='text-danger'>Ingrese un mail válido. Formato 'example@example.example'</p>",
                maxlength: "<p class='text-danger'>Máximo 50 caracteres</p>",
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

        // Verifico si los inputs son válidos antes de mandarlos
        if ($("#form").valid()) {
            // Construyo objeto para mandar a solicitud AJAX
            var formData = {
                idusuario: $('#idusuarioModif').val(),
                usnombre: $('#usnombreModif').val(),
                usmail: $('#usmailModif').val()
            };

            // Obtengo valor de la contraseña
            var uspass = $('#uspass').val();
            if (uspass !== "") {
                formData.uspass = hex_md5(uspass);
            }

            $.ajax({
                url: "accion/modificarUsuario.php",
                type: "POST",
                dataType: "json",
                data: formData,
                success: function (res) {
                    if (res.mensaje === 'Nombre de usuario existente' || res.mensaje === 'Mail existente') {
                        Swal.fire({
                            title: res.mensaje,
                            icon: res.icono,
                            confirmButtonText: 'OK'
                        }).then(() => $('#modificarUsuario').modal('show'));
                    } else {
                        Swal.fire({
                            title: res.mensaje,
                            icon: res.icono
                        }).then(() => location.reload());
                        $('#modificarUsuario').modal('hide');
                    }
                },
                error: function () {
                    // console.log("Error en la solicitud Ajax:", textStatus, errorThrown);
                    // console.log("Detalles del error:", jqXHR.responseText);
                    Swal.fire({
                        title: "Modificación fallida",
                        icon: "error"
                    }).then(() => location.reload());
                }
            });
        }
    });
});
