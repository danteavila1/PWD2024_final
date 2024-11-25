<?php
include_once("../configuracion.php");
include_once(ROOT_PATH . "/control/AbmProducto.php");
include_once(ROOT_PATH . "/control/CargaImagen.php");

$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
$abmProducto = new AbmProducto();
$imagenUploader = new CargaImagen();

switch ($accion) {
    case 'listar':
        $productos = $abmProducto->buscar(null);
        break;

    case 'subirImagen':
        if (isset($_FILES['archivo'])) {
            $resultado = $imagenUploader->subir($_FILES);
            $mensaje = $resultado['mensaje'];
            $pudo = $resultado['pudo'];
        }
        break;

    default:
        $productos = [];
        break;
}

$productos = isset($productos) ? $productos : [];
$mensaje = isset($mensaje) ? $mensaje : null;
$pudo = isset($pudo) ? $pudo : null;
