
function encriptar() {
    var uspass = document.getElementById("uspass"); // Cambia a "uspass"
    var passencriptada = hex_md5(uspass.value); // Encriptar la contraseña
    uspass.value = passencriptada; // Reemplazar el valor del campo por el encriptado
}
