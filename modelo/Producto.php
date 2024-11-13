<?php

class Producto {
    private $idProducto;
    private $proNombre;
    private $proDetalle;
    private $proCantStock;
    private $proImagen;
    private $mensajeOperacion;

    public function __construct(){
        $this->idProducto = 0;
        $this->proNombre = ""; 
        $this->proDetalle = "";
        $this->proCantStock = 0;
        $this->proImagen = "";
        $this->mensajeOperacion = "";
    }

    public function setear($idProducto, $proNombre, $proDetalle, $proCantStock, $proImagen){
        $this->setIdProducto($idProducto);
        $this->setProNombre($proNombre);
        $this->setProDetalle($proDetalle);
        $this->setProCantStock($proCantStock);
        $this->setProImagen($proImagen);
    }

    // Metodos GET

    public function getIdProducto(){
        return $this->idProducto;
    }
    public function getProNombre(){
        return $this->proNombre;
    }
    public function getProDetalle(){
        return $this->proDetalle;
    }
    public function getProCantStock(){
        return $this->proCantStock;
    }
    public function getProImagen(){
        return $this->proImagen;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    // Metodos SET

    public function setIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }
    public function setProNombre($proNombre){
        $this->proNombre = $proNombre;
    }
    public function setProDetalle($proDetalle){
        $this->proDetalle = $proDetalle;
    }
    public function setProCantStock($proCantStock){
        $this->proCantStock = $proCantStock;
    }
    public function setProImagen($proImagen){
        $this->proImagen = $proImagen;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto WHERE idproducto = " . $this->getIdProducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res > -1){
                if($res > 0){
                    $row = $base->Registro();
                    $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['proimagen']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("producto->cargar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $base = new BaseDatos();
        $id = false;
        $resp = false;
        $sql = "INSERT INTO producto(pronombre, prodetalle, procantstock, proimagen) VALUES ('" . $this->getProNombre() . "', '" . $this->getProDetalle() . "', '" . $this->getProCantStock() . "', '" . $this->getProImagen() . "')";
        if($base->Iniciar()){
            $id = $base->Ejecutar($sql);
            if($id != null){
                $resp = true;
                $this->setIdProducto($id);
            } else {
                $this->setMensajeOperacion("producto->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->insertar: " . $base->getError());
        }
        return $id;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE producto SET pronombre = '" . $this->getProNombre() . "', prodetalle = '" . $this->getProDetalle() . "', procantstock = '" . $this->getProCantStock() . "', proimagen = '" . $this->getProImagen() . "' WHERE idproducto = " . $this->getIdProducto();
    
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM producto WHERE idproducto = " . $this->getIdProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res > -1){
            if($res > 0){
                while ($row = $base->Registro()){
                    $obj = new Producto();
                    $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['proimagen']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $obj = new Producto();
            $obj->setMensajeOperacion("producto->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
?>
