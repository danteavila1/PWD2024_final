<?php 
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");

$abmProducto = new AbmProducto;
$productos = array();
$datos = data_submitted();

if ($_POST['idProducto']){
    $indice['idProducto'] = $datos['idProducto'];
    $producto = $abmProducto->buscar($indice);
    if($producto != []){
        if($producto[0]->getProDeshabilitado() == null || $producto[0]->getProDeshabilitado() == '0000-00-00 00:00:00'){
            $datos['proDeshabilitado'] = null;
            if ($abmProducto->modificacion($datos)) {
                unlink($dir . $datos['idProducto'] . '.png');
                copy($_FILES["foto"]["tmp_name"], $dir . $datos['idProducto'] . '.png');

            
                ?>
                    <h2 style="text-align: center; color: green">Los datos fueron actualizados correctamente.</h2>
                <?php
                } else {
                ?>
                    <h2 style='color: red; text-align: center; '>No se realizaron cambios debido a un error</h2>
                
                <?php
            }
        } 
    } else{
        ?>
                <h2 style='color: red; text-align: center; '>El producto no se encontro</h2>

            <?php
    }
    

} else {
    $datos['proDeshabilitado'] = null;
    $resp = $abmProducto->alta($datos);
    if($resp != false){
        copy($_FILES["foto"]["tmp_name"], $dir . $resp . '.png');
        ?>
            <h2 style="text-align: center; color: green">Se ha ingresado el producto correctamente.</h2>
        <?php
    } else{
        
        ?>
            <h2 style='color: red; text-align: center; '>No se ha ingresado el producto debido a un error</h2>
        <?php
    }

}



?>