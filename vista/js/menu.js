document.addEventListener("DOMContentLoaded", () => {
    fetch("menu_dinamico.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("menu").innerHTML = data;
        })
        .catch(error => {
            console.error("Error al cargar el menú:", error);
        });
});