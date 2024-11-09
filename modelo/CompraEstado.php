<?php
class CompraEstado{
    private $idcompraestado;
    private $objCompra;
    private $objCompraEstadoTipo;
    private $cefechaini;
    private $cefechafin;
    private $mensajeOperacion;


    public function __construct(){
        $this->idcompraestado = '';
        $this->objCompra = '';
        $this->objCompraEstadoTipo = '';
        $this->cefechaini = '';
        $this->cefechafin = '';
        $this->mensajeOperacion = '';
    }

    public function setear($idcompraestadoSet, $objCompraSet, $objCompraEstadoTipoSet,$cefechaini,$cefechafin){
        $this->idcompraestado = $idcompraestadoSet;
        $this->objCompra = $objCompraSet;
        $this->objCompraEstadoTipo = $objCompraEstadoTipoSet;
        $this->cefechaini = $cefechaini;
        $this->cefechafin = $cefechafin;
        $this->mensajeOperacion = '';
    }

    public function setIdCompraEstado($idcompraestadoNuevo){
        $this->idcompraestado = $idcompraestadoNuevo;
    }

    public function getIdCompraEstado(){
        return $this->idcompraestado;
    }

    public function setObjCompra($objCompraNuevo){
        $this->objCompra = $objCompraNuevo;
    }

    public function getObjCompra(){
        return $this->objCompra;
    }

    public function setObjCompraEstadoTipo($objCompraEstadoTipoNuevo){
        $this->objCompraEstadoTipo = $objCompraEstadoTipoNuevo;
    }

    public function getObjCompraEstadoTipo(){
        return $this->objCompraEstadoTipo;
    }

    public function setCeFechaIni($cefechainiNuevo){
        $this->cefechaini = $cefechainiNuevo;
    }

    public function getCeFechaIni(){
        return $this->cefechaini;
    }

    public function setCeFechaFin($cefechafinNuevo){
        $this->cefechafin = $cefechafinNuevo;
    }

    public function getCeFechaFin(){
        return $this->cefechafin;
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
        $sql="SELECT * FROM compraestado WHERE idcompraestado = ".$this->getIdCompraEstado();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']);
                    $objCompra->cargar();
                    $objCompraEstadoTipo = new CompraEstadoTipo();
                    $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
                    $objCompraEstadoTipo->cargar();
                    $this->setear($row['idcompraestado'],$objCompra, $objCompraEstadoTipo,$row['cefechaini'], $row['cefechafin']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compraestado->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO compraestado(idcompra,idcompraestadotipo)
				VALUES ('".$this->getObjCompra()->getIdCompra()."','".$this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo()."')";
		if($base->Iniciar()){
            $id = $base->EjecutarInsert($consultaInsertar);
			if($id != null){
			    $resp=  true;
				$this->setIdCompraEstado($id);
			}else{
				$this->setMensajeOperacion("compraestado->insertar: ".$base->getError());
			}
		} else {
				$this->setMensajeOperacion("compraestado->insertar: ".$base->getError());
		}
		return $resp;
	}

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestado SET
        idcompra = '" . $this->getObjCompra()->getIdCompra(). "',
        idcompraestadotipo = '" . $this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo(). "',
        cefechafin = '" . $this->getCeFechaFin(). "',
        WHERE idcompraestado = '" . $this->getIdCompraEstado() . "'";
    
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestado->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestado->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "DELETE FROM compraestado WHERE idcompraestado = ".$this->getIdCompraEstado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestado->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestado->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestado ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new CompraEstado();
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']);
                    $objCompra->cargar();
                    $objCompraEstadoTipo = new CompraEstadoTipo();
                    $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
                    $objCompraEstadoTipo->cargar();
                    $obj->setear($row['idcompraestado'],$objCompra,$objCompraEstadoTipo,$row['cefechaini'], $row['cefechafin']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestado->listar: ".$base->getError());
        }
        return $arreglo;
    }

}
?>