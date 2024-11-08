<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listar usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php
include_once('../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

// Recibo los datos del formulario
$datos = data_submitted();

// Creo instancia del objeto AbmUsuario para listar sus datos
$objUsuario = new AbmUsuario();
$colUsuarios = $objUsuario->buscar($datos);

// Creo instancia del objeto AbmUsuarioRol para listar sus roles
$objUsuarioRol = new AbmUsuarioRol();
$colUsuarioRol = $objUsuarioRol->buscar($datos);

// Creamos array para guardar los roles que actualmente tiene el usuario
$tieneRol = [];
foreach ($colUsuarioRol as $rol) {
    $idRol = $rol->getObjRol()->getIdRol();
    $tieneRol[] = $idRol;
}

// Creo instancia de AbmRol y listo todos los roles existentes en la base de datos
$objRol = new AbmRol();
$colRoles = $objRol->buscar("");

// Creamos array para guardar todos los roles de la base de datos
$rolesExistentes = [];
foreach ($colRoles as $rol) {
    $idRol = $rol->getIdRol();
    $rolesExistentes[] = $idRol;
}

?>

<body>
    <h3>Iniciado como <?php echo $_SESSION['usnombre'] ?> </h3>
    <form id="form" name="form" method="post" action="accion/modificarRoles.php">
        <h3>Modificar roles</h3>

        <h5>Datos del usuario seleccionado</h5>
        <label for="usnombre">ID usuario</label>
        <input type="text" class="form-control" id="idusuario" name="idusuario" value="<?php echo $colUsuarios[0]->getIdUsuario() ?>" readonly>
        <label for="usnombre">Nombre usuario</label>
        <input type="text" class="form-control" id="usnombre" name="usnombre" value="<?php echo $colUsuarios[0]->getUsNombre() ?>" readonly>

        <h5>Rol/es actuales</h5>
        <?php foreach ($colRoles as $rol) : ?>
            <?php $check = ""; ?>
            <?php foreach ($tieneRol as $tiene) {
                if ($rol->getIdRol() == $tiene) {
                    $check = "checked";
                }
            }
            ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="idrol[]" value="<?php echo $rol->getIdRol(); ?>" id="flexCheckDefault" <?php echo $check; ?>>
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

</html>