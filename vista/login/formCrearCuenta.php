<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");

// Este paso es para mostrar notificación de SweetAlert en caso de haber realizado alguna acción
if (isset($_COOKIE['mensaje'])) {
    $mensaje = $_COOKIE['mensaje'];
    $icono = $_COOKIE['icono'];

    // Borro dichos datos para que no se muestren al recargar la página
    setcookie("mensaje", "", time() - 3600, "/");
    setcookie("icono", "", time() - 3600, "/");
}

?>
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
    <div class="input-group">
        <input type="password" class="form-control" id="uspass" name="uspass">
        <button type="button" class="btn btn-secondary"
            onmousedown="mostrarPass(true)"
            onmouseup="mostrarPass(false)"
            onmouseleave="mostrarPass(false)">
            <i id="toggleIcon" class="bi bi-eye-slash"></i>
        </button>
    </div>

    <input type="submit" class="btn btn-success" value="Confirmar">
    <a href="formIniciarSesion.php">
        <input type="button" class="btn btn-secondary" value="Volver">
    </a>
</form>

<script src="../js/md5.js"></script>
<script src="../js/verPass.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
