<?php 
/**
 * Clase que implementa las funciones basicas sobre una tabla a traves de un web
 * service 
 */
class TableWS{
    
    private $tabla;
    private $urlTableWS;
    private $wsTable;
    private $estado;
    private $errores;
    private $metodo;
    private $xsql;
    private $operadores;  
    private $type_join;
    private $sentidos;
    private $tipo_consulta;
    private $total_registros;
    private $hash;
    private $last_id;
    // CONSTANTES
    const SELECT = 'SELECT';
    const INSERT = 'INSERT';
    const UPDATE = 'UPDATE';
    const DETELE = 'DETELE';
    
    
    
    /**
     * Metodo Constructor
     * @param type $tabla
     * @param type $urlTableWS 
     */
    public function __construct($tabla,$urlTableWS) {
        $this->tabla = $tabla;
        $this->metodo = "Tbl".ucfirst(strtolower($tabla));
        $this->xsql = array(
            '_methodo'=>$this->metodo,
            'campos'=>'',
            'valores'=>array(),
            'condiciones'=>array(),
            'joins'=>array(),
            'limit'=>array(
                'inicio'=>0,
                'numregis'=>0
            ),
            'orderby'=>'',
            'sentido'=>0            
        );
        $this->operadores = array(
            '='     =>'IGUAL',
            '!='    =>'DIFF',
            '>'     =>'MAYOR',
            '<'     =>'MENOR',
            '>='    =>'MAYOROIGUAL',
            '<='    =>'MENOROIGUAL',
            'like'  =>'LIKE'
        );        
        $this->type_join = array(
            'inner'=>'INNER',
            'left'=>'LEFT',
            'right'=>'RIGHT',
            'outer'=>'OUTER',
        );
        $this->sentidos = array(
            'asc'=>'ASC',
            'desc'=>'DESC'            
        );
        $this->tipo_consulta = '';
        $this->total_registros = 0;
        $this->urlTableWS = $urlTableWS;
        $this->estado = false;
        $this->errores = '';       
        $this->__connect();
        $this->hash = '';
        $this->last_id = 0;
    }
    
    /**
     * Crear una conexion con el WS que implementa la tabla.
     */
    protected function __connect(){
        try{
            $params = array(
                'trace' => true,
                "exceptions" => 1,
                'encoding' => 'utf-8'
            );
            $params['timeout'] = 120;            
            $this->wsTable = new SoapClient($this->urlTableWS,$params);            
            $this->estado = true;                
        }catch(SoapFault $e){                             
            $this->errores = $e->getMessage();
            $this->estado = false;            
        }
    }
    
    public function getEstado(){
        return $this->estado;
    }
    
    public function getErrores(){
        return $this->errores;
    }
    
    /**
     * Permite Adicionar los campos de consultam separador por coma
     * Devuelve la instancia del objeto permitiendo
     * anidar el llamado de metodos tipo yii.
     * @param type $campos
     * @return TableWS 
     */
    public function Select($campos){
        $this->xsql['campos'] = $campos;
        $this->tipo_consulta = self::SELECT;
        return $this;
    }
    
    public function Insert($campos){
        $this->xsql['campos'] = $campos;
        $this->tipo_consulta = self::INSERT;
        return $this;
    }
    
    public function Delete(){
        $this->tipo_consulta = self::DETELE;
        return $this;
    }
    
    public function Update($campos){
       $this->xsql['campos'] = $campos;
       $this->tipo_consulta = self::UPDATE;
       return $this; 
    }
    
    /**
     * Permite agregar una condicion
     * @param type $campo
     * @param type $operador =, !=, >, <, >= <=
     * @param type $valor
     * @param type $anidar aplica desde la segunda condicion para enlazarlas ej: and o or
     */
    public function condicion($campo,$operador,$valor,$anidar = false){
        if(isset($this->operadores[$operador])){
            $condicion = array(
                'campo'=>$campo,
                'operador'=>$this->operadores[$operador],
                'valor'=>$valor
            );
            if(count($this->xsql['condiciones'])>0 && $anidar != false){
                $condicion['anidar'] = strtoupper($anidar);
            }
            array_push($this->xsql['condiciones'],$condicion);
        }        
        return $this;
    }
    
