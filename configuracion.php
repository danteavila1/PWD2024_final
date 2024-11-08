<?php header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate ");
include_once('env.php');

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO = $rutaProyecto;

//variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

$GLOBALS['ROOT'] = $ROOT;
include_once($ROOT . 'util/funciones.php');
?>

<!-- asdasd -->