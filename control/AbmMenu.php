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
        if (array_key_exists('menombre', $param)) {
            $obj = new Menu();
            $idmenu = $param['idmenu'] ?? null;
            $menombre = $param['menombre'];
            $medescripcion = $param['medescripcion'];
            $melink = $param['melink'];
            $medeshabilitado = $param['medeshabilitado'];
            $obj->setear($idmenu, $menombre, $medescripcion, $melink, $medeshabilitado);
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
            $obj->setIdMenu($param['idmenu']);
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
    public function modificacion($param)
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
            if (isset($param['menombre']))
                $where .= " and menombre ='" . $param['menombre'] . "'";
            if (isset($param['medescripcion']))
                $where .= " and medescripcion ='" . $param['medescripcion'] . "'";
            if (isset($param['melink']))
                $where .= " and melink ='" . $param['melink'] . "'";
        }
        $obj = new Menu();

        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * Recibe como parámetro un idmenu.
     * Deshabilita aplicando un borrado lógico. 
     * Retorna array indicando éxito o fallo de la operación
     * @param array $param
     * @return array $response
     */
    public function deshabilitar($param)
    {
        $menu = $this->buscar($param);
        $param['menombre'] = $menu[0]->getMeNombre();
        $param['medescripcion'] = $menu[0]->getMeDescripcion();
        $param['melink'] = $menu[0]->getMeLink();
        $param['medeshabilitado'] = date('Y-m-d H:i:s');

        if ($this->modificacion($param)) {
            $response = ['mensaje' => 'Borrado lógico exitoso', 'icono' => 'success'];
        } else {
            $response = ['mensaje' => 'Borrado lógico fallido', 'icono' => 'error'];
        }

        return $response;
    }
}