    /**
     * Crea un join con otra tabla
     * @param type $tabla Ej.:TBL_CLIENTE
     * @param type $type INNER, LEFT, RIGHT, OUTER
     * @param type $campoa nombre del campo en tabla relacionada
     * @param type $campob nombre del campo de la tabla principal
     */
    public function join($tabla,$type,$campoa,$campob){
        if(isset($this->type_join[$type])){
            $join = array(
                'tabla'=>$tabla,
                'type'=>$this->type_join[$type],
                'campoa'=>$campoa,
                'campob'=>$campob,
            );
            array_push($this->xsql['joins'],$join);
        }
        return $this;
    }
    
    /**
     * Permite selecionar un grupo de registros e implementar paginacion
     * @param type $inicio
     * @param type $numregis 
     */
    public function limit($inicio,$numregis){
        $inicio = ($inicio>0)?$inicio-1:0;        
        $this->xsql['limit']['inicio'] = $inicio*$numregis;
        $this->xsql['limit']['numregis'] = $numregis;
        return $this;
    }
    
    /**
     * Permite ingresar un listado de valores para un insert, separados por coma
     * @param array $valores valores separados por coma
     * @param bool $varios indica si son varios registros a agregar
     * @return TableWS 
     */
    public function valores($valores,$varios = false){
        if($varios == false){
            $this->xsql['valores'] = array($valores);
        }else{
            $this->xsql['valores'] = $valores;
        }
        return $this;
    }
    
    
    /**
     * Permite ordenr los resultados de una consulta
     * @param type $campos campos separados por coma
     * @param type $sentido orden ASC DESC
     */
    public function orderby($campos,$sentido){
        $this->xsql['orderby'] = $campos;
        $this->xsql['sentido'] = $sentido;
        return $this;
    }
    
