$(document).on('click', '.modificarRoles', function () {
    var idusuario = $(this).data('idusuario');
    var rolesActuales = $(this).data('roles');
    var rolesExistentes = $(this).data('colroles');

    // Limpio y recreo los checkboxes de roles
    var rolesContainer = $("#modificarRoles .modal-body .form-check").parent();
    rolesContainer.empty(); // Elimina los checkboxes anteriores

    rolesExistentes.forEach(function (rol) {
        // Verifico si el rol actual está en los roles del usuario
        var checked = rolesActuales.includes(rol.idrol) ? 'checked' : '';

        // Creo el HTML para el checkbox
        var checkboxHtml = `
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="idrol[]" value="${rol.idrol}" ${checked}>
                <label class="form-check-label">${rol.rodescripcion}</label>
            </div>`;

        // Añado el checkbox al contenedor
        rolesContainer.append(checkboxHtml);
    });

    $('#modificarRoles').modal('show');
    $('#modificarRoles .btn-success').off('click').on('click', function () {
        // Obtengo los IDs de los roles seleccionados
        var nuevosRoles = $("input[name='idrol[]']:checked").map(function () {
            // Devuelvo solo los IDs
            return $(this).val();
        }).get();

        // Verifica si se seleccionó al menos un rol
        if (nuevosRoles.length === 0) {
            Swal.fire({
                title: "Error",
                text: "Seleccione al menos un rol",
                icon: "error"
            });
            return;
        }

        // Construyo objeto para mandar a solicitud AJAX
        var formData = {
            'idusuario': idusuario,
            'idrol': nuevosRoles
        }

        $.ajax({
            url: "accion/modificarRoles.php",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (res) {
                Swal.fire({
                    title: res.mensaje,
                    icon: res.icono
                }).then(() => location.reload());
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

        // Cierra el modal
        $('#modificarRoles').modal('hide');
    });
});
