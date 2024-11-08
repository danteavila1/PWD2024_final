<?php

class abmCompra {

    public function abm($datos) {
        $resp = false;
        switch ($datos['accion']) {
            case 'editar':
                $resp = $this->modificacion($datos);
                break;
            case 'borrar':
                $resp = $this->baja($datos);
                break;
            case 'nuevo':
                $resp = $this->alta($datos);
                break;
        }
        return $resp;
    }

    /**
     * Cargar un objeto Compra con los datos proporcionados
     * @param array $param
     * @return Compra|null
     */
    private function cargarObjeto($param) {
        $obj = null;
        if (isset($param['idcompra'], $param['cofecha'], $param['usuario'])) {
            $obj = new Compra();
            $obj->cargar($param['idcompra'], $param['cofecha'], $param['usuario']);
        }
        return $obj;
    }

    /**
     * Cargar un objeto Compra con solo la clave primaria
     * @param array $param
     * @return Compra|null
     */
    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idcompra'])) {
            $obj = new Compra();
            $obj->cargar($param['idcompra'], null, null);
        }
        return $obj;
    }

    /**
     * Verificar que los campos clave estén seteados en el array $param
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param) {
        return isset($param['idcompra']);
    }

    /**
     * Insertar un nuevo objeto Compra
     * @param array $param
     * @return boolean
     */
    public function alta($param) {
        $resp = false;
        $param['idcompra'] = null;
        $obj = $this->cargarObjeto($param);
        if ($obj !== null && $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Eliminar un objeto Compra
     * @param array $param
     * @return boolean
     */
    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj !== null && $obj->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modificar un objeto Compra
     * @param array $param
     * @return boolean
     */
    public function modificacion($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj !== null && $obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Buscar objetos Compra que coincidan con los parámetros proporcionados
     * @param array|null $param
     * @return array
     */
    public function buscar($param = null) {
        $where = "true";
        if ($param !== null) {
            if (isset($param['idcompra'])) {
                $where .= " AND idcompra = '{$param['idcompra']}'";
            }
            if (isset($param['cofecha'])) {
                $where .= " AND cofecha = '{$param['cofecha']}'";
            }
            if (isset($param['idusuario'])) {
                $where .= " AND idusuario = '{$param['idusuario']}'";
            }
        }
        $obj = new Compra();
        return $obj->listar($where);
    }

    /**
     * Listar todas las compras agrupadas por estado (excluyendo las en estado "carrito")
     * @return array
     */
    public function obtenerComprasPorTodosLosEstados() {
        return [
            "porconfirmar" => CompraEstado::obtenerComprasPorEstadoSerializadas(COMPRA_PORCONFIRMAR),
            "confirmadas" => CompraEstado::obtenerComprasPorEstadoSerializadas(COMPRA_CONFIRMADA),
            "enviadas" => CompraEstado::obtenerComprasPorEstadoSerializadas(COMPRA_ENVIADA),
            "canceladas" => CompraEstado::obtenerComprasPorEstadoSerializadas(COMPRA_CANCELADA),
        ];
    }

    /**
     * Listar todas las compras en formato JSON
     */
    public function listarCompras() {
        $compras = $this->buscar();
        $compraJSON = array_map(fn($compra) => $compra->jsonSerialize(), $compras);
        handleResponse($compraJSON);
    }

    /**
     * Obtener el último estado de una compra
     * @param Compra $compra
     * @return CompraEstado
     */
    public function obtenerUltimoEstadoCompra($compra) {
        $arr_estados = $compra->getEstados();
        $ultimo_estado = end($arr_estados) ?: new CompraEstado();
        
        if ($ultimo_estado === false) {
            $ultimo_estado->setCompraEstadoTipo(new CompraEstadoTipo());
            $ultimo_estado->getCompraEstadoTipo()->setIdCompraEstadoTipo(COMPRA_EN_CARRITO);
        }
        return $ultimo_estado;
    }

    /**
     * Calcular el total de la compra
     * @param Compra $compra
     * @return float
     */
    public function obtenerTotalCompra($compra) {
        return array_reduce($compra->getItems(), fn($total, $item) => $total + $item->getProducto()->getPrecio() * $item->getCiCantidad(), 0);
    }

    /**
     * Obtener la cantidad total de items en la compra
     * @param Compra $compra
     * @return int
     */
    public function obtenerCantItemsCompra($compra) {
        return array_reduce($compra->getItems(), fn($cantItems, $item) => $cantItems + $item->getCiCantidad(), 0);
    }

    /**
     * Listar las compras de un usuario en formato JSON
     * @param Usuario $idusuario
     * @return array
     */
    public function obtenerComprasJSON($idusuario) {
        $arr_compras = Compra::listar("idusuario = " . $idusuario->getIdUsuario());
        $salida = [];

        foreach ($arr_compras as $compra) {
            $estado = $this->obtenerUltimoEstadoCompra($compra);
            if ($estado->getCompraEstadoTipo()->getIdCompraEstadoTipo() != COMPRA_EN_CARRITO) {
                $total = $this->obtenerTotalCompra($compra);
                $cantItems = $this->obtenerCantItemsCompra($compra);
                $comp = [
                    "idcompra" => $compra->getIdCompra(),
                    "cofecha" => $compra->getCoFecha(),
                    "cantitems" => $cantItems,
                    "total" => $total,
                    "estado" => $estado->getCompraEstadoTipo()->getCetDescripcion(),
                    "acciones" => renderBotonesAccionesCompra($compra->getIdCompra())
                ];
                $salida[] = $comp;
            }
        }
        return $salida;
    }

}


