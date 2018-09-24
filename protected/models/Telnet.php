<?php

/**
 * Esta clase Define el modelo del formulario Consultas
 * para la consulta de conectividad
 * 
 * @package Telnet
 */
class Telnet extends CFormModel {

    //campos del modelo
    public $host;
    public $port;
    public $protocol;
    public $method;
    public $route;
    public $header;
    public $response;

    /**
     * Retorna el modelo estático de la clase especificada
     * @return CFormModel el modelo estático de la clase
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return arreglo de las diferentes validaciones del modelo
     */
    public function rules() {
        return array(
            // username and password are required
            array('host,port,protocol,method', 'required', 'message' => 'Este campo es obligatorio'),
        );
    }

    /**
     * @return arreglo personalizado con las etiquetas de los campos
     * (name => label)
     */
    public function attributeLabels() {
        return array(
            'host' => 'Ingrese el Host/Server o la IP',
            'port' => 'Puerto',
            'protocol' => 'Protocolo',
            'method' => 'Metodo',
            'route' => 'Ruta de la carpeta publica que quiera realizar la prueba',
            'header' => 'Header de prueba de conexión'
        );
    }

    #este metodo permite realizar la prueba de conexion telnet a un host remoto
    /**
     * 
     * @param array $options
     * @return array
     */

    public function testConnection($options = array()) {
        try {
            $vars = ARRAY();
            define("SALTO", "\r\n");
            if (isset($options)) {
                $magicq = (get_magic_quotes_gpc() == 1);
                foreach ($options as $campo => $valor) {
                    switch ($campo) {
                        case "host":
                            @$un_dominio = htmlspecialchars($valor, ENT_QUOTES);
                            if ($magicq)
                                $un_dominio = stripslashes($un_dominio);
                            //Quita todo espacio y saltos antes y después
                            $un_dominio = trim($un_dominio);
                            break;
                        case "protocol":
                            @$un_protocolo = htmlspecialchars($valor, ENT_QUOTES);
                            if ($magicq)
                                $un_protocolo = stripslashes($un_protocolo);
                            break;
                        case "method":
                            @$un_metodo = htmlspecialchars($valor, ENT_QUOTES);
                            if ($magicq)
                                $un_metodo = stripslashes($un_metodo);
                            break;
                        case "port":
                            @$un_puerto = htmlspecialchars($valor, ENT_QUOTES);
                            if ($magicq)
                                $un_puerto = stripslashes($un_puerto);
                            break;
                        case "timeout":
                            @$un_timeout = htmlspecialchars($valor, ENT_QUOTES);
                            if ($magicq)
                                $un_timeout = stripslashes($un_timeout);
                            break;
                        case "route":
                            @$una_ruta = htmlspecialchars($valor, ENT_QUOTES);
                            if ($magicq)
                                $una_ruta = stripslashes($una_ruta);
                            //Quita todo espacio y saltos antes y después
                            $una_ruta = trim($una_ruta);
                            break;
                        case "header":
                            @$una_cabecera = htmlspecialchars($valor, ENT_QUOTES);
                            if ($magicq)
                                $una_cabecera = stripslashes($una_cabecera);
                            //Quita todo espacio y saltos antes y después
                            $una_cabecera = trim($una_cabecera);
                            break;
                    }
                }
                if (($un_dominio != "") && ($una_ruta != "")) {
                    $http_respuesta = "";
                    //Abre un socket para una conexión con un dominio
                    $mi_telnet = @fsockopen($un_dominio, $un_puerto, $errno, $errstr, $un_timeout);
                    if (!$mi_telnet) {
                        $vars['errno'] = utf8_encode($errno);
                        $vars['errstr'] = utf8_encode($errstr);
                    } else {
                        //Preparamos una cadena de petición HTTP
                        $escribe = $un_metodo . " " . $una_ruta . " " . $un_protocolo . SALTO .
                                "Host: " . $un_dominio . SALTO;
                        //Si hay cabecera la agregamos
                        if ($una_cabecera != "")
                            $escribe .= $una_cabecera . SALTO;
                        $escribe .= "Connection: Close" . SALTO . SALTO;
                        //Preparamos una cadena para presentar la petición recibida en 
                        //el servidor, resaltando los saltos de línea
                        $vars['escribe_rn'] = str_replace(SALTO, "?" . SALTO, $escribe);
                        //Escribimos la petición en el socket                
                        fwrite($mi_telnet, $escribe);
                        //Leemos líneas del socket
                        while (!feof($mi_telnet)) {
                            $http_respuesta .= fgets($mi_telnet, 128);
                        }
                    }
                    //Cerramos el socket
                    @fclose($mi_telnet);
                    //Limpiamos caracteres reservados
                    $vars['cadena_html'] = htmlentities($http_respuesta, ENT_QUOTES, "UTF-8");
                }
            }
            return $vars;
        } catch (Exception $ex) {

            echo "<center><code>" . $ex->getMessage() . "</code></center>";
            #de esta manera se realiza el log de eventos en la tabla mvc_event_log
            Yii::app()->eventManager->registerException('Telnet', $ex->getTraceAsString());
        }
    }

}
