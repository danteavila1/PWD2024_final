<?php
class AbmUsuario
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
    public function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('idusuario', $param) && array_key_exists('usnombre', $param) && array_key_exists('usmail', $param)) {
            $obj = new Usuario();

            // Se asigna 'uspass' solo si está presente en $param, sino se asigna 'NULL'
            // Cambio realizado para función modificarUsuario
            $uspass = array_key_exists('uspass', $param) ? $param['uspass'] : NULL;

            $obj->setear($param['idusuario'], $param['usnombre'], $uspass, $param['usmail'], NULL);
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

    /**
     * Esta función verifica si existe el nombre de usuario en la base de datos. 
     * Retorna booleano indicando existencia de dicho usuario.
     * @param array $param
     * @return boolean
     */
    public function existeUsuario($param)
    {
        // Pongo colección de usuarios
        $colUsuarios = $this->buscar("");

        // Datos recibidos del formulario
        $idusuario = $param['idusuario'];
        $usnombreForm = $param['usnombre'];

        // Recorro todos los usuarios para verificar si existe nombre de usuario
        $existe = false;
        foreach ($colUsuarios as $usuario) {
            if ($usuario->getIdUsuario() != $idusuario) {
                if ($usuario->getUsNombre() == $usnombreForm) {
                    $existe = true;
                }
            }
        }

        return $existe;
    }

    /**
     * Esta función verifica si existe el mail en la base de datos. 
     * Retorna booleano indicando existencia de dicho mail.
     * @param array $param
     * @return boolean
     */
    public function existeMail($param)
    {
        // Pongo colección de usuarios
        $colUsuarios = $this->buscar("");

        // Datos recibidos del formulario
        $idusuario = $param['idusuario'];
        $usmailForm = $param['usmail'];

        // Recorro todos los usuarios para verificar si existe nombre de usuario
        $existe = false;
        foreach ($colUsuarios as $usuario) {
            if ($usuario->getIdUsuario() != $idusuario) {
                if ($usuario->getUsMail() == $usmailForm) {
                    $existe = true;
                }
            }
        }

        return $existe;
    }

    /**
     * Recibe como parámetro un nombre de usuario y mail.
     * Verifica si ya están en uso antes de crear una nueva cuenta. 
     * Retorna array con respuestas.
     * @param array $param
     * @return array $response
     */
    public function datosRepetidos($param)
    {
        $nombreForm = $param['usnombre'];
        $mailForm = $param['usmail'];

        $response = ['mensaje' => 'Disponible'];

        // Creo instancia del objeto Usuario
        $objUsuario = new AbmUsuario();
        $colUsuarios = $objUsuario->buscar("");

        // Verifico si existe el nombre de usuario y email existen en la base de datos
        foreach ($colUsuarios as $usuario) {
            $usuarioExistente = $usuario->getUsNombre();
            if ($usuarioExistente == $nombreForm) {
                $response = ['mensaje' => 'Nombre de usuario en uso', 'icono' => 'info'];
            }
            $usuarioExistente = $usuario->getUsMail();
            if ($usuarioExistente == $mailForm) {
                $response = ['mensaje' => 'Mail en uso', 'icono' => 'info'];
            }
        }

        return $response;
    }

    /**
     * Recibe como parámetro los datos de un usuario nuevo.
     * Verifica con datosRepetidos() que dichos datos no existan previamente.
     * Retorna array con respuesta.
     * @param array $param
     * @return array $response
     */
    public function crearUsuario($param)
    {
        // Si no existe, procedo a dar de alta al usuario
        $response = $this->datosRepetidos($param);
        $existe = $response['mensaje'];

        if ($existe == 'Disponible') {

            if ($this->alta($param)) {

                // Busco ID del usuario recién creado
                $usnombre['usnombre'] = $param['usnombre'];
                $colUsuarios = $this->buscar($usnombre);
                $idusuario = $colUsuarios[0]->getIdUsuario();

                //Creo instancia del objeto AbmUsuarioRol
                $objUsuarioRol = new AbmUsuarioRol();

                // Pongo colección de id's de roles recibidos
                $roles = $param['idrol'];

                // Realizo alta con cada uno de los roles
                foreach ($roles as $rol) {
                    // Formo una tupla para darle de alta
                    $tupla = ['idusuario' => $idusuario, 'idrol' => $rol];
                    $objUsuarioRol->alta($tupla);
                }
                $response = ['mensaje' => 'Alta exitosa', 'icono' => 'success'];
            } else {
                $response = ['mensaje' => 'Alta fallida', 'icono' => 'error'];
            }
        }

        return $response;
    }
    /**
     * 
     * Recibe como parámetro los datos de un usuario nuevo.
     * Verifica con datosRepetidos() que dichos datos no existan previamente.
     * Retorna array con respuesta.
     * @param array $param
     * @return array $response
     */
    public function crearCuenta($param)
    {
        // Si no existe, procedo a dar de alta al usuario
        $response = $this->datosRepetidos($param);
        $existe = $response['mensaje'];

        if ($existe == 'Disponible') {

            if ($this->alta($param)) {

                // Busco ID del usuario recién creado
                $usnombre['usnombre'] = $param['usnombre'];
                $colUsuarios = $this->buscar($usnombre);
                $idusuario = $colUsuarios[0]->getIdUsuario();

                //Creo instancia del objeto AbmUsuarioRol
                $objUsuarioRol = new AbmUsuarioRol();

                // Formo una tupla para darle de alta como cliente
                $tupla = ['idusuario' => $idusuario, 'idrol' => 3];
                $objUsuarioRol->alta($tupla);

                $response = ['mensaje' => 'Alta exitosa', 'icono' => 'success'];
            } else {
                $response = ['mensaje' => 'Alta fallida', 'icono' => 'error'];
            }
        }

        return $response;
    }

    /**
     * Se enc
     */
    public function redirigir($param)
    {
        $msj = $param['mensaje'];
        $icono = $param['icono'];

        switch ($msj) {
            case 'Alta exitosa': {
                    header('Location:' . BASE_URL . '/vista/login/formIniciarSesion.php');
                    break;
                }
            case 'Alta fallida': {
                    setcookie("mensaje", $msj, time() + 60, "/");
                    setcookie("icono", $icono, time() + 60, "/");
                    header('Location:' . BASE_URL . '/vista/login/formCrearCuenta.php');
                    break;
                }
            case 'Mail en uso': {
                    setcookie("mensaje", $msj, time() + 60, "/");
                    setcookie("icono", $icono, time() + 60, "/");
                    header('Location:' . BASE_URL . '/vista/login/formIniciarSesion.php');
                    break;
                }
            case 'Nombre de usuario en uso': {
                    setcookie("mensaje", $msj, time() + 60, "/");
                    setcookie("icono", $icono, time() + 60, "/");
                    header('Location:' . BASE_URL . '/vista/login/formIniciarSesion.php');
                }
        }
    }

    /**
     * Recibe como parámetro un array con los datos del usuario modificados.
     * Verifica si el nombre de usuario y el mail están en uso (excluyéndolo a él)
     * Retorna array con respuesta.
     * @param array $param
     * @return array $response
     */
    public function modificarUsuario($param)
    {
        // Compruebo si existe el usuario
        $existeMail = $this->existeMail($param);
        $existeUsuario = $this->existeUsuario($param);

        // Respuestas en caso de que existan los datos
        if ($existeUsuario) {
            $response = ['mensaje' => 'Nombre de usuario existente', 'icono' => 'info'];
        } elseif ($existeMail) {
            $response = ['mensaje' => 'Mail existente', 'icono' => 'info'];
        }

        // Modificación
        if (!$existeMail && !$existeUsuario) {
            if ($this->modificacion($param)) {
                $response = ['mensaje' => 'Modificación exitosa', 'icono' => 'success'];
            } else {
                $response = ['mensaje' => 'No se modificó nada', 'icono' => 'info'];
            }
        }

        return $response;
    }
}
