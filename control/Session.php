<?php


class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function iniciar($nombreUsuario, $pswUsuario)
    {
        $resp = false;
        if ($this->activa() && $this->validar($nombreUsuario, $pswUsuario)) {
            $_SESSION['usnombre'] = $nombreUsuario;
            $user = $this->getUsuario();
            $_SESSION['idusuario'] = $user->getIdUsuario();
            $resp = true;
        }
        return $resp;
    }

    public function activa()
    {

        // $resp = false;
        // if (php_sapi_name() !== 'cli') {
        //     if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
        //         $resp = session_status() === PHP_SESSION_ACTIVE ? true : false;
        //     } else {
        //         $resp = session_id() === '' ? false : true;
        //     }
        // }
        // return  $resp;




        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                //compara la version de php para ver si se puede usar el metodo session_status()
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                //si la version es menor se fija comparando el id de la session actual, para ver si esta seteada.

                return session_id() === '' ? false : true;
            }
        }

        return false;
    }

    public function validar($usNombre, $usPsw)
    {

        //Viene por parametro el nombre de usuario y la contraseña encriptada
        $resp = false;
        if ($this->activa()) {
            $objAbmUsuario = new AbmUsuario();
            $param = ["usnombre" => $usNombre, "uspass" => $usPsw];
            $listaUsuario = $objAbmUsuario->buscar($param);
            if (!empty($listaUsuario)) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function getUsuario()
    {
        //Método privado para no devolver el usuario fuera de la clase Session
        $user = null;
        if ($this->activa() && isset($_SESSION['usnombre'])) {
            $objAbmUsuario = new AbmUsuario();
            $param['usnombre'] = $_SESSION['usnombre'];
            $listaUsuario = $objAbmUsuario->buscar($param);
            $user = $listaUsuario[0];
        }
        return $user;
    }



    /**
     * Se encarga de destruir una sesión activa
     */
    public function cerrar()
    {
        //Primero me fijo si esta activa la session
        if ($this->activa()) {
            //elimino sus datos
            unset($_SESSION['idusuario']);
            unset($_SESSION['usnombre']);
            unset($_SESSION['usmail']);
            unset($_SESSION['usdeshabilitado']);
            // unset($_SESSION['rolactivodescripcion']);
            // unset($_SESSION['rolactivoid']);
            //destruyo la session
            session_destroy();
        }
    }


    public function getRoles()
    {
        //Devuelve un arreglo con los objetos rol del user
        $roles = [];
        $user = $this->getUsuario();
        if ($user != null) {
            //Primero busco la instancia de UsuarioRol
            $objAbmUsuarioRol = new AbmUsuarioRol();
            //Creo el parametro con el id del usuario
            $parametroUser = array('idusuario' => $user->getIdUsuario());
            $listaUsuarioRol = $objAbmUsuarioRol->buscar($parametroUser);
            foreach ($listaUsuarioRol as $tupla) {
                array_push($roles, $tupla->getObjRol());
            }
        }
        return $roles;
    }

    public function verificarPagSegura()
    {
        $puedePasar = false;

        if ($this->activa()) {
            $roles = $this->getRoles();
            $usuario = $this->getUsuario();


            $direccion = $_SERVER['PHP_SELF'];
            $direccion2 = substr($direccion, strpos($direccion, 'vista'), strlen($direccion));


            $menu = new AbmMenu();
            $param = ['melink' => $direccion2];
            $menues = $menu->buscar($param);


            if (count($menues) == 1) {
                $menuRol = new AbmMenuRol();


                foreach ($roles as $rol) {
                    $param = ['idmenu' => $menues[0]->getIdMenu(), 'idrol' => $rol->getIdRol()];
                    $menuesRol = $menuRol->buscar($param);

                    if (!empty($menuesRol)) {
                        $puedePasar = true;
                        break;
                    }
                }
            }
        }

        return $puedePasar;
    }

    /**
     * 
     */
    public function iniciarSesion($param)
    {
        $response = ['mensaje' => 'Datos incorrectos', 'icono' => 'error'];
        $usnombre = $param['usnombre'];
        $objUsuario = new AbmUsuario();
        $colUsuarios = $objUsuario->buscar(['usnombre' => $usnombre]);
        $coincidencia = $colUsuarios[0];

        if (isset($coincidencia)) {
            $usdeshabilitado = $colUsuarios[0]->getUsDeshabilitado();

            if ($usdeshabilitado === '0000-00-00 00:00:00') {
                $uspass = $param['uspass'];
                if ($this->iniciar($usnombre, $uspass)) {
                    $response = ['mensaje' => 'Bienvenido', 'icono' => 'success'];
                }
            } else {
                $response = ['mensaje' => 'Usuario deshabilitado', 'icono' => 'question'];
            }
        }

        return $response;
    }

    public function loguear($param)
    {
        $response = $this->iniciarSesion($param);
        $msj = $response['mensaje'];

        if ($msj == 'Bienvenido') {
            header('Location:' . BASE_URL . '/vista/inicio.php');
        } elseif ($msj == 'Usuario deshabilitado') {
            setcookie("mensaje", "La cuenta se encuentra deshabilitada", time() + 60, "/");
            setcookie("icono", "question", time() + 60, "/");
            header('Location:' . BASE_URL . '/vista/login/formIniciarSesion.php');
        } else {
            setcookie("mensaje", "Usuario o contraseña incorrectos", time() + 60, "/");
            setcookie("icono", "error", time() + 60, "/");
            header('Location:' . BASE_URL . '/vista/login/formIniciarSesion.php');
        }


        return $response;
    }
}
