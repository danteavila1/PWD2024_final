<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alta usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../util/encriptar.js"></script>
</head>
<?php
include_once('../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

?>

<body>
    <h3>Iniciado como <?php echo $_SESSION['usnombre'] ?> </h3>
    <form id="form" name="form" method="post" onsubmit="encriptar()" action="accion/altaUsuario.php">
        <h3>Añadir usuario nuevo</h3>
        <label for="usnombre">Nombre usuario</label>
        <input type="text" class="form-control" id="usnombre" name="usnombre">

        <label for="uspass">Contraseña</label>
        <input type="password" class="form-control" id="uspass" name="uspass">

        <label for="usmail">Email</label>
        <input type="text" class="form-control" id="usmail" name="usmail">

        <div class="form-check">
            <h5>Rol/es</h5>
            <input class="form-check-input" type="checkbox" name="idrol[]" value="2" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Usuario
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="idrol[]" value="1" id="flexCheckChecked">
            <label class="form-check-label" for="flexCheckChecked">
                Admin
            </label>
        </div>

        <input type="submit" class="btn btn-success" value="Confirmar">
        <a href="listarUsuario.php">
            <input type="button" class="btn btn-primary" value="Cancelar">
        </a>
    </form>
</body>
<script src="../util/md5.js"></script>

</html>