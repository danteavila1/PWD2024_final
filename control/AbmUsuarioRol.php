<?php
class AbmUsuarioRol
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */

    private function cargarObjeto($param)
    {

        $objRol = null;
        $objUsuario = null;

        if (array_key_exists('idrol', $param) and $param['idrol'] != null) {
            $objRol = new Rol();
            $objRol->setIdrol($param['idrol']);
            $objRol->cargar();
        }

        if (array_key_exists('idusuario', $param) && $param['idusuario'] != null) {
            $objUsuario = new Usuario();
            $objUsuario->setIdUsuario($param['idusuario']);
            $objUsuario->cargar();
        }

        $objUsuarioRol = new UsuarioRol();
        $objUsuarioRol->setear($objUsuario, $objRol);


        return $objUsuarioRol;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $objUsuarioRol = null;

        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $objUsuario = new Usuario();
            $colUsuario = $objUsuario->listar($param['idusuario']);

            $objRol = new Rol();
            $colRol = $objRol->listar($param['idrol']);

            $objUsuarioRol = new UsuarioRol();
            $objUsuarioRol->setear($colUsuario[0], $colRol[0]);
        }
        return $objUsuarioRol;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {

        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol']));

        $resp = true;
        return $resp;
    }

    /**
     *
     * @param array $param
     */
    public function alta($param)
    {

        //  echo "entramos a alta";

        $resp = false;
        $objUsuarioRol = $this->cargarObjeto($param);
        // verEstructura($elObjtAuto);

        //print_r($objUsuarioRol);
        if ($objUsuarioRol != null and $objUsuarioRol->insertar()) {
            $resp = true;
        }

        return $resp;
    }

    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */

    public function baja($param)
    {
        //verEstructura($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {

            $objUsuarioRol = $this->cargarObjeto($param);

            if ($objUsuarioRol != null and $objUsuarioRol->eliminar()) {

                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        //print_R($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {

            $objUsuarioRol = $this->cargarObjeto($param);

            if ($objUsuarioRol != null and $objUsuarioRol->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    /**
     * permite buscar un objeto
     */

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario']))
                $where .= " and idusuario='" . $param['idusuario'] . "'";
            if (isset($param['idrol']))
                $where .= " and idrol ='" . $param['idrol'] . "'";
        }

        $arreglo = UsuarioRol::listar($where);
        return $arreglo;
    }

    /**
     * Recibe como parámetro el id de usuario y un array con roles.
     * Se encarga de modificar los roles, quitando o añadiendo roles.
     * Retorna array con respuesta.
     * @param array $param
     * @return array $response
     */
    public function cambiarRoles($param)
    {
        $idusuario = $param['idusuario'];
        $nuevosRoles = $param['idrol'];

        // Creo parámetro de búsqueda
        $usuario = ['idusuario' => $idusuario];

        // Obtengo los roles actuales del usuario
        $rolesActuales = $this->buscar($usuario);

        $rolesActualesIds = [];
        foreach ($rolesActuales as $rolActual) {
            $rolesActualesIds[] = $rolActual->getObjRol()->getIdRol();
        }

        // Determino los roles a agregar y a eliminar
        $agregarRoles = array_diff($nuevosRoles, $rolesActualesIds);
        $eliminarRoles = array_diff($rolesActualesIds, $nuevosRoles);

        // Agrego los nuevos roles
        foreach ($agregarRoles as $idRol) {
            $datos = ['idusuario' => $idusuario, 'idrol' => $idRol];
            $this->alta($datos);
        }

        // Elimino los roles quitados
        foreach ($eliminarRoles as $idRol) {
            $datos = ['idusuario' => $idusuario, 'idrol' => $idRol];
            $this->baja($datos);
        }

        $response = ['mensaje' => 'Roles modificados', 'icono' => 'success'];
        return $response;
    }
}
