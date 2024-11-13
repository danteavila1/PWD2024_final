<?php

class CompraItem {
    private $idCompraItem;
    private $idProducto;
    private $idCompra;
    private $ciCantidad; // cuantos articulos de un producto determinado fueron incluidos en una determinada compra.
    private $mensajeOperacion;

    public function __construct(){
        $this->idCompraItem = 0;
        $this->idProducto = 0;
        $this->idCompra = 0;
        $this->ciCantidad = 0;
        $this->mensajeOperacion = "";
    }

    public function setear($idCompraItem, $idProducto, $idCompra, $ciCantidad){
        $this->setIdCompraItem($idCompraItem);
        $this->setIdProducto($idProducto);
        $this->setIdCompra($idCompra);
        $this->setCiCantidad($ciCantidad);
    }

    public function getIdCompraItem(){
        return $this->idCompraItem;
    }
    public function getIdProducto(){
        return $this->idProducto;
    }
    public function getIdCompra(){
        return $this->idCompra;
    }
    public function getCiCantidad(){
        return $this->ciCantidad;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setIdCompraItem($idCompraItem){
        $this->idCompraItem = $idCompraItem;
    }
    public function setIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }
    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }
    public function setCiCantidad($ciCantidad){
        $this->ciCantidad = $ciCantidad;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res > -1){
                if($res > 0){
                    $row = $base->Registro();
                    $this->setear($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compraitem->cargar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $base = new BaseDatos();
        $id = false;
        $resp = false;
        $sql = "INSERT INTO compraitem(idproducto, idcompra, cicantidad) VALUES ('" . $this->getIdProducto() . "', '" . $this->getIdCompra() . "', '" . $this->getCiCantidad() . "')";
        if($base->Iniciar()){
            $id = $base->Ejecutar($sql);
            if($id != null){
                $resp = true;
                $this->setIdCompraItem($id);
            } else {
                $this->setMensajeOperacion("compraitem->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->insertar: " . $base->getError());
        }
        return $id;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem SET idproducto = '" . $this->getIdProducto() . "', idcompra = '" . $this->getIdCompra() . "', cicantidad = '" . $this->getCiCantidad() . "' WHERE idcompraitem = " . $this->getIdCompraItem();
    
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraitem->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraitem->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->eliminar: " . $base->getError());
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
        $res = $base->Ejecutar($sql);
        if($res > -1){
            if($res > 0){
                while ($row = $base->Registro()){
                    $obj = new CompraItem();
                    $obj->setear($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $obj = new CompraItem();
            $obj->setMensajeOperacion("compraitem->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
?>

