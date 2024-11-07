<?php
class AbmMenu
{
    /**
     * @param array 
     * @return Menu
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (
            array_key_exists('idmenu', $param) && array_key_exists('nombremenu', $param) && array_key_exists('archivomenu', $param)
            && array_key_exists('idusuariorol', $param)
        ) {
            $obj = new Menu();

            if ($param['idusuariorol'] == null) {
                $objUsuarioRol = null;
            } else {
                $objUsuarioRol = new Menu();
                $objUsuarioRol->setIdMenu($param['idusuariorol']);
                $objUsuarioRol->cargar();
            }

            $obj->setear($param['idmenu'], $param['nombremenu'], $param['archivomenu'], $objUsuarioRol);
        }
        return $obj;
    }

    /**
     * @param array $param
     * @return Menu
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idmenu'])) {
            $obj = new Menu();
            $obj->setIdmenu($param['idmenu']);
        }
        return $obj;
    }

    /**
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idmenu']))
            $resp = true;
        return $resp;
    }

    /**
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idmenu'] = null;

        $menu = $this->cargarObjeto($param);
        if ($menu !== null && $menu->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $menu = $this->cargarObjetoConClave($param);
            if ($menu != null && $menu->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }

    /**
     * @param array $param
     * @return boolean
     */
    public function modificar($param)
    {

        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $menu = $this->cargarObjeto($param);
            if ($menu != null && $menu->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    // /* permite actualizar la fecha de baja del usuario */
    // public function borradoLogico($param)
    // {

    //     $resp = false;
    //     if ($this->seteadosCamposClaves($param)) {
    //         $unObjUsuario = $this->cargarObjetoConClave($param);
    //         $unObjUsuario->deshabilitar();
    //     }
    //     return $resp;
    // }

    /**
     * @param array $param
     * @return array<Menu>
     */
    public function buscar($param = [])
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idmenu']))
                $where .= " and idmenu =" . $param['idmenu'];
            if (isset($param['nombremenu']))
                $where .= " and nombremenu ='" . $param['nombremenu'] . "'";
            if (isset($param['idusuariorol']))
                $where .= " and idusuariorol =" . $param['idusuariorol'];
        }
        $obj = new Menu();

        $arreglo = $obj->listar($where);
        return $arreglo;
    } //Cambios

}
