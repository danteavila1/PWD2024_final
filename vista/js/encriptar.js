function encriptar() {
    var uspass = document.getElementById("uspass");
    var passencriptada = hex_md5(uspass.value);
    uspass.value = passencriptada;
}
