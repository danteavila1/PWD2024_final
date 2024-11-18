document.addEventListener("DOMContentLoaded", () => {
    var location = window.location.href;
    var ruta = location.substring(0,location.indexOf("vista")+5);

    fetch(ruta+"/menu_dinamico.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("menu").innerHTML = data;
        })
        .catch(error => {
            console.error("Error al cargar el menú:", error);
            document.getElementById("menu").innerHTML = `
                <div class="alert alert-danger">Error al cargar el menú. Intente nuevamente más tarde.</div>
            `;
        });
});
