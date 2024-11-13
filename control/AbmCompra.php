<?php
include_once '/xampp/htdocs/PWD2024_final/modelo/Compra.php';
include_once 'AbmUsuario.php';

class AbmCompra {

    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('idUsuario', $param)) {
            $obj = new Compra();
            $abmUsuario = new AbmUsuario();
            $array = [];
            $array['idusuario'] = $param['idUsuario'];
            $listaUsuarios = $abmUsuario->buscar($array);
            $objUsuario = $listaUsuarios[0];
            $idCompra = $param['idCompra'] ?? null;
            $coFecha = $param['coFecha'] ?? null;
            $obj->setear($idCompra, $coFecha, $objUsuario);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idCompra'])) {
            $obj = new Compra();
            $obj->setear($param['idCompra'], null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        return isset($param['idCompra']);
    }

    public function alta($param) {
        $resp = false;
        $param['idCompra'] = null;
        $objCompra = $this->cargarObjeto($param);
        if ($objCompra != null && $objCompra->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompra = $this->cargarObjetoConClave($param);
            if ($objCompra != null && $objCompra->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompra = $this->cargarObjeto($param);
            if ($objCompra != null && $objCompra->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param) {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idCompra'])) $where .= " and idcompra = " . $param['idCompra'];
            if (isset($param['coFecha'])) $where .= " and cofecha ='" . $param['coFecha'] . "'";
            if (isset($param['idUsuario'])) $where .= " and idusuario = " . $param['idUsuario'];
        }

        return Compra::listar($where);
    }
}
?>


