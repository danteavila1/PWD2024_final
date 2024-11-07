<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../util/encriptar.js"></script>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <title>Crear cuenta</title>
</head>
<?php
// Este paso es para mostrar notificación de SweetAlert en caso de haber realizado alguna acción
if (isset($_COOKIE['mensaje'])) {
    $mensaje = $_COOKIE['mensaje'];
    $icono = $_COOKIE['icono'];

    // Borro dichos datos para que no se muestren al recargar la página
    setcookie("mensaje", "", time() - 3600, "/");
    setcookie("icono", "", time() - 3600, "/");
}
?>

<body>
    <?php if (isset($mensaje)) : ?>
        <script>
            // Mostrar notificación de SweetAlert
            Swal.fire({
                title: "<?php echo $mensaje ?>",
                icon: "<?php echo $icono ?>"
            });
        </script>
    <?php endif; ?>
    <form id="form" name="form" method="post" onsubmit="encriptar()" action="accion/crearCuenta.php">
        <h3>Crear cuenta</h3>
        <label for="usnombre">Nombre usuario</label>
        <input type="text" class="form-control" id="usnombre" name="usnombre">

        <label for="usmail">Email</label>
        <input type="text" class="form-control" id="usmail" name="usmail">

        <label for="uspass">Contraseña</label>
        <input type="password" class="form-control" id="uspass" name="uspass">

        <input type="submit" class="btn btn-success" value="Confirmar">
        <a href="formIniciarSesion.php">
            <input type="button" class="btn btn-primary" value="Volver">
        </a>
    </form>
</body>
<script src="../../util/md5.js"></script>

</html>