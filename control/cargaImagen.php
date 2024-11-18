<?php

class CargaImagen
{
    /**
     * Controla si el archivo subido es de tipo imagen (.jpg, .jpeg, .png, .gif),
     * retorna un booleano indicando true o false
     * @param array $archivoCargado
     * @return boolean
     */
    function controlarFormato($archivoCargado)
    {
        $archivoCargado = strtolower($archivoCargado['name']);
        $pudo = true;

        // Busco en el nombre si aparece alguna de las extensiones permitidas
        $extensionesPermitidas = ['.jpg', '.jpeg', '.png', '.gif'];
        $esImagen = false;

        foreach ($extensionesPermitidas as $extension) {
            if (strpos($archivoCargado, $extension) !== false) {
                $esImagen = true;
                break;
            }
        }

        // Controlamos formato
        if (!$esImagen) {
            $pudo = false;
        }

        return $pudo;
    }

    /**
     * Controla que el archivo subido no pese más de 2MB
     * @param array $archivoCargado
     * @return boolean
     */
    public function controlarPesoArchivo($archivoCargado)
    {
        $pudo = true;

        // Reviso tamaño - 2MB son 2,000,000 de bytes
        if ($archivoCargado["size"] > 2000000) {
            $pudo = false;
        }
        return $pudo;
    }

    /**
     * Se encarga de subir el archivo al directorio final en caso de ser exitosa la carga, y notifica.
     * En caso de fallar, retornará un mensaje indicando el motivo.
     * @param array $archivoCargado
     * @return array
     */
    public function subir($archivoCargado)
    {
        $formato = $this->controlarFormato($archivoCargado);
        $pesoArchivo = $this->controlarPesoArchivo($archivoCargado);

        if ($formato) {
            if ($pesoArchivo) {
                $rutaDestino = '../vista/images/' . $archivoCargado['name'];
                if (move_uploaded_file($archivoCargado['tmp_name'], $rutaDestino)) {
                    $mensaje = "La imagen se ha subido con éxito.";
                    $pudo = "si";
                } else {
                    $mensaje = "Error al mover el archivo.";
                    $pudo = "no";
                }
            } else {
                $mensaje = "Error, el archivo debe pesar menos de 2MB.";
                $pudo = "no";
            }
        } else {
            $mensaje = "Error, el archivo debe ser una imagen (.jpg, .jpeg, .png, .gif).";
            $pudo = "no";
        }

        $salida = ['pudo' => $pudo, 'mensaje' => $mensaje];
        return $salida;
    }
}
