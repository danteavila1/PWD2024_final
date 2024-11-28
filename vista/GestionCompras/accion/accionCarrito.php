<?php  
include_once("../../../configuracion.php");

$session = new Session();
$carrito = new Carrito();

// Obtener los datos enviados por la solicitud POST
$datos = json_decode(file_get_contents('php://input'), true);

// Verificar que los datos sean correctos

if (!$datos || !isset($datos['idproducto']) || !isset($datos['cantidad'])) {
    echo json_encode(["status" => "error", "message" => "Datos no válidos"]);
    exit;
}

// Agregar el producto al carrito
$resultado = $carrito->agregarProducto($datos);

// Retornar la respuesta a la interfaz
echo json_encode($resultado);
?>