    /**
     * Realiza
     */
    public function query(){
        // INICIALIZAMOS LA CACHE
        $this->setHashCache();
        // CONSTRUIMOS LA CONSULTA
        switch($this->tipo_consulta){
            case self::SELECT:
                // DETERMINAMOS SI EXISTE LA CACHE
                if($this->CacheValidExist()){
                    return $this->getCacheData();
                }
                
                $xml ="<xmlIn>
                <header>        
                    <idMensaje>".time()."</idMensaje>                
                    <transaccion>$this->metodo</transaccion>
                    <tipoTransaccion>sincronica</tipoTransaccion>
                    <aplicacionOrigen>YII</aplicacionOrigen>
                </header>
                <body>
                    <accion>SELECT</accion>
                    <campos>
                        <campo>".implode("</campo><campo>",explode(",",$this->xsql['campos']))."</campo>                        
                    </campos>";
                if(count($this->xsql['joins']) > 0){
                    $xml .= "
                        <joins>";
                    foreach($this->xsql['joins'] as $join){
                        $join_xml = "<join>                                
                                <tabla>".$join['tabla']."</tabla>
                                <type>".$join['type']."</type>
                                <campoa>".$join['campoa']."</campoa>
                                <campob>".$join['campob']."</campob>
                            </join>";
                        $xml .= $join_xml;   
                    }
                    $xml .= "</joins>";
                }
                if(count($this->xsql['condiciones']) > 0){
                    $xml .= "<condiciones>";
                    foreach($this->xsql['condiciones'] as $condicion){
                        $condi = "<condicion>".((isset($condicion['anidar']))?"<anidar>".$condicion['anidar']."</anidar>":'')."
                                <campo>".$condicion['campo']."</campo>
                                <operador>".$condicion['operador']."</operador>
                                <valor>".$condicion['valor']."</valor>
                            </condicion>";
                        $xml .= $condi;   
                    }
                    $xml .= "</condiciones>";
                }
                if(strlen($this->xsql['orderby'])>0){
                    $xml .="
                    <orderby>
                       <campo>".implode("</campo><campo>",explode(",",$this->xsql['orderby']))."</campo>                                               
                    </orderby>";
                    if(isset($this->sentidos[$this->xsql['sentido']])){
                        $xml .="<sentido>".$this->sentidos[$this->xsql['sentido']]."</sentido>";
                    }
                }
                
                if($this->xsql['limit']['inicio'] > 0 || $this->xsql['limit']['numregis'] > 0){
                    $xml .="
                    <limit>
                        <inicio>".$this->xsql['limit']['inicio']."</inicio>
                        <numregis>".$this->xsql['limit']['numregis']."</numregis>
                    </limit>";
                }
                $xml .="
                </body>    
            </xmlIn>"; 
                try{                          
                    $res = $this->wsTable->__soapCall($this->metodo,array($xml));                    
                    $respuesta = simplexml_load_string($res);
                    if(strcmp($respuesta->body->codigoError,'00')==0){
                        $this->total_registros = (int)$respuesta->body->TotalRegistros;
                        $datos = $this->__mapearDatos($respuesta->body->Registros);
                        //$this->CacheData($datos);
                        return $datos;
                    }else{
                        $this->errores = $respuesta->body->mensajeError;
                        return false;
                    }                    
                }catch(SoapFault $e){
                    $this->errores = $e->getMessage();
                }catch(Exception $e){
                    $this->errores = $e->getMessage();
                }                   
                return false;                
            break;
            case self::INSERT:
                $xml ="<xmlIn>
                <header>        
                    <idMensaje>".time()."</idMensaje>                
                    <transaccion>$this->metodo</transaccion>
                    <tipoTransaccion>sincronica</tipoTransaccion>
                    <aplicacionOrigen>YII</aplicacionOrigen>
                </header>
                <body>
                    <accion>INSERT</accion>
                    <campos>
                        <campo>".implode("</campo><campo>",explode(",",$this->xsql['campos']))."</campo>                        
                    </campos>";                
                if(count($this->xsql['valores']) > 0){
                    $xml .= "<valores>";
                    foreach($this->xsql['valores'] as $registro){
                        foreach($registro as $key => $val){
                            $registro[$key] = $this->CodificarValorXML($val);
                        }
                        $condi = "<registro>                               
                                <valor>".implode("</valor><valor>",$registro)."</valor>
                            </registro>";
                        $xml .= $condi;   
                    }
                    $xml .= "</valores>";
                }                
                $xml .="
                </body>    
            </xmlIn>"; 
                try{
                    $xml = $this->CodificarXML($xml);
                    $res = $this->wsTable->__soapCall($this->metodo,array($xml));                    
                    $respuesta = simplexml_load_string($res);
                    if(strcmp($respuesta->body->codigoError,'00')==0){
                        $this->total_registros = (int)$respuesta->body->TotalRegistros;
                        $this->last_id = (int)$respuesta->body->Registros;
                        return true;
                    }else{
                        $this->errores = $respuesta->body->mensajeError;
                        return false;
                    }                    
                }catch(SoapFault $e){
                    $this->errores = $e->getMessage();
                }catch(Exception $e){
                    $this->errores = $e->getMessage();
                }                   
                return false; 
            break;
            case self::UPDATE:
                $xml ="<xmlIn>
                <header>        
                    <idMensaje>".time()."</idMensaje>                
                    <transaccion>$this->metodo</transaccion>
                    <tipoTransaccion>sincronica</tipoTransaccion>
                    <aplicacionOrigen>YII</aplicacionOrigen>
                </header>
                <body>
                    <accion>UPDATE</accion>
                    <campos>
                        <campo>".implode("</campo><campo>",explode(",",$this->xsql['campos']))."</campo>                        
                    </campos>";                
                if(count($this->xsql['valores']) > 0){
                    $xml .= "<valores>";
                    foreach($this->xsql['valores'] as $registro){
                        foreach($registro as $key => $val){
                            $registro[$key] = $this->CodificarValorXML($val);
                        }
                        $condi = "<registro>                               
                                <valor>".implode("</valor><valor>",$registro)."</valor>
                            </registro>";
                        $xml .= $condi;   
                    }
                    $xml .= "</valores>";
                }   
                if(count($this->xsql['condiciones']) > 0){
                    $xml .= "<condiciones>";
                    foreach($this->xsql['condiciones'] as $condicion){
                        $condi = "<condicion>".((isset($condicion['anidar']))?"<anidar>".$condicion['anidar']."</anidar>":'')."
                                <campo>".$condicion['campo']."</campo>
                                <operador>".$condicion['operador']."</operador>
                                <valor>".$condicion['valor']."</valor>
                            </condicion>";
                        $xml .= $condi;   
                    }
                    $xml .= "</condiciones>";
                }  
                $xml .="
                </body>    
            </xmlIn>"; 
                try{   
                   
                    $xml = $this->CodificarXML($xml);
                    $res = $this->wsTable->__soapCall($this->metodo,array($xml));                    
                    $respuesta = simplexml_load_string($res);                    
                    if(strcmp($respuesta->body->codigoError,'00')==0){
                        $this->total_registros = (int)$respuesta->body->TotalRegistros;
                        $this->last_id = (int)$respuesta->body->Registros;
                        return true;
                    }else{
                        $this->errores = $respuesta->body->mensajeError;
                        return false;
                    }                    
                }catch(SoapFault $e){
                    $this->errores = $e->getMessage();
                }catch(Exception $e){
                    $this->errores = $e->getMessage();
                }                   
                return false; 
            break;
            case self::DETELE:
                $xml ="<xmlIn>
                <header>        
                    <idMensaje>".time()."</idMensaje>                
                    <transaccion>$this->metodo</transaccion>
                    <tipoTransaccion>sincronica</tipoTransaccion>
                    <aplicacionOrigen>YII</aplicacionOrigen>
                </header>
                <body>
                    <accion>DELETE</accion>";                
                if(count($this->xsql['condiciones']) > 0){
                    $xml .= "<condiciones>";
                    foreach($this->xsql['condiciones'] as $condicion){
                        $condi = "<condicion>".((isset($condicion['anidar']))?"<anidar>".$condicion['anidar']."</anidar>":'')."
                                <campo>".$condicion['campo']."</campo>
                                <operador>".$condicion['operador']."</operador>
                                <valor>".$condicion['valor']."</valor>
                            </condicion>";
                        $xml .= $condi;   
                    }
                    $xml .= "</condiciones>";
                }     
                $xml .="
                </body>    
            </xmlIn>"; 
                try{                    
                    $res = $this->wsTable->__soapCall($this->metodo,array($xml));                    
                    $respuesta = simplexml_load_string($res);
                    if(strcmp($respuesta->body->codigoError,'00')==0){
                        $this->total_registros = (int)$respuesta->body->TotalRegistros;                        
                        return true;
                    }else{
                        $this->errores = $respuesta->body->mensajeError;
                        return false;
                    }                    
                }catch(SoapFault $e){
                    $this->errores = $e->getMessage();
                }catch(Exception $e){
                    $this->errores = $e->getMessage();
                }                   
                return false; 
            break;
        }
        
        return false;
    }
    
