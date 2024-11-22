<?php  
// accion/accionCarrito.php

file_put_contents("error.log", json_encode($_POST), FILE_APPEND);

//codigo para ver error en consola en detalle
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../../configuracion.php");

$session = new Session();


// if (!headers_sent()) {
//     http_response_code(500); // Código de error interno del servidor
//     echo json_encode(["status" => "error", "message" => "Error desconocido en el servidor"]);
// }

// // Verificar si el usuario está logueado
// if ($user->getIdUsuario() === null) {
//     echo json_encode(['success' => false, 'message' => 'Usuario no logueado']);
//     exit;
// }

// // Obtener los datos del producto enviados por la solicitud POST
// $datos = json_decode(file_get_contents('php://input'), true);

// // Verificar que los datos sean correctos
// if (!isset($datos['idproducto']) || !isset($datos['idusuario']) || !isset($datos['cantidad'])) {
//     echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
//     exit;
// }

$datos = json_decode(file_get_contents('php://input'), true);

if($datos){
$idUsuario = $session->getUsuario()->getIdusuario();
$fechaCompra = date('Y-m-d H:i:s');
// Verificar si el usuario tiene un carrito activo
$abmCompraEstado = new AbmCompraEstado();
$carritoActivo = $abmCompraEstado->buscarCarroActivo($idUsuario);

//si el carrito esta nulo creamos una nueva abmcompra
if($carritoActivo === null){
    $abmCompra = new AbmCompra();

    $paramCompra = [
        'idcompra' => null,
        'cofecha' => $fechaCompra,
        'idUsuario' => $idUsuario
    ];


    //Inserta la compra a la tabla
    if($abmCompra->alta($paramCompra)){
        // Obtener el ID de la compra recien creada
        $idCompra = $abmCompra->buscar(['cofecha' => $fechaCompra, 'idusuario' => $idUsuario])[0]->getIdcompra();

        // Parametros para el nuevo estado de la compra
        $paramCompraEstado = [
            'idcompraestado' => null,
            'idcompra' => $idCompra,
            'idcompraestadotipo' => 1, // Estado inicial "iniciada"
            'cefechaini' => $fechaCompra,
            'cefechafin' => null
        ];

        //Inserta el nuevo compraEstado
        if($abmCompraEstado->alta($paramCompraEstado)){
            //Insertar los elementos en tabla CompraItem
            $abmCompraItem = new AbmCompraItem();

            // Parametros para el nuevo Item de compra
            $paramCompraItem = [
                'idcompraitem' => null,
                'idproducto' => $datos['idproducto'], //id del producto
                'idcompra' => $idCompra,
                'cicantidad' => $datos['cantidad'] // La cantidad seleccionada por el cliente
            ];

            if ($abmCompraItem->alta($paramCompraItem)) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al insertar el ítem de la compra"]);
            } 
        } else {
            echo json_encode(["status" => "error", "message" => "Error al insertar el estado de la compra"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al insertar la compra"]);
    }
} else {
    //tiene compra iniciada, vemos cual es extrayendo el id
    $idCompraIniciada = $carritoActivo[0]->getIdcompra();

    $abmCompraItem = new AbmCompraItem();

    // Verificar si ya existe un CompraItem con el mismo idproducto y idcompra
    $compraItemExistente = $abmCompraItem->buscar(['idcompra' => $idCompraIniciada, 'idproducto' => $idProducto]);

    //si ya existe un CompraItem con el mismo idproducto y idcompra entonces actualizar su cantidad
    if (count($compraItemExistente) > 0) {
        $compraItemExistente = $compraItemExistente[0];
        $nuevaCantidad = $compraItemExistente->getCicantidad() + $datos['cantidad'];

        $paramCompraItem = [
            'idcompraitem' => $compraItemExistente->getIdcompraitem(),
            'idproducto' => $datos['idproducto'], 
            'idcompra' => $idCompraIniciada,
            'cicantidad' => $nuevaCantidad
        ];

        if ($abmCompraItem->modificacion($paramCompraItem)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar la cantidad del ítem de la compra"]);
        }
    } else {
        // Si no existe, insertar un nuevo CompraItem
        $paramCompraItem = [
            'idcompraitem' => null,
            'idproducto' => $datos['idproducto'], 
            'idcompra' => $idCompraIniciada,
            'cicantidad' => $datos['cantidad']
        ];

        if ($abmCompraItem->alta($paramCompraItem)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al insertar el ítem de la compra"]);
        }
    }
}
}  else {
    echo json_encode(["status" => "error", "message" => "Datos no válidos"]);
}