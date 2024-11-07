<?php
function data_submitted()
{
    $_AAux = array();
    if (!empty($_POST))
        $_AAux = $_POST;
    else
            if (!empty($_GET)) {
        $_AAux = $_GET;
    }
    if (count($_AAux)) {
        foreach ($_AAux as $indice => $valor) {
            if ($valor == "")
                $_AAux[$indice] = 'null';
        }
    }
    return $_AAux;
}

function verEstructura($e)
{
    echo "<pre>";
    print_r($e);
    echo "</pre>";
}

// autoload para version 8.0
spl_autoload_register(function ($class_name) {
    $directorys = array(
        $GLOBALS['ROOT'] . 'modelo/',
        $GLOBALS['ROOT'] . 'modelo/conector/',
        $GLOBALS['ROOT'] . 'control/',
        //  $GLOBALS['ROOT'].'util/class/',
    );

    //print_object($directorys) ;
    foreach ($directorys as $directory) {
        if (file_exists($directory . $class_name . '.php')) {
            // echo "se incluyo" . $directory . $class_name . '.php';
            require_once($directory . $class_name . '.php');
            return;
        }
    }
});
