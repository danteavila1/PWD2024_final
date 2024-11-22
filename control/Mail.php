<?php

require_once __DIR__ . '/../vendor/autoload.php';

class Mail
{
    /**
     * Se encarga de recopilar los datos del comprador
     * y el último estado de la compra
     * @param array $idcompra
     * @return array $datosMail
     */
    public function datosMail($idcompra)
    {
        // Con el idcompra busco al usuario
        $param1 = ['idcompra' => $idcompra];
        $objCompra = new AbmCompra();
        $compra = $objCompra->buscar($param1);
        $idUsuario = $compra[0]->getIdUsuario();

        // Con el idusuario obtengo el correo del comprador
        $param2 = ['idusuario' => $idUsuario];
        $objUsuario = new AbmUsuario();
        $colUsuarios = $objUsuario->buscar($param2);
        $correo = $colUsuarios[0]->getUsMail();

        // Con el idcompra busco el estado de la compra
        $objCompraEstadoTipo = new AbmCompraEstado();
        $colEstados = $objCompraEstadoTipo->buscar($param1);

        // Itero sobre todos los estados de la compra para conseguir el último
        foreach ($colEstados as $estado) {
            $estado = $estado->getObjCompraEstadoTipo()->getCetDescripcion();
        }

        // Creo array con los datos necesarios para mandar el mail
        $datosMail = ['correo' => $correo, 'estado' => $estado];

        return $datosMail;
    }

    /**
     * Configura datos del emisor, obtiene datos del cliente y el estado de la compra.
     * Se encarga de mandar mail avisando del cambio de estado.
     * @param array $idcompra
     */
    public function enviarMail($idcompra)
    {
        // Relleno con los datos del correo emisor
        $correoTienda = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('kawaii.store.pwd@gmail.com') // Correo
            ->setPassword('tana rtal vuco vexu'); // Clave de aplicación

        $emisor = new Swift_Mailer($correoTienda);

        // Traigo los datos del destinatario
        $datosMail = $this->datosMail($idcompra);
        $correo = $datosMail['correo'];
        $estado = $datosMail['estado'];

        $mensaje = (new Swift_Message('Asunto del correo'))
            ->setSubject('Cambio de estado')
            ->setFrom(['kawaii.store.pwd@gmail.com' => 'Kawaii Store'])
            ->setTo([$correo])
            ->setBody('Desde el depósito de Kawaii Store le informamos que su compra ha pasado al estado de: ' . $estado);

        $emisor->send($mensaje);
    }
}
