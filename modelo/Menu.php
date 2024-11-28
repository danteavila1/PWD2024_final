<?php
class Menu
{
    private $idmenu;
    private $menombre;
    private $medescripcion;
    private $melink;
    private $medeshabilitado;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idmenu = "";
        $this->menombre = "";
        $this->medescripcion = "";
        $this->melink = "";
        $this->medeshabilitado = "";
        $this->mensajeoperacion = "";
    }

    public function setear($idmenu, $menombre, $medescripcion, $melink, $medeshabilitado)
    {
        $this->setIdMenu($idmenu);
        $this->setNombreMenu($menombre);
        $this->setMeDescripcion($medescripcion);
        $this->setMeLink($melink);
        $this->setMeDeshabilitado($medeshabilitado);
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

    /* Medodos get y set para $menombre*/
    public function getMeNombre()
    {
        return $this->menombre;
    }
    public function setNombreMenu($menombre)
    {
        $this->menombre = $menombre;
    }

    /* Medodos get y set para $medescripcion*/
    public function getMeDescripcion()
    {
        return $this->medescripcion;
    }
    public function setMeDescripcion($medescripcion)
    {
        $this->medescripcion = $medescripcion;
    }

    /* Medodos get y set para $melink*/
    public function getMeLink()
    {
        return $this->melink;
    }
    public function setMeLink($melink)
    {
        $this->melink = $melink;
    }

    /* Medodos get y set para $medeshabilitado*/
    public function getMeDeshabilitado()
    {
        return $this->medeshabilitado;
    }
    public function setMeDeshabilitado($medeshabilitado)
    {
        $this->medeshabilitado = $medeshabilitado;
    }

    /* Medodos get y set para $mensajeoperacion*/
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
                    $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['melink'], $row['medeshabilitado']);
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

        $sql = "INSERT INTO menu (menombre, medescripcion, melink, medeshabilitado)
        VALUES ('" . $this->getMeNombre() . "', '" . $this->getMeDescripcion() . "', '" . $this->getMeLink() . "', '" . $this->getMeDeshabilitado() . "')";

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

        $sql = "UPDATE menu 
        SET menombre = '" . $this->getMeNombre() . "', 
            medescripcion = '" . $this->getMeDescripcion() . "', 
            melink = '" . $this->getMeLink() . "',
            medeshabilitado = '" . $this->getMeDeshabilitado() . "'  
        WHERE idmenu = " . $this->getIdMenu();

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
                    $obj->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['melink'], $row['medeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        }
        return $arreglo;
    }
}
