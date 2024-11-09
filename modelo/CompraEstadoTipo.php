<?php
class CompraEstadoTipo{
    private $idCompraEstadoTipo;
    private $cetDescripcion;
    private $cetDetalle;
    private $mensajeOperacion;

    public function __construct(){
        $this->idCompraEstadoTipo = '';
        $this->cetDescripcion = '';
        $this->cetDetalle = '';
        $this->mensajeOperacion = '';
    }

    public function setear($idCompraEstadoTipoSet, $cetDescripcionSet, $cetDetalleSet){
        $this->idCompraEstadoTipo = $idCompraEstadoTipoSet;
        $this->cetDescripcion = $cetDescripcionSet;
        $this->cetDetalle = $cetDetalleSet;
        $this->mensajeOperacion = '';
    }

    public function setIdCompraEstadoTipo($idCompraEstadoTipoNuevo){
        $this->idCompraEstadoTipo = $idCompraEstadoTipoNuevo;
    }

    public function getIdCompraEstadoTipo(){
        return $this->idCompraEstadoTipo;
    }

    public function setCetDescripcion($cetDescripcionNuevo){
        $this->cetDescripcion = $cetDescripcionNuevo;
    }

    public function getCetDescripcion(){
        return $this->cetDescripcion;
    }
    
    public function setCetDetalle($cetDetalleNuevo){
        $this->cetDetalle = $cetDetalleNuevo;
    }

    public function getCetDetalle(){
        return $this->cetDetalle;
    }

    public function setMensajeOperacion($valor){
        $this->mensajeOperacion = $valor;
        
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

     /*******************************
     *  MÉTODOS PARA LA CONEXIÓN CON LA BD
     *******************************/

     public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestadotipo WHERE idcompraestadotipo = ".$this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idcompraestadotipo'],$row['cetdescripcion'], $row['cetdetalle']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO compraestadotipo(cetdescripcion,cetdetalle)
				VALUES ('".$this->getCetDescripcion()."','".$this->getCetDetalle()."')";
		if($base->Iniciar()){
            $id = $base->EjecutarInsert($consultaInsertar);
			if($id != null){
			    $resp=  true;
				$this->setIdCompraEstadoTipo($id);
			}else{
				$this->setMensajeOperacion("compraestadotipo->insertar: ".$base->getError());
			}
		} else {
				$this->setMensajeOperacion("compraestadotipo->insertar: ".$base->getError());
		}
		return $resp;
	}

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestadotipo SET
        cetdescripcion = '" . $this->getCetDescripcion() . "',
        cetdetalle = '" . $this->getCetDetalle(). "',
        WHERE idcompraestadotipo = '" . $this->getIdCompraEstadoTipo() . "'";
    
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo = ".$this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestadotipo ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new CompraEstadoTipo();
                    $obj->setear($row['idcompraestadotipo'],$row['cetdescripcion'], $row['cetdetalle']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->listar: ".$base->getError());
        }
        return $arreglo;
    }

}
?>