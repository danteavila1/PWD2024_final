<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alta usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/encriptar.js"></script>
</head>
<?php
include_once('../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Creo instancia del objeto AbmRol y guardo colección de roles
$objRol = new AbmRol();
$colRoles = $objRol->buscar("");

?>

<body>
    <h3>Iniciado como <?php echo $_SESSION['usnombre'] ?> </h3>
    <form id="form" name="form" method="post" onsubmit="encriptar()" action="accion/altaUsuario.php">
        <h3>Añadir usuario nuevo</h3>
        <label for="usnombre">Nombre usuario</label>
        <input type="text" class="form-control" id="usnombre" name="usnombre">

        <label for="usmail">Email</label>
        <input type="text" class="form-control" id="usmail" name="usmail">

        <label for="uspass">Contraseña</label>
        <div class="input-group">
            <input type="password" class="form-control" id="uspass" name="uspass">
            <button type="button" class="btn btn-secondary" onmousedown="mostrarPass(true)" onmouseup="mostrarPass(false)" onmouseleave="mostrarPass(false)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                </svg>
            </button>
        </div>

        <h5>Rol/es</h5>
        <?php foreach ($colRoles as $rol) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="idrol[]" value="<?php echo $rol->getIdRol(); ?>" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    <?php echo $rol->getRolDescripcion(); ?>
                </label>
            </div>
        <?php endforeach ?>

        <input type="submit" class="btn btn-success" value="Confirmar">
        <a href="listarUsuario.php">
            <input type="button" class="btn btn-primary" value="Cancelar">
        </a>
    </form>
</body>
<script src="../js/md5.js"></script>
<script src="../js/verPass.js"></script>

</html>