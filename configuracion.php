<?php header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate ");
include_once('env.php');

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO = $rutaProyecto;

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].$PROYECTO);
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].$PROYECTO);
//variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

$GLOBALS['ROOT'] = $ROOT;
include_once($ROOT . 'util/funciones.php');
?>

<!-- asdasd -->