<?php
include_once("../../../configuracion.php");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['idCompras'])) {
    $idCompras = $data['idCompras'];
    $objCompraEstado = new AbmCompraEstado();

    try {
        foreach ($idCompras as $idcompra) {
            // Paso 1: Finalizar el estado actual ("carrito")
            $paramBuscar = ['idcompra' => $idcompra, 'idcompraestadotipo' => 5]; // 5 = "carrito"
            $colEstados = $objCompraEstado->buscar($paramBuscar);

            foreach ($colEstados as $estado) {
                $estado->setCeFechaFin(date("Y-m-d H:i:s")); // Establecer fecha de fin
            }

            // Paso 2: Crear un nuevo estado ("iniciada")
            $nuevoEstado = [
                'idcompra' => $idcompra,
                'idcompraestadotipo' => 1, // 2 = "iniciada"
                'cefechaini' => date("Y-m-d H:i:s")
            ];
            $objCompraEstado->alta($nuevoEstado); // Crear el nuevo estado
        }

        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Datos inválidos"]);
}
?>
