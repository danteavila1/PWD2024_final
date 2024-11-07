<?php
class Menu
{
    private $idmenu;
    private $nombremenu;
    private $archivomenu;
    private $idusuariorol;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idmenu = "";
        $this->nombremenu = "";
        $this->archivomenu = "";
        $this->idusuariorol = null;
        $this->mensajeoperacion = "";
    }

    public function setear($idmenu, $nombremenu, $archivomenu, $objUsuarioRol)
    {
        $this->setIdMenu($idmenu);
        $this->setNombreMenu($nombremenu);
        $this->setArchivoMenu($archivomenu);
        $this->setObjUsuarioRol($objUsuarioRol);
    }

    /* Medodos get y set para $idmenu*/
    public function getIdMenu()
    {
        return $this->idmenu;
    }
    public function setIdMenu($idmenu)
    {
        $this->idmenu = $idmenu;
    }

    /* Medodos get y set para $nombremenu*/
    public function getNombreMenu()
    {
        return $this->nombremenu;
    }
    public function setNombreMenu($nombremenu)
    {
        $this->nombremenu = $nombremenu;
    }

    /* Medodos get y set para $archivomenu*/
    public function getArchivoMenu()
    {
        return $this->archivomenu;
    }
    public function setArchivoMenu($archivomenu)
    {
        $this->archivomenu = $archivomenu;
    }

    /* Medodos get y set para $idusuariorol*/
    /**
     * @return new UsuarioRol
     */
    public function getObjUsuarioRol()
    {
        return $this->idusuariorol;
    }
    public function setObjUsuarioRol($idusuariorol)
    {
        $this->idusuariorol = $idusuariorol;
    }

    /* Medodos get y set para mensajeoperacion*/
    public function getMensajeOperacion()
    {
        return $this->mensajeoperacion;
    }
    public function setMensajeOperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    /**
     * Recupera los datos del usuario por idusuario
     * @param int $idusuario
     * @return true en caso de encontrar los datos, false en caso contrario 
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu WHERE idmenu = " . $this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $objidusuariorol = null;
                    if ($row['idusuariorol'] != null or $row['idusuariorol'] != '') {
                        $objidusuariorol = new Menu();
                        $objidusuariorol->setIdMenu($row['idusuariorol']);
                        $objidusuariorol->cargar();
                    }
                    $this->setear($row['idmenu'], $row['nombremenu'], $row['archivomenu'], $objidusuariorol);
                }
            } else {
                $this->setMensajeOperacion("Menu->listar: " . $base->getError());
            }
        }
        return $resp;
    }

    /**
     * Esta función lee los valores actuales de los atributos del objeto e inserta un nuevo
     * registro en la base de datos a partir de ellos.
     * Retorna un booleano que indica si le operación tuvo éxito
     * 
     * @return boolean
     */
    public function insertar()
    {

        $resp = false;
        $base = new BaseDatos();

        // $idusuariorol[0] = ",";
        // $idusuariorol[1] = ",";


        // if ($this->getObjUsuarioRol() != null && $this->getObjUsuarioRol()->getIdRol() != "") {
        //     $idusuariorol[0] = ",idusuariorol,";
        //     $idusuariorol[1] = ",idusuariorol = '" . $this->getObjUsuarioRol()->getIdRol() . "',";
        // }
        $idusuariorol = $this->getObjUsuarioRol()->getIdRol();

        $sql = "INSERT INTO menu(nombremenu, archivomenu, idusuariorol)
        VALUES ('" . $this->getNombreMenu() . "', '" . $this->getarchivomenu() . "'" . $idusuariorol;

        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdMenu($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Esta función lee los valores actuales de los atributos del objeto y los actualiza en la
     * base de datos.
     * Retorna un booleano que indica si le operación tuvo éxito
     * 
     * @return boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();

        $sql = "UPDATE menu SET nombremenu= '" . $this->getNombreMenu() . "', archivomenu = '" . $this->getArchivoMenu() . "' 
        ,idusuariorol = '" . $this->getObjUsuarioRol()->getIdRol() . " WHERE idmenu = " . $this->getIdMenu() . "";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Esta función lee el id actual del objeto y si puede lo borra de la base de datos
     * Retorna un booleano que indica si le operación tuvo éxito
     * 
     * @return boolean
     */
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();

        $sql = "DELETE FROM menu WHERE idmenu =" . $this->getIdMenu();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->eliminar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Esta función recibe condiciones de busqueda en forma de consulta sql para obtener
     * los registros requeridos.
     * Si por parámetro se envía el valor "" se devolveran todos los registros de la tabla
     * 
     * La función devuelve un arreglo compuesto por todos los objetos que cumplen la condición indicada
     * por parámetro
     * 
     * @return array
     */
    public function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();

        $sql = "SELECT * FROM menu ";

        if ($parametro != "") {
            $sql .= ' WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);

        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $obj = new Menu();
                    $objidusuariorol = null;
                    if ($row['idusuariorol'] != null) {
                        $objidusuariorol = new Menu();
                        $objidusuariorol->setIdMenu($row['idusuariorol']);
                        $objidusuariorol->cargar();
                    }
                    $obj->setear($row['idmenu'], $row['nombremenu'], $row['archivomenu'], $objidusuariorol);
                    array_push($arreglo, $obj);
                }
            }
        }
        return $arreglo;
    }

    // /**
    //  * Funcion desabilitar
    //  * Esta función Actualiza el valor de medeshabilitado por un string fecha actual
    //  *
    //  **/
    // public function deshabilitar()
    // {
    //     $resp = false;
    //     $base = new BaseDatos();

    //     $fechaBaja = date('Y-m-d H:i:s');

    //     // Actualiza el valor de usdeshabilitado
    //     $sql = "UPDATE menu SET medeshabilitado = '" . $fechaBaja . "' WHERE idmenu = " . $this->getIdMenu();

    //     if ($base->Iniciar()) {
    //         if ($base->Ejecutar($sql)) {
    //             return true;
    //         } else {
    //             $this->setMensajeOperacion("menu->deshabilitar: " . $base->getError());
    //         }
    //     } else {
    //         $this->setMensajeOperacion("menu->deshabilitar: " . $base->getError());
    //     }

    //     return $resp;
    // }

    // /**
    //  * Esta función lee todos los valores de todos los atributos del objeto y los devuelve
    //  * en un arreglo asociativo
    //  * 
    //  * @return array
    //  */
    // public function obtenerInfo()
    // {
    //     $info = [];
    //     $info['idmenu'] = $this->getObjUsuarioRol()->getIdRol();
    //     $info['nombremenu'] = $this->getNombreMenu();
    //     $info['archivomenu'] = $this->getarchivomenu();
    //     $info['medeshabilitado'] = $this->getMeDeshabilitado();
    //     return $info;
    // }
}
