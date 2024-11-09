<?php
class AbmCompraEstado{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

     /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idcompraestado',$param) && 
            array_key_exists('idcompra',$param) && 
            array_key_exists('idcompraestadotipo',$param)&& 
            array_key_exists('cefechaini',$param)&& 
            array_key_exists('cefechafin',$param)){
            $obj = new CompraEstado();
            $objCompra = new Compra();
            $objCompra->setIdCompra($param['idcompra']);
            $objCompra->cargar();
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($param['idcompraestadotipo']);
            $objCompraEstadoTipo->cargar();
            $obj->setear($param['idcompraestado'], $objCompra,$objCompraEstadoTipo,$param['cefechaini'],$param['cefechafin']); 
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto,
     * aunque en este caso no espera un ID. Puede ser utilizado para inserción.
     * @param array $param
     * @return object
     */
    private function cargarObjetoSinID($param){
        $obj = null;
        if (
            array_key_exists('idcompra', $param) &&
            array_key_exists('idcompraestadotipo', $param)
        ) {
            
            $objCompra = new Compra();
            $objCompra->setIdCompra($param['idcompra']);
            $objCompra->cargar();
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($param['idcompraestadotipo']);
            $objCompraEstadoTipo->cargar();

            $obj = new CompraEstado();
            $obj->setear(null,$objCompra,$objCompraEstadoTipo,null,null);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con el ID del OBJ compraestado.
     * Se utiliza para cargar un OBJ a partir de un ID.
     * @param array $param
     * @return object
     */
    private function cargarObjetoSoloID($param){
        $obj = null;
        if (isset($param['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->cargar($param['idcompraestado']);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo se encuentren los campos claves
     * @param array $param
     * @return boolean
     */
    
     private function seteadosCamposClaves($param){
        
        $resp = false;
        if (isset($param['idcompraestado'])){
            $resp = true;
        } 
        return $resp;
    }

    /**
     * Realizamos la inserción de un registro
     * @param array $param
     */
    public function alta($param){
        
        $resp = false;
        $objCompraEstado = new CompraEstado();
        $objCompraEstado = $this->cargarObjetoSinID($param);

        if ($objCompraEstado!=null && $objCompraEstado->insertar()){
            $resp = true;
        }
        
        return $resp;
    }

    /**
     * Realiza la eliminación de una compra.
     * @param array $param
     * @return boolean
     */
    
     public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objCompraEstado = $this->cargarObjetoConClave($param);
            if ($objCompraEstado !=null && $objCompraEstado->eliminar()){  
                $resp = true;
            }
        }
        return $resp;
    }

     /**
     * Realiza la modificación de un objeto.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objCompraEstado = $this->cargarObjeto($param);
            if($objCompraEstado !=null && $objCompraEstado->modificar()){
                $resp = true;
                
            }
        }
        return $resp;
    }

     /**
     * Realiza la busqueda de un objeto
     * @param array $param
     * @return boolean
     */
    
     public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idcompraestado']))
            $where.=" and idcompraestado='".$param['idcompraestado']."'";
            if  (isset($param['idcompra']))
            $where.=" and idcompra ='".$param['idcompra']."'";
            if  (isset($param['idcompraestadotipo']))
            $where.=" and idcompraestadotipo ='".$param['idcompraestadotipo']."'";
            if  (isset($param['cefechaini']))
            $where.=" and cefechaini ='".$param['cefechaini']."'";
            if  (isset($param['cefechafin']))
            $where.=" and cefechafin ='".$param['cefechafin']."'";
        }
        
        $arreglo = CompraEstado::listar($where);
        
        return $arreglo;
    }

}
?>