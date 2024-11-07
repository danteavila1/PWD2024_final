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
$idusuario = $datos['idusuario'];

// Creo instancia del objeto AbmUsuario
$objUsuario = new AbmUsuario();
$colUsuarios = $objUsuario->buscar($datos);

foreach ($colUsuarios as $usuario) {
    $usnombre = $usuario->getUsNombre();
}
?>

<body>
    <h3>Iniciado como <?php echo $_SESSION['usnombre'] ?> </h3>
    <form id="form" name="form" method="post" action="accion/bajaUsuario.php">
        <h3>¿Deshabilitar usuario <?php echo $usnombre ?>?</h3>

        <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
        <label for="opcion1">
            <input type="submit" class="btn btn-danger" name="opcion" value="si">
        </label>
        <label for="opcion2">
            <input type="submit" class="btn btn-primary" name="opcion" value="no">
        </label>
    </form>
</body>

</html>