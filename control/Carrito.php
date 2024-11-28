<?php
// Clase Carrito.php

class Carrito {
    private $abmCompra;
    private $abmCompraEstado;
    private $abmCompraItem;
    private $session;

    public function __construct() {
        $this->abmCompra = new AbmCompra();
        $this->abmCompraEstado = new AbmCompraEstado();
        $this->abmCompraItem = new AbmCompraItem();
        $this->session = new Session();
    }

    public function agregarProducto($datos) {
        $idUsuario= $datos['idusuario'];
        //$idUsuario = $this->session->getUsuario()->getIdusuario();
        $fechaCompra = date('Y-m-d H:i:s');
        $carritoActivo = $this->abmCompraEstado->buscarCarroActivo($idUsuario);

        if ($carritoActivo == null) {
            return $this->crearNuevoCarrito($idUsuario, $fechaCompra, $datos);
        } else {
            return $this->actualizarCarritoExistente($carritoActivo, $datos);
        }
    }

    private function crearNuevoCarrito($idUsuario, $fechaCompra, $datos) {
        $paramCompra = [
            'idcompra' => null,
            'cofecha' => $fechaCompra,
            'idusuario' => $idUsuario
        ];

        if ($this->abmCompra->alta($paramCompra)) {
            $idCompra = $this->abmCompra->buscar(['cofecha' => $fechaCompra, 'idusuario' => $idUsuario])[0]->getIdcompra();

            $paramCompraEstado = [
                'idcompraestado' => null,
                'idcompra' => $idCompra,
                'idcompraestadotipo' => 5,
                'cefechaini' => $fechaCompra,
                'cefechafin' => null
            ];

            if ($this->abmCompraEstado->alta($paramCompraEstado)) {
                return $this->agregarItemAlCarrito($idCompra, $datos);
            } else {
                return ["status" => "error", "message" => "Error al insertar el estado de la compra"];
            }
        } else {
            return ["status" => "error", "message" => "Error al insertar la compra"];
        }
    }
private function actualizarCarritoExistente($carritoActivo, $datos) {
        $idCompraIniciada = $carritoActivo[0]->getIdcompra();

        $compraItemExistente = $this->abmCompraItem->buscar(['idcompra' => $idCompraIniciada, 'idproducto' => $datos['idproducto']]);

        if (count($compraItemExistente) > 0) {
            $compraItemExistente = $compraItemExistente[0];
            $nuevaCantidad = $compraItemExistente->getCicantidad() + $datos['cantidad'];

            $paramCompraItem = [
                'idcompraitem' => $compraItemExistente->getIdcompraitem(),
                'idproducto' => $datos['idproducto'], 
                'idcompra' => $idCompraIniciada,
                'cicantidad' => $nuevaCantidad
            ];

            if ($this->abmCompraItem->modificacion($paramCompraItem)) {
                return ["status" => "success"];
            } else {
                return ["status" => "error", "message" => "Error al actualizar la cantidad del ítem de la compra"];
            }
        } else {
            return $this->agregarItemAlCarrito($idCompraIniciada, $datos);
        }
    }

    private function agregarItemAlCarrito($idCompra, $datos) {
        $paramCompraItem = [
            'idcompraitem' => null,
            'idproducto' => $datos['idproducto'], 
            'idcompra' => $idCompra,
            'cicantidad' => $datos['cantidad']
        ];

        if ($this->abmCompraItem->alta($paramCompraItem)) {
            return ["status" => "success"];
        } else {
            return ["status" => "error", "message" => "Error al insertar el ítem de la compra"];
        }
    }
}

?>