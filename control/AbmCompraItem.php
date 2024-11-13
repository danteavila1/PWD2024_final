<?php
include_once '/xampp/htdocs/PWD2024_final/modelo/CompraItem.php';
include_once 'AbmProducto.php';
include_once 'AbmCompra.php';

class AbmCompraItem {

    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('idProducto', $param) && array_key_exists('idCompra', $param)) {
            $obj = new CompraItem();
            $idCompraItem = $param['idCompraItem'] ?? null;
            $idProducto = $param['idProducto'];
            $idCompra = $param['idCompra'];
            $ciCantidad = $param['ciCantidad'];
            $obj->setear($idCompraItem, $idProducto, $idCompra, $ciCantidad);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idCompraItem'])) {
            $obj = new CompraItem();
            $obj->setear($param['idCompraItem'], null, null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        return isset($param['idCompraItem']);
    }

    public function alta($param) {
        $resp = false;
        $param['idCompraItem'] = null;
        $objCompraItem = $this->cargarObjeto($param);
        if ($objCompraItem != null && $objCompraItem->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjetoConClave($param);
            if ($objCompraItem != null && $objCompraItem->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjeto($param);
            if ($objCompraItem != null && $objCompraItem->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param) {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idCompraItem'])) $where .= " and idcompraitem = " . $param['idCompraItem'];
            if (isset($param['idProducto'])) $where .= " and idproducto = " . $param['idProducto'];
            if (isset($param['idCompra'])) $where .= " and idcompra = " . $param['idCompra'];
            if (isset($param['ciCantidad'])) $where .= " and cicantidad = " . $param['ciCantidad'];
        }

        return CompraItem::listar($where);
    }
}
?>
