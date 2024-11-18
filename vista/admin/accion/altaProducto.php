<?php
include_once('../../../configuracion.php');

// Recibo los datos del formulario
$datos = data_submitted();

// Verifico si se envió un archivo
if (isset($_FILES['proimagen']) && $_FILES['proimagen']['error'] == UPLOAD_ERR_OK) {
    $nombreImagen = $_FILES['proimagen']['name'];
    $rutaTemporal = $_FILES['proimagen']['tmp_name'];

    // Obtengo la extensión del archivo
    $ext = pathinfo($nombreImagen, PATHINFO_EXTENSION);

    // Verifico si la extensión es válida
    $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
    if (!in_array(strtolower($ext), $extensionesPermitidas)) {
        $response = ['mensaje' => 1, 'icono' => 'error'];
        echo json_encode($response);
        exit;
    }

    // Defino la ruta de la imagen
    $destino = '../../images/' . $nombreImagen;

    // Lo muevo a la carpeta /images
    if (move_uploaded_file($rutaTemporal, $destino)) {
        $datos['proimagen'] = $nombreImagen;
    } else {
        $response = ['mensaje' => 2, 'icono' => 'error'];
        echo json_encode($response);
        exit;
    }
}

// Creo instancia del objeto AbmProducto
$objProducto = new AbmProducto();

// Modifico
if ($objProducto->alta($datos)) {
    $response = ['mensaje' => 'Alta exitosa', 'icono' => 'success'];
} else {
    $response = ['mensaje' => 'Alta fallida', 'icono' => 'error'];
}

echo json_encode($response);
exit;
