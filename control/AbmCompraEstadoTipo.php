<?php
class AbmCompraEstadoTipo{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

     /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idcompraestadotipo',$param) && array_key_exists('cetdescripcion',$param) && array_key_exists('cetdetalle',$param)){
            $obj = new CompraEstadoTipo();
            $obj->setear($param['idcompraestadotipo'], $param['cetdescripcion'],$param['cetdetalle']); 
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
            array_key_exists('cetdescripcion', $param) &&
            array_key_exists('cetdetalle', $param)
        ) {
            $obj = new CompraEstadoTipo();
            $obj->setCetDescripcion($param['cetdescripcion']); 
            $obj->setCetDetalle($param['cetdetalle']); 
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con el ID del OBJ CompraEstadoTipo.
     * Se utiliza para cargar un OBJ a partir de un ID.
     * @param array $param
     * @return object
     */
    private function cargarObjetoSoloID($param){
        $obj = null;
        if (isset($param['idcompraestadotipo'])) {
            $obj = new CompraEstadoTipo();
            $obj->cargar($param['idcompraestadotipo']);
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
        if (isset($param['idcompraestadotipo'])){
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
        $objCompraEstadoTipo = new CompraEstadoTipo();
        $objCompraEstadoTipo = $this->cargarObjetoSinID($param);

        if ($objCompraEstadoTipo!=null && $objCompraEstadoTipo->insertar()){
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
            $objCompraEstadoTipo = $this->cargarObjetoConClave($param);
            if ($objCompraEstadoTipo !=null && $objCompraEstadoTipo->eliminar()){  
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
            $objCompraEstadoTipo = $this->cargarObjeto($param);
            if($objCompraEstadoTipo !=null && $objCompraEstadoTipo->modificar()){
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
            if  (isset($param['idcompraestadotipo']))
            $where.=" and idcompraestadotipo='".$param['idcompraestadotipo']."'";
            if  (isset($param['cetdescripcion']))
            $where.=" and cetdescripcion ='".$param['cetdescripcion']."'";
            if  (isset($param['cetdetalle']))
            $where.=" and cetdetalle ='".$param['cetdetalle']."'";
        }
        
        $arreglo = CompraEstadoTipo::listar($where);
        
        return $arreglo;
    }
}
?>