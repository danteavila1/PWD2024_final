<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alta usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php
include_once('../../configuracion.php');

// Inicio sesión -> session_start()
$session = new Session();

?>

<body>
    <h3>Iniciado como <?php echo $_SESSION['usnombre'] ?> </h3>
    <form id="form" name="form" method="post" action="accion/altaRol.php">
        <h3>Añadir rol</h3>
        <label for="usnombre">Nombre del rol</label>
        <input type="text" class="form-control" id="rodescripcion" name="rodescripcion">

        <input type="submit" class="btn btn-success" value="Confirmar">
        <a href="listarUsuario.php">
            <input type="button" class="btn btn-primary" value="Cancelar">
        </a>
    </form>
</body>

</html>