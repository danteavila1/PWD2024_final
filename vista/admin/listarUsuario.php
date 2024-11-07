<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listar usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</head>

<?php
include_once('../../configuracion.php');

// Inicio sesión (session_start())
$session = new Session();

// Creo instancia del objeto AbmUsuario y accedo al método correspondiente
$objUsuario = new AbmUsuario();
$colUsuarios = $objUsuario->buscar("");

// Verifico que hayan usuarios en la base de datos
$hayUsuarios = false;
if (count($colUsuarios) > 0) {
    $hayUsuarios = true;
}

// Este paso es para mostrar notificación de SweetAlert en caso de haber realizado alguna acción
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $icono = $_SESSION['icono'];

    // Borro dichos datos para que no se muestren al recargar la página
    unset($_SESSION['mensaje']);
    unset($_SESSION['icono']);
}
?>

<body>
    <h3>Iniciado como <?php echo $_SESSION['usnombre'] ?> </h3>
    <?php if (isset($mensaje)) : ?>
        <script>
            // Mostrar notificación de SweetAlert
            Swal.fire({
                title: "<?php echo $mensaje ?>",
                icon: "<?php echo $icono ?>"
            });
        </script>
    <?php endif; ?>
    <div class="justify-content-md-center align-items-center mt-5">
        <div class="card shadow  mx-usuario">
            <div class="card-header">
                <h3>Listado de usuarios cargados en la base de datos</h3>
                <div class="d-flex">
                    <a href="formAlta.php">
                        <input type="submit" class="btn btn-success me-2" value="Añadir usuario">
                    </a>
                    <a href="../login/accion/cerrarSesion.php">
                        <input type="submit" class="btn btn-secondary me-2" value="Cerrar sesión">
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if ($hayUsuarios): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID usuario</th>
                                <th scope="col">Nombre usuario</th>
                                <th scope="col">Email</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Deshabilitado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <?php
                        for ($i = 0; $i < count($colUsuarios); $i++):
                            $idusuario = $colUsuarios[$i]->getIdUsuario();
                            $usnombre = $colUsuarios[$i]->getUsNombre();
                            $usmail = $colUsuarios[$i]->getUsMail();

                            // Creo instancia del objeto AbmUsuarioRol para mostrar los roles de los usuarios
                            $objUsuarioRol = new AbmUsuarioRol();

                            $usuario = ['idusuario' => $idusuario];
                            $colUsuarioRol = $objUsuarioRol->buscar($usuario);
                            $cantRoles = count($colUsuarioRol);

                            // Creamos array para guardar los roles del usuario
                            $colRoles = [];

                            // Recorremos todos los roles del usuario
                            if ($cantRoles >= 1) {
                                foreach ($colUsuarioRol as $rol) {
                                    $roldescripcion = $rol->getObjRol()->getRolDescripcion();
                                    $colRoles[] = $roldescripcion;
                                }

                                // Separamos con una "coma" en >> caso de que un usuario tenga más de un rol <<
                                $roles = implode(", ", $colRoles);
                            } else {
                                $roles = "-";
                            }

                            $usdeshabilitado = $colUsuarios[$i]->getUsDeshabilitado();
                            if ($usdeshabilitado == NULL) {
                                $usdeshabilitado = "Activo";
                            }
                        ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $idusuario ?></td>
                                    <td><?php echo $usnombre ?></td>
                                    <td><?php echo $usmail ?></td>
                                    <td><?php echo $roles ?></td>
                                    <td><?php echo $usdeshabilitado ?></td>
                                    <td>
                                        <?php if ($usdeshabilitado == "Activo") : ?>
                                            <div class="d-flex">
                                                <a href="formModificacion.php?idusuario=<?php echo $idusuario ?>">
                                                    <input type="submit" class="btn btn-primary me-2" value="Modificar datos">
                                                </a>
                                                <a href="formModificarRoles.php?idusuario=<?php echo $idusuario ?>">
                                                    <input type="submit" class="btn btn-primary me-2" value="Modificar roles">
                                                </a>
                                                <a href="formBaja.php?idusuario=<?php echo $idusuario ?>">
                                                    <input type="submit" class="btn btn-danger me-2" value="Deshabilitar">
                                                </a>
                                            </div>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            </tbody>
                        <?php endfor; ?>
                    </table>
                <?php else: ?>
                    <p><?php echo "No hay usuarios cargados en la base de datos."; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>