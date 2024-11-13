<?php

class Compra {
    private $idCompra;
    private $coFecha;
    private $idUsuario;
    private $mensajeOperacion;

    public function __construct(){
        $this->idCompra = 0;
        $this->coFecha = "";
        $this->idUsuario = 0;
        $this->mensajeOperacion = "";
    }

    public function setear($idCompra, $coFecha, $idUsuario){
        $this->setIdCompra($idCompra);
        $this->setCoFecha($coFecha);
        $this->setIdUsuario($idUsuario);
    }

    public function getIdCompra(){
        return $this->idCompra;
    }
    public function getCoFecha(){
        return $this->coFecha;
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }
    public function setCoFecha($coFecha){
        $this->coFecha = $coFecha;
    }
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getIdCompra();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res > -1){
                if($res > 0){
                    $row = $base->Registro();
                    $this->setear($row['idcompra'], $row['cofecha'], $row['idusuario']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compra->cargar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $base = new BaseDatos();
        $id = false;
        $resp = false;
        $sql = "INSERT INTO compra(cofecha, idusuario) VALUES ('" . $this->getCoFecha() . "', '" . $this->getIdUsuario() . "')";
        if($base->Iniciar()){
            $id = $base->Ejecutar($sql);
            if($id != null){
                $resp = true;
                $this->setIdCompra($id);
            } else {
                $this->setMensajeOperacion("compra->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->insertar: " . $base->getError());
        }
        return $id;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compra SET cofecha = '" . $this->getCoFecha() . "', idusuario = '" . $this->getIdUsuario() . "' WHERE idcompra = " . $this->getIdCompra();
    
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra = " . $this->getIdCompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res > -1){
            if($res > 0){
                while ($row = $base->Registro()){
                    $obj = new Compra();
                    $obj->setear($row['idcompra'], $row['cofecha'], $row['idusuario']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $obj = new Compra();
            $obj->setMensajeOperacion("compra->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
?>
