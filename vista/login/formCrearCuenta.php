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
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
        <form id="form" name="form" method="post" onsubmit="encriptar()" action="accion/crearCuenta.php">
            <h3 class="text-center mb-4">Crear cuenta</h3>

            <div class="mb-3">
                <label for="usnombre" class="form-label">Nombre usuario</label>
                <input type="text" class="form-control" id="usnombre" name="usnombre">
            </div>

            <div class="mb-3">
                <label for="usmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="usmail" name="usmail">
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

            <div class="d-grid mb-2">
                <input type="submit" class="btn btn-success" value="Confirmar">
            </div>

            <div class="d-grid">
                <a href="formIniciarSesion.php" class="btn btn-secondary text-center">Volver</a>
            </div>
        </form>
    </div>
</div>


<script src="../js/md5.js"></script>
<script src="../js/verPass.js"></script>

<?php
include_once(ROOT_PATH . "vista/estructura/footer.php");
