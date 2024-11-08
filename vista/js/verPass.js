function mostrarPass(show) {
    // Selecciono la contraseña
    const uspass = document.getElementById("uspass");
    // Realizo condición ternaria para modificar el estado de visualización
    uspass.type = show ? "text" : "password";
}