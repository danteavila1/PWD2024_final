function mostrarPass(show) {
    // Selecciono la contraseña
    const pass = document.getElementById("uspass");
    const pass2 = document.getElementById("uspassAlta");
    const icon = document.getElementById("toggleIcon");

    if (pass !== "") {
        pass.type = show ? "text" : "password";
        icon.className = show ? "bi bi-eye" : "bi bi-eye-slash";
    }

    if (pass2 !== "") {
        pass2.type = show ? "text" : "password";
        icon.className = show ? "bi bi-eye" : "bi bi-eye-slash";
    }

}