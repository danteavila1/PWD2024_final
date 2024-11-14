<?php
include_once '/xampp/htdocs/PWD2024_final/modelo/Producto.php';

class AbmProducto {

    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('pronombre', $param)) {
            $obj = new Producto();
            $idProducto = $param['idProducto'] ?? null;
            $proNombre = $param['pronombre'];
            $proDetalle = $param['prodetalle'];
            $proCantStock = $param['procantstock'];
            $proImagen = $param['proimagen'];
            $proPrecio = $param['proprecio'];
            $obj->setear($idProducto, $proNombre, $proDetalle, $proCantStock, $proImagen, $proPrecio);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idProducto'])) {
            $obj = new Producto();
            $obj->setear($param['idProducto'], null, null, null, null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        return isset($param['idProducto']);
    }

    public function alta($param) {
        $resp = false;
        $param['idProducto'] = null;

        // Creo el objeto producto y le doy valores
        $objProducto = $this->cargarObjeto($param);
        if ($objProducto != null && $objProducto->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjetoConClave($param);
            if ($objProducto != null && $objProducto->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param) {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjeto($param);
            if ($objProducto != null && $objProducto->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param) {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idProducto'])) $where .= " and idproducto = " . $param['idProducto'];
            if (isset($param['pronombre'])) $where .= " and pronombre ='" . $param['pronombre'] . "'";
            if (isset($param['prodetalle'])) $where .= " and prodetalle ='" . $param['prodetalle'] . "'";
            if (isset($param['procantstock'])) $where .= " and procantstock =" . $param['procantstock'];
            if (isset($param['proimagen'])) $where .= " and proimagen ='" . $param['proimagen'] . "'";
            if (isset($param['proprecio'])) $where .= " and proprecio ='" . $param['proprecio'] . "'";
        }

        return Producto::listar($where);
    }
}
?>
