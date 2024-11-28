<?php
include_once('Mail.php');

class AbmCompraEstado
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (
            array_key_exists('idcompraestado', $param) &&
            array_key_exists('idcompra', $param) &&
            array_key_exists('idcompraestadotipo', $param) &&
            array_key_exists('cefechaini', $param) &&
            array_key_exists('cefechafin', $param)
        ) {
            $obj = new CompraEstado();
            $objCompra = new Compra();
            $objCompra->setIdCompra($param['idcompra']);
            $objCompra->cargar();
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($param['idcompraestadotipo']);
            $objCompraEstadoTipo->cargar();
            $obj->setear($param['idcompraestado'], $objCompra, $objCompraEstadoTipo, $param['cefechaini'], $param['cefechafin']);
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
            array_key_exists('idcompra', $param) &&
            array_key_exists('idcompraestadotipo', $param)
        ) {

            $objCompra = new Compra();
            $objCompra->setIdCompra($param['idcompra']);
            $objCompra->cargar();
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($param['idcompraestadotipo']);
            $objCompraEstadoTipo->cargar();

            $obj = new CompraEstado();
            $obj->setear(null, $objCompra, $objCompraEstadoTipo, null, null);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con el ID del OBJ compraestado.
     * Se utiliza para cargar un OBJ a partir de un ID.
     * @param array $param
     * @return object
     */
    private function cargarObjetoSoloID($param)
    {
        $obj = null;
        if (isset($param['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->cargar($param['idcompraestado']);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo se encuentren los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {

        $resp = false;
        if (isset($param['idcompraestado'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Realizamos la inserción de un registro
     * @param array $param
     */
    public function alta($param)
    {

        $resp = false;
        $objCompraEstado = new CompraEstado();
        $objCompraEstado = $this->cargarObjetoSinID($param);

        if ($objCompraEstado != null && $objCompraEstado->insertar()) {
            $resp = true;
        }

        return $resp;
    }

    /**
     * Realiza la eliminación de una compra.
     * @param array $param
     * @return boolean
     */

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstado = $this->cargarObjetoSinID($param);
            if ($objCompraEstado != null && $objCompraEstado->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Realiza la modificación de un objeto.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstado = $this->cargarObjeto($param);
            if ($objCompraEstado != null && $objCompraEstado->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Realiza la busqueda de un objeto
     * @param array $param
     */

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idcompraestado']))
                $where .= " and idcompraestado='" . $param['idcompraestado'] . "'";
            if (isset($param['idcompra']))
                $where .= " and idcompra ='" . $param['idcompra'] . "'";
            if (isset($param['idcompraestadotipo']))
                $where .= " and idcompraestadotipo ='" . $param['idcompraestadotipo'] . "'";
            if (isset($param['cefechaini']))
                $where .= " and cefechaini ='" . $param['cefechaini'] . "'";
            if (isset($param['cefechafin']))
                $where .= " and cefechafin ='" . $param['cefechafin'] . "'";
        }

        $arreglo = CompraEstado::listar($where);

        return $arreglo;
    }

    /**
     * Manda mail al cliente informando el cambio de estado de su compra
     * @param array $idcompra
     */
    public static function informarCambioEstado($idcompra)
    {
        $objMail = new Mail();
        $objMail->enviarMail($idcompra);
    }

    /**
     * Acepta una compra, actualiza stock de los productos comprados
     */
    public function aceptarCompra($datos)
    {
        $pudo = ['exito' => false, 'msj' => 'Ha ocurrido un error'];

        // Creo parámetro de búsqueda para la compra
        $param['idcompra'] = $datos['idcompra'];
        $param['idcompraestadotipo'] = 1;

        // Busco la compra
        $objCompraEstado = new AbmCompraEstado();
        $compra = $objCompraEstado->buscar($param);

        // Si la compra existe, busco sus ítems
        if (isset($compra)) {

            // Creo instancia de AbmCompraItem y busco los productos
            $objCompraItem = new AbmCompraItem();
            $itemsComprados = $objCompraItem->buscar($datos);

            // Itero sobre los productos para actualizar su stock
            foreach ($itemsComprados as $itemComprado) {

                // Creo instancia AbmProducto y obtengo los datos para modificarlos
                $objProducto = new AbmProducto();
                $idproducto['idproducto'] = $itemComprado->getIdProducto();
                $producto = $objProducto->buscar($idproducto);

                $datosProducto['idproducto'] = $producto[0]->getIdProducto();
                $datosProducto['pronombre'] = $producto[0]->getProNombre();
                $datosProducto['prodetalle'] = $producto[0]->getProDetalle();
                $datosProducto['proimagen'] = $producto[0]->getProImagen();
                $datosProducto['proprecio'] = $producto[0]->getProPrecio();

                // Resto la cantidad comprada del stock actual
                $cantStockActual = $producto[0]->getProCantStock();
                $cantStockComprado = $itemComprado->getCiCantidad();
                $datosProducto['procantstock'] = $cantStockActual - $cantStockComprado;

                if ($datosProducto['procantstock'] < 0) {
                    $nombre = $datosProducto['pronombre'];
                    $pudo = ['exito' => false, 'msj' => 'Stock insuficiente de ' . $nombre];
                    return $pudo;
                } else {
                    // Realizo la resta de stock del producto comprado
                    $pudo = $objProducto->modificacion($datosProducto);
                }
            }

            if ($pudo) {
                // Modifico estado actual de la compra dándole fecha de fin
                $param['idcompraestado'] = $compra[0]->getIdCompraEstado();
                $param['idcompra'] = $compra[0]->getObjCompra()->getIdCompra();
                $param['idcompraestadotipo'] = $compra[0]->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
                $param['cefechaini'] = $compra[0]->getCeFechaIni();
                $param['cefechafin'] = date('Y-m-d H:i:s');
                $objCompraEstado->modificacion($param);

                // Creo nuevo registro de la misma compra con el estado de 'Aceptada'
                $compraAceptada = new AbmCompraEstado();
                $param['idcompraestado'] = 0;
                $param['idcompra'] = $compra[0]->getObjCompra()->getIdCompra();
                $param['idcompraestadotipo'] = 2;
                $param['cefechaini'] = date('Y-m-d H:i:s');
                $param['cefechafin'] = null;
                $compraAceptada->alta($param);

                $pudo = ['exito' => true, 'msj' => 'Compra aceptada'];
                $this->informarCambioEstado($param['idcompra']);
            }
        }

        return $pudo;
    }

    /**
     * Envía una compra, actualiza fecha fin de la compra
     */
    public function enviarCompra($datos)
    {
        $pudo = ['exito' => false, 'msj' => 'No se envió la compra'];

        // Creo parámetro de búsqueda para la compra
        $param['idcompra'] = $datos['idcompra'];
        $param['idcompraestadotipo'] = 2;

        // Busco la compra
        $objCompraEstado = new AbmCompraEstado();
        $compra = $objCompraEstado->buscar($param);

        // Si la compra existe, realizo las actualizaciones
        if (isset($compra)) {

            // Modifico estado actual de la compra dándole fecha de fin
            $param['idcompraestado'] = $compra[0]->getIdCompraEstado();
            $param['idcompra'] = $compra[0]->getObjCompra()->getIdCompra();
            $param['idcompraestadotipo'] = $compra[0]->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
            $param['cefechaini'] = $compra[0]->getCeFechaIni();
            $param['cefechafin'] = date('Y-m-d H:i:s');
            $objCompraEstado->modificacion($param);

            // Creo nuevo registro de la misma compra con el estado de 'Enviada'
            $compraEnviada = new AbmCompraEstado();
            $param['idcompraestado'] = 0;
            $param['idcompra'] = $compra[0]->getObjCompra()->getIdCompra();
            $param['idcompraestadotipo'] = 3;
            $param['cefechaini'] = date('Y-m-d H:i:s');
            $param['cefechafin'] = $param['cefechaini'];
            $compraEnviada->alta($param);

            $pudo = ['exito' => true, 'msj' => 'Compra enviada'];
            $this->informarCambioEstado($param['idcompra']);
        }

        return $pudo;
    }


    /**
     * Cancela una compra, actualiza fecha fin de la compra
     * De ser necesario, también devuelve stock de una compra aceptada
     */
    public function cancelarCompra($datos)
    {
        $pudo = ['exito' => false, 'msj' => 'No se canceló la compra'];

        // Creo parámetro de búsqueda para la compra
        $param['idcompra'] = $datos['idcompra'];

        // Busco la compra
        $objCompraEstado = new AbmCompraEstado();
        $compra = $objCompraEstado->buscar($param);

        // Verifico que la compra exista
        if (isset($compra)) {

            // Itero sobre sus tipos de estado para conseguir el último
            foreach ($compra as $idEstado) {
                $ultimoEstado = $idEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
            }

            // Condición por si la compra está 'aceptada' y debo devolver stock
            if ($ultimoEstado == 2) {

                // Busco los productos de la compra
                $objCompraItem = new AbmCompraItem();
                $itemsComprados = $objCompraItem->buscar($datos);

                // Itero sobre los productos para devolver el stock
                foreach ($itemsComprados as $itemComprado) {

                    // Creo instancia AbmProducto y obtengo los datos para modificarlos
                    $objProducto = new AbmProducto();
                    $idproducto['idproducto'] = $itemComprado->getIdProducto();
                    $producto = $objProducto->buscar($idproducto);

                    $datosProducto['idproducto'] = $producto[0]->getIdProducto();
                    $datosProducto['pronombre'] = $producto[0]->getProNombre();
                    $datosProducto['prodetalle'] = $producto[0]->getProDetalle();
                    $datosProducto['proimagen'] = $producto[0]->getProImagen();
                    $datosProducto['proprecio'] = $producto[0]->getProPrecio();

                    // Sumo la cantidad comprada al stock actual
                    $cantStockActual = $producto[0]->getProCantStock();
                    $cantStockComprado = $itemComprado->getCiCantidad();
                    $datosProducto['procantstock'] = $cantStockActual + $cantStockComprado;

                    // Realizo la suma de stock del producto comprado
                    $pudo = $objProducto->modificacion($datosProducto);
                }
            }

            // Modifico estado actual de la compra dándole fecha de fin
            $param['idcompraestado'] = $compra[0]->getIdCompraEstado();
            $param['idcompra'] = $compra[0]->getObjCompra()->getIdCompra();
            $param['idcompraestadotipo'] = $ultimoEstado;
            $param['cefechaini'] = $compra[0]->getCeFechaIni();
            $param['cefechafin'] = date('Y-m-d H:i:s');
            $objCompraEstado->modificacion($param);

            // Creo nuevo registro de la misma compra con el estado de 'Cancelada'
            $compraEnviada = new AbmCompraEstado();
            $param['idcompraestado'] = 0;
            $param['idcompra'] = $compra[0]->getObjCompra()->getIdCompra();
            $param['idcompraestadotipo'] = 4;
            $param['cefechaini'] = date('Y-m-d H:i:s');
            $param['cefechafin'] = $param['cefechaini'];
            $compraEnviada->alta($param);

            $pudo = ['exito' => true, 'msj' => 'Compra cancelada'];
            $this->informarCambioEstado($param['idcompra']);
        }

        return $pudo;
    }


    public function buscarArray($param)
    {
        $arreglo = [];
        if (is_object($param)) {
            $arreglo = dismount($param);
        } else {
            $arreglo = convert_array($this->buscar($param));
        }
        return $arreglo;
    }


    public function buscarCarroActivo($idusuario)
    {
        $abmCompra = new AbmCompra();
        //busca todas las compras por el id de usario
        $compras = $abmCompra->buscarPorUsuario($idusuario);

        // arreglo para almacenar las compras con estado Iniciado
        $compraEstadoIniciado = array();

        foreach ($compras as $compra) {
            if (count($compras) > 0) {
                // de cada compra específica, obtengo su compraEstado específico
                //$param = ['idcompra' => $compra->getIdCompra(),'cefechafin' => 'is null'];
                $compraEstado = CompraEstado::listar('idcompra ='.$compra->getIdCompra().' and cefechafin is null');
                if (count($compraEstado) > 0) {
                    $objcompraEstado = $compraEstado[0];
                    // si el 'idcompraestadotipo' de este compraEstado es 1, significa que la compra fue iniciada. Por lo que la almacenamos
                    if ($objcompraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() == 5) {
                        array_push($compraEstadoIniciado, $compra);
                    }
                }
            }
        }

        if (count($compraEstadoIniciado) == 0) {
            $compraEstadoIniciado = null;
        }

        return $compraEstadoIniciado;
    }
}
