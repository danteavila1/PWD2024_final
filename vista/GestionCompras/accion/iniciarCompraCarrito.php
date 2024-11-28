<?php
include_once("../../../configuracion.php");

$data = json_decode(file_get_contents("php://input"), true);

    try {
        $objCarrito = new AbmCompraEstado;
        $respuesta = $objCarrito->cambiarCarritoAIniciado($data);
        
        if($respuesta){
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "datos erroneos"]); 
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }

?>
