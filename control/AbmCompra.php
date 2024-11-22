<?php
include_once '/xampp/htdocs/PWD2024_final/modelo/Compra.php';
include_once 'AbmUsuario.php';

class AbmCompra
{

    private function cargarObjeto($param)
    {
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

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idCompra'])) {
            $obj = new Compra();
            $obj->setear($param['idCompra'], null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param)
    {
        return isset($param['idCompra']);
    }

    public function buscarPorUsuario($idusuario) {
        $where = "idusuario = $idusuario";
        $compra = new Compra();
        $arreglo = $compra->listar($where);
        return $arreglo;
    }

    public function alta($param) {
        $resp = false;
        $compra = new Compra();
        $usuario = new Usuario();
        $usuario->setIdusuario($param['idusuario']);
        $compra->setear($param['idcompra'], $param['cofecha'], $param['idusuario'] );
        if ($compra->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    // public function alta($param)
    // {
    //     $resp = false;
    //     $param['idCompra'] = null;
    //     $objCompra = $this->cargarObjeto($param);
    //     if ($objCompra != null && $objCompra->insertar()) {
    //         $resp = true;
    //     }
    //     return $resp;
    // }

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompra = $this->cargarObjetoConClave($param);
            if ($objCompra != null && $objCompra->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompra = $this->cargarObjeto($param);
            if ($objCompra != null && $objCompra->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idcompra'])) $where .= " and idcompra = " . $param['idcompra'];
            if (isset($param['cofecha'])) $where .= " and cofecha ='" . $param['cofecha'] . "'";
            if (isset($param['idusuario'])) $where .= " and idusuario = " . $param['idusuario'];
        }

        $compra = new Compra();
        $arreglo = $compra->listar($where);
        return $arreglo;
    }
}
