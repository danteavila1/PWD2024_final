<?php
include_once '/xampp/htdocs/PWD2024_final/modelo/Producto.php';

class AbmProducto
{

    private function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('pronombre', $param)) {
            $obj = new Producto();
            $idProducto = $param['idproducto'] ?? null;
            $proNombre = $param['pronombre'];
            $proDetalle = $param['prodetalle'];
            $proCantStock = $param['procantstock'];
            $proImagen = $param['proimagen'];
            $proPrecio = $param['proprecio'];
            $obj->setear($idProducto, $proNombre, $proDetalle, $proCantStock, $proImagen, $proPrecio);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idproducto'])) {
            $obj = new Producto();
            $obj->setear($param['idproducto'], null, null, null, null, null);
        }

        return $obj;
    }

    private function seteadosCamposClaves($param)
    {

        $resp = false;
        if (isset($param['idproducto']))
            $resp = true;
        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        $param['idproducto'] = null;

        // Creo el objeto producto y le doy valores
        $objProducto = $this->cargarObjeto($param);
        if ($objProducto != null && $objProducto->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjetoConClave($param);

            // verEstructura($objProducto);
            if ($objProducto != null && $objProducto->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjeto($param);
            if ($objProducto != null && $objProducto->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idproducto'])) $where .= " and idproducto = " . $param['idproducto'];
            if (isset($param['pronombre'])) $where .= " and pronombre ='" . $param['pronombre'] . "'";
            if (isset($param['prodetalle'])) $where .= " and prodetalle ='" . $param['prodetalle'] . "'";
            if (isset($param['procantstock'])) $where .= " and procantstock =" . $param['procantstock'];
            if (isset($param['proimagen'])) $where .= " and proimagen ='" . $param['proimagen'] . "'";
            if (isset($param['proprecio'])) $where .= " and proprecio ='" . $param['proprecio'] . "'";
        }

        return Producto::listar($where);
    }

    /**
     * Se encarga de guardar la imagen en la carpeta 'images'
     * Retorna 3 posibles respuestas en forma de array. (1- misma imagen o ninguna. 2- imagen guardada. 3- no se guardó imagen)
     * @return array $response
     */
    public function guardarImagen()
    {
        // Si ingresa la misma imagen o si no hay ninguna
        $response = ['mensaje' => 1];

        if (isset($_FILES['proimagen']) && $_FILES['proimagen']['error'] == UPLOAD_ERR_OK) {
            $nombreImagen = $_FILES['proimagen']['name'];
            $rutaTemporal = $_FILES['proimagen']['tmp_name'];

            // Defino la ruta de la imagen
            define('BASE_PATH', realpath(dirname(__FILE__) . '/../vista/images/') . '/');
            $destino = BASE_PATH . $nombreImagen;

            // Lo muevo a la carpeta /images
            if (move_uploaded_file($rutaTemporal, $destino)) {
                $response = ['mensaje' => 2, 'proimagen' => $nombreImagen];
            } else {
                $response = ['mensaje' => 3];
            }
        }

        return $response;
    }

    /**
     * Recibe como parámetro un array con los datos modificados de un producto.
     * Se encarga de verificar si hay alguna imagen para procesar y modoficiar el producto.
     * Retorna array con respuesta.
     * @param array $param
     * @return array $response
     */
    public function modificarProducto($param)
    {
        // Procesa la imagen nueva (si existe)
        $response = $this->guardarImagen();
        $msj = $response['mensaje'];

        // Evalúo respuestas
        if ($msj == 2) {
            $param['proimagen'] = $response['proimagen'];
            if ($this->modificacion($param)) {
                $response = ['mensaje' => 'Modificación exitosa', 'icono' => 'success'];
            } else {
                $response = ['mensaje' => 'Modificación fallida', 'icono' => 'error'];
            }
        } elseif ($msj == 1) {
            if ($this->modificacion($param)) {
                $response = ['mensaje' => 'Modificación exitosa', 'icono' => 'success'];
            } else {
                $response = ['mensaje' => 'Modificación fallida', 'icono' => 'error'];
            }
        } else {
            $response = ['mensaje' => 'Subida de imagen fallida', 'icono' => 'error'];
        }

        return $response;
    }

    /**
     * Recibe como parámetro un array con los datos de un producto.
     * Se encarga de verificar si hay alguna imagen para procesar y dar de alta el producto.
     * Retorna array con respuesta.
     * @param array $param
     * @return array $response
     */
    public function crearProducto($param)
    {
        // Proceso imagen y guardo respuesta
        $response = $this->guardarImagen();
        $msj = $response['mensaje'];

        // Evalúo respuestas
        if ($msj == 2) {
            $param['proimagen'] = $response['proimagen'];
            if ($this->alta($param)) {
                $response = ['mensaje' => 'Alta exitosa', 'icono' => 'success'];
            } else {
                $response = ['mensaje' => 'Alta fallida', 'icono' => 'error'];
            }
        } else {
            $response = ['mensaje' => 'Subida de imagen fallida', 'icono' => 'error'];
        }

        return $response;
    }
}