    /**
     * toma los datos devueltos por el ws y los comierte en un vector
     * @param type $datos 
     */
    private function __mapearDatos($registros){    
        //file_put_contents('./datosyii.txt', $registros);
        $xml = str_replace('<![CDATA[','',  $registros);
        $xml = trim(str_replace(']]>','', $xml));
        $listado = simplexml_load_string($xml);        
        $datos = array();
        foreach($listado as $reg){
            $row = array();
            foreach($reg as $campo){                
                array_push($row,(string)$this->DecodificarXML($campo));
            }
            array_push($datos,$row);
        }
        return $datos;
    }
    
    
    public function getTotalRegistros(){
        return $this->total_registros;
    }
    
    public function getLastId(){
        return $this->last_id;
    }
    
    private function setHashCache(){
        $this->hash =  md5(json_encode($this->xsql));
    }
    
    /**
     * determina si esiste una cache valida para la consulta
     * @return type 
     */
    private function CacheValidExist(){                        
        if(isset($_SESSION["cache_tblws_time_$this->hash"])){
            $expire_time = Yii::app()->params['cacheTime'] + $_SESSION["cache_tblws_time_$this->hash"];
            if(time() > $expire_time){
                $this->FreeCache();                
            }else{
                // LA CACHE ES AUN VALIDA
                return true;
            }
        }
        return false;
    }
    
