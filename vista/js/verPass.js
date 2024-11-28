function mostrarPass(show) {
    // Selecciono todos los posibles elementos que contengan contraseña
    var pass = document.getElementById("uspass");
    var pass2 = document.getElementById("uspassAlta");
    var icon = document.getElementById("toggleIcon");

    // Verifico si 'pass' existe
    if (pass) {
        if (pass.value != "") {
            pass.type = show ? "text" : "password";
        }
    }

    // Verifico si 'pass2' existe
    if (pass2) {
        if (pass2.value != "") {
            pass2.type = show ? "text" : "password";
        }
    }

    // Verifico si 'icon' existe
    if (icon) {
        icon.className = show ? "bi bi-eye" : "bi bi-eye-slash";
    }
}
