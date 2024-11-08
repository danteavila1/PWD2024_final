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

// Creamos array para guardar los roles del usuario
$colRoles = [];

// Recorremos todos los roles del usuario
foreach ($colUsuarioRol as $rol) {
    $roldescripcion = $rol->getObjRol()->getRolDescripcion();
    $colRoles[] = $roldescripcion;
}

$esUsuario = "";
$esAdmin = "";

foreach ($colRoles as $rol) {
    if ($rol == "usuario") {
        $esUsuario = "checked";
    }
    if ($rol == "admin") {
        $esAdmin = "checked";
    }
}

?>

<body>
    <h3>Iniciado como <?php echo $_SESSION['usnombre'] ?> </h3>
    <form id="form" name="form" method="post" action="accion/modificacionUsuario.php">
        <h3>Modificar datos</h3>

        <label for="idusuario">ID usuario</label>
        <input type="text" class="form-control" id="idusuario" name="idusuario" value="<?php echo $colUsuarios[0]->getIdUsuario() ?>" readonly>
        <label for="usnombre">Nombre usuario</label>
        <input type="text" class="form-control" id="usnombre" name="usnombre" value="<?php echo $colUsuarios[0]->getUsNombre() ?>">

        <label for="uspass">Contraseña</label>
        <input type="password" class="form-control" id="uspass" name="uspass" value="<?php echo $colUsuarios[0]->getUsPass() ?>">

        <label for="usmail">Email</label>
        <input type="text" class="form-control" id="usmail" name="usmail" value="<?php echo $colUsuarios[0]->getUsMail() ?>">

        <input type="submit" class="btn btn-success" value="Confirmar">
        <a href="listarUsuario.php">
            <input type="button" class="btn btn-primary" value="Cancelar">
        </a>
    </form>
</body>

</html>