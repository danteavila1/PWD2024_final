<?php
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/headerInseguro.php");

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
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
        <form id="form" name="form" method="post" onsubmit="encriptar()" action="./accion/iniciarSesion.php">
            <h3 class="text-center mb-4">Iniciar sesión</h3>

            <div class="mb-3">
                <label for="usnombre" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="usnombre" name="usnombre">
            </div>

            <div class="mb-3">
                <label for="uspass" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="uspass" name="uspass">
                    <button type="button" class="btn btn-outline-secondary"
                        onmousedown="mostrarPass(true)"
                        onmouseup="mostrarPass(false)"
                        onmouseleave="mostrarPass(false)">
                        <i id="toggleIcon" class="bi bi-eye-slash"></i>
                    </button>
                </div>
            </div>

            <div class="d-grid">
                <input type="submit" class="btn btn-success" value="Enviar">
            </div>
        </form>
        <p class="text-center mt-3">¿No estás registrado?
            <a href="formCrearCuenta.php" class="text-decoration-none">Crear cuenta</a>
        </p>
    </div>
</div>


<script src="../js/md5.js"></script>
<script src="../js/verPass.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
