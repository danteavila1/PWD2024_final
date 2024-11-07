<?php
class AbmUsuario
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */

    public function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('usnombre', $param) && array_key_exists('uspass', $param) && array_key_exists('usmail', $param)) {

            $obj = new Usuario();

            $obj->setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], NULL);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idusuario'])) {
            $obj = new Usuario();
            $obj->setear($param['idusuario'], null, null, null, null);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto,
     * aunque en este caso no espera un ID. Puede ser utilizado para inserción.
     * @param array $param
     * @return object
     */
    private function cargarObjetoSinID($param)
    {
        $obj = null;
        if (
            array_key_exists('usnombre', $param) &&
            array_key_exists('uspass', $param) &&
            array_key_exists('usmail', $param)
        ) {
            $obj = new Usuario();
            $obj->setear(null, $param['usnombre'], $param['uspass'], $param['usmail'], null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {

        $resp = false;
        if (isset($param['idusuario']))

            $resp = true;
        return $resp;
    }

    /**
     *
     * @param array $param
     */
    public function alta($param)
    {

        $resp = false;
        $elObjtUsuario = new Usuario();
        $elObjtUsuario = $this->cargarObjetoSinID($param);
        if ($elObjtUsuario != null && $elObjtUsuario->insertar()) {
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

        $resp = false;

        if ($this->seteadosCamposClaves($param)) {

            $elObjtUsuario = $this->cargarObjetoConClave($param);

            if ($elObjtUsuario != null and $elObjtUsuario->eliminar()) {

                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Permite modificar un usuario en la base de datos.
     * @param array $param Arreglo con los datos a actualizar.
     * @return boolean Devuelve true si la modificación fue exitosa, de lo contrario false.
     */
    public function modificacion($param)
    {
        $resp = false;
        // Verificar que el arreglo contiene los datos necesarios
        if (isset($param['idusuario'])) {

            $usuarioActualizado = $this->cargarObjeto($param);
            // Verificar si se cargó correctamente el objeto
            if ($usuarioActualizado !== null) {
                if ($usuarioActualizado->modificar()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }


    /**
     * permite buscar un objeto
     * @param array $param
     * @return object
     */

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario'])) {
                $where .= " and idusuario ='" . $param['idusuario'] . "'";
            }
            if (isset($param['usnombre'])) {
                $where .= " and usnombre='" . $param['usnombre'] . "'";
            }
            if (isset($param['uspass'])) {
                $where .= " and uspass='" . $param['uspass'] . "'";
            }
            if (isset($param['usmail'])) {
                $where .= " and usmail ='" . $param['usmail'] . "'";
            }
            if (isset($param['usdeshabilitado'])) {
                $where .= " and usdeshabilitado ='" . $param['usdeshabilitado'] . "'";
            }
        }
        $objUsuario = new Usuario();
        $arreglo = $objUsuario->listar($where);

        return $arreglo;
    }

    /**
     * Recibe un arreglo indexado que contiene los criterios de busqueda
     * Devuelve un arreglo con la información de todos los objetos que cumplan la condición
     * recibida por parámetro
     * @param array $param
     * @return array
     */
    public function buscarColInfo($param)
    {
        $colInfo = array();
        $arregloObj = $this->buscar($param);

        if (count($arregloObj) > 0) {

            for ($i = 0; $i < count($arregloObj); $i++) {
                $colInfo[$i] = $arregloObj[$i]->obtenerInfo();
            }
        }
        return $colInfo;
    }
}
