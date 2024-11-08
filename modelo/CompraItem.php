<?php

class CompraItem {

    private $idCompraItem;
    private $producto;
    private $compra;
    private $ciCantidad;
    private $mensajeOperacion;

    public function __construct(){
        $this->idCompraItem = "";
        $this->producto = new Producto();
        $this->compra = new Compra();
        $this->ciCantidad = "";
        $this->mensajeOperacion = "";
    }

    public function cargar($idCompraItem, $producto, $compra, $ciCantidad){
        $this->setIdCompraItem($idCompraItem);
        $this->setProducto($producto);
        $this->setCompra($compra);
        $this->setCiCantidad($ciCantidad);
    }

    // Getters

    public function getIdCompraItem(){
        return $this->idCompraItem;
    }

    public function getProducto(){
        return $this->producto;
    }

    public function getCompra(){
        return $this->compra;
    }

    public function getCiCantidad(){
        return $this->ciCantidad;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    // Setters

    public function setIdCompraItem($idCompraItem){
        $this->idCompraItem = $idCompraItem;
    }

    public function setProducto($producto){
        $this->producto = $producto;
    }

    public function setCompra($compra){
        $this->compra = $compra;
    }

    public function setCiCantidad($ciCantidad){
        if (is_numeric($ciCantidad) && $ciCantidad > 0) {
            $this->ciCantidad = $ciCantidad;
        } else {
            throw new Exception("La cantidad debe ser un número positivo.");
        }
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = ".$this->getIdCompraItem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res > -1){
                if($res > 0){
                    $row = $base->Registro();
                    $compra = new Compra();
                    $compra->setIdCompra($row['idcompra']);
                    $compra->buscar();
                    $producto = new Producto();
                    $producto->setIdProducto($row['idproducto']);
                    $producto->buscar();
                    $this->cargar($row['idcompraitem'], $producto, $compra, $row['cicantidad']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("CompraItem->buscar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad)
                VALUES ('" 
                . $this->getProducto()->getIdProducto() . "', '" 
                . $this->getCompra()->getIdCompra() . "', '" 
                . $this->getCiCantidad() . "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdCompraItem($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("CompraItem->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->insertar: ".$base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem SET idproducto=".$this->getProducto()->getIdProducto().
               ", idcompra=".$this->getCompra()->getIdCompra().
               ", cicantidad=".$this->getCiCantidad().
               " WHERE idcompraitem=".$this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem=".$this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res > -1){
                if($res > 0){
                    while ($row = $base->Registro()){
                        $obj = new CompraItem();
                        $producto = new Producto();
                        $producto->setIdProducto($row['idproducto']);
                        $producto->buscar();
                        $compra = new Compra();
                        $compra->setIdCompra($row['idcompra']);
                        $compra->buscar();
                        $obj->cargar($row['idcompraitem'], $producto, $compra, $row['cicantidad']);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                throw new Exception("Error al listar las compraItem: " . $base->getError());
            }
        } else {
            throw new Exception("Error en la conexión: " . $base->getError());
        }
        return $arreglo;
    }

    public function jsonSerialize(){
        $producto = $this->getProducto() ? $this->getProducto()->jsonSerialize() : null;
        $compra = $this->getCompra() ? $this->getCompra()->jsonSerialize() : null;
        return [
            'idCompraItem' => $this->getIdCompraItem(),
            'producto' => $producto,
            'compra' => $compra,
            'ciCantidad' => $this->getCiCantidad()
        ];
    }
}
