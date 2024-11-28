<?php header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO = '/PWD2024_final/';

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . $PROYECTO);
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . $PROYECTO);
//variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/PWD2024_final/";

$GLOBALS['ROOT'] = $ROOT;
include_once($ROOT . 'util/funciones.php');
