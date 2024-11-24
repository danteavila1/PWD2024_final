<?php 
include_once("../../configuracion.php");
include_once(ROOT_PATH . "vista/estructura/header.php");

$abmProducto = new AbmProducto;
$productos = array();
$datos = data_submitted();
$dir = '../images/';

if ($_POST['idproducto']){
    $indice['idproducto'] = $datos['idproducto'];
    $producto = $abmProducto->buscar($indice);
    if($producto != []){
        

            if ($abmProducto->modificacion($datos)) {
                unlink($dir . $datos['proimagen']);
                copy($_FILES["foto"]["tmp_name"], $dir . $datos['proimagen']);

            
                ?>
                    <h2 style="text-align: center; color: green">Los datos fueron actualizados correctamente.</h2>
                <?php
                } else {
                    echo $datos['proimagen'];
                ?>
                    <h2 style='color: red; text-align: center; '>No se realizaron cambios debido a un error</h2>
                <?php
            }
        
    } else{
        ?>
                <h2 style='color: red; text-align: center; '>El producto no se encontro</h2>

            <?php
    }
    

} else {
    
    $resp = $abmProducto->alta($datos);
    if($resp != false){
        copy($_FILES["foto"]["tmp_name"], $dir );
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