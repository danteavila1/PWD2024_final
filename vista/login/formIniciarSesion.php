<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


    <!-- Librerías -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-icons-1.10.5/font/bootstrap-icons.min.css">
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>

    <script src="../js/encriptar.js"></script>
    <title>Iniciar sesión</title>
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
include_once('../../configuracion.php');

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
    <form id="form" name="form" method="post" onsubmit="encriptar()" action="./accion/iniciarSesion.php">
        <h3>Iniciar sesión</h3>
        <label class for="usnombre">Nombre de usuario</label>
        <input type="text" class="form-control" id="usnombre" name="usnombre">

        <label for="uspass">Contraseña</label>
        <div class="input-group">
            <input type="password" class="form-control" id="uspass" name="uspass">
            <button type="button" class="btn btn-secondary"
                onmousedown="mostrarPass(true)"
                onmouseup="mostrarPass(false)"
                onmouseleave="mostrarPass(false)">
                <i id="toggleIcon" class="bi bi-eye-slash"></i>
            </button>
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
    <p>¿No estás registrado? <a href="formCrearCuenta.php">Crear cuenta</a></p>
</body>
<script src="../js/md5.js"></script>
<script src="../js/verPass.js"></script>

</html>