    /**
     * Crea la cache de una consulta
     * @param type $data 
     */
    private function CacheData($data){        
        $_SESSION["cache_tblws_time_$this->hash"] = time();
        $_SESSION["cache_tblws_data_$this->hash"] = $data;
        $_SESSION["cache_tblws_rows_$this->hash"] = $this->total_registros;
    }
    
    /**
     * Devuelve la cache de una consulta
     * @return type 
     */
    private function getCacheData(){      
        $this->total_registros = $_SESSION["cache_tblws_rows_$this->hash"];
        return $_SESSION["cache_tblws_data_$this->hash"];
    }
    
    /**
     * Libera los datos de la cache
     */
    private function FreeCache(){        
        unset($_SESSION["cache_tblws_time_$this->hash"]);
        unset($_SESSION["cache_tblws_data_$this->hash"]);
        unset($_SESSION["cache_tblws_rows_$this->hash"]);
    }
    
       
    private function DecodificarXML($valor){
        $valor = str_replace('&amp;', '&', $valor);
        $valor = str_replace('&gt;','>', $valor);
        $valor = str_replace('&lt;','<', $valor);
        $valor = str_replace('&quot;','"', $valor);
        $valor = str_replace('&apos;',"'", $valor);
        $valor = str_replace('&#241;', 'ñ', $valor);
        $valor = str_replace('&#209;', 'Ñ', $valor);        
        $valor = str_replace('&#193;', 'Á', $valor);
        $valor = str_replace('&#201;', 'É', $valor);
        $valor = str_replace('&#205;', 'Í', $valor);
        $valor = str_replace('&#211;', 'Ó', $valor);
        $valor = str_replace('&#218;', 'Ú', $valor);
        $valor = str_replace('&#225;', 'á', $valor);
        $valor = str_replace('&#233;', 'é', $valor);
        $valor = str_replace('&#237;', 'í', $valor);
        $valor = str_replace('&#243;', 'ó', $valor);
        $valor = str_replace('&#250;', 'ú', $valor);
        return $valor;
    } 
    
    private function CodificarValorXML($valor){
        $valor = str_replace('&', '&amp;', $valor); 
        $valor = str_replace('>', '&gt;', $valor);
        $valor = str_replace('<', '&lt;', $valor);
        $valor = str_replace('"', '&quot;', $valor);
        $valor = str_replace("'", '&apos;', $valor);        
        return $valor;
    }
    
    private function CodificarXML($valor){            
        $valor = str_replace("ñ", '&#241;', $valor);
        $valor = str_replace('Ñ', '&#209;', $valor);
        $valor = str_replace('Á', '&#193;', $valor);
        $valor = str_replace('É', '&#201;', $valor);
        $valor = str_replace('Í', '&#205;', $valor);
        $valor = str_replace('Ó', '&#211;', $valor);
        $valor = str_replace('Ú', '&#218;', $valor);
        $valor = str_replace('á', '&#225;', $valor);
        $valor = str_replace('é', '&#233;', $valor);
        $valor = str_replace('í', '&#237;', $valor);
        $valor = str_replace('ó', '&#243;', $valor);
        $valor = str_replace('ú', '&#250;', $valor);
        return $valor;
    }
    
    
}

?>