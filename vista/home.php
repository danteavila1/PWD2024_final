<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Dinámico</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Bienvenido al sistema</h3>
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h4>Menú Principal</h4>
            </div>
            <div class="card-body">
                <div id="menu">
                    <p class="text-center text-muted">Cargando menú...</p>
                </div>
            </div>
            <div class="card-footer">
                <a href="./login/accion/cerrarSesion.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </div>
    <script src="./js/menu.js"></script>
</body>
</html>

