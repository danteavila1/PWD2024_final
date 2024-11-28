document.addEventListener("DOMContentLoaded", () => {
    var location = window.location.href;
    var ruta = location.substring(0,location.indexOf("vista")+5);
    //const rol = this.value;
    var selector = document.getElementById('roles');
    if (selector){
    var rolsel = selector.value;
    fetch(ruta+`/menu_dinamico.php?rol=${rolsel}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("menu").innerHTML = data;
            document.getElementById('roles').value = rolsel;
        })
        .catch(error => {
            console.error("Error al cargar el menú:", error);
            document.getElementById("menu").innerHTML = `
                <div class="alert alert-danger">Error al cargar el menú. Intente nuevamente más tarde.</div>
            `;
        });
    } else {
        fetch(ruta+`/menu_dinamico.php`)
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
    }
});

function cambiaSel(){
    var location = window.location.href;
    var ruta = location.substring(0,location.indexOf("vista")+5);
    var selector = document.getElementById('roles');
    if (selector){
    var rol = selector.value;
    fetch(ruta+`/menu_dinamico.php?rol=${rol}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("menu").innerHTML = data;
            document.getElementById('roles').value = rol;
        })
        .catch(error => {
            console.error("Error al cargar el menú:", error);
            document.getElementById("menu").innerHTML = `
                <div class="alert alert-danger">Error al cargar el menú. Intente nuevamente más tarde.</div>
            `;
        });
    } else {
        fetch(ruta+`/menu_dinamico.php`)
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
    }

}
/*document.getElementById('roles').addEventListener('change', function () {
    var location = window.location.href;
    var ruta = location.substring(0,location.indexOf("vista")+5);
    const rol = this.value;
    console.log('rol '+rol);
    fetch(ruta+`/menu_dinamico.php?rol=${rol}`)
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
//})
});*/
