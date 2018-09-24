<?php

class particularFunction {

    /**
     * Permite crear o actualizar archivos a traves de fopen
     * @param string $path
     * @param string $content
     * @throws Exception
     */
    function writeDown($path, $content) {

        if (!file_exists($path)) {
            touch($path);
            $handle = fopen($path, 'w');
            $str = $content;
        } else {
            $str = $content;
            $handle = fopen($path, 'w');
        }
        if (fwrite($handle, $str) === false) {
            throw new Exception("No se pudo escribir en el archivo....");
        }
        fclose($handle);
    }

}
