<?php
Yii::import('application.components.soap.soap-wsse');
class WSS_SoapClient extends SoapClient{
    //Ruta del fichero de la clave privada
    public $key_file="";
    //Passphrase de la clave privada
    public $passphrase="";
    //Ruta del fichero del certificado
    public $cert_file="";
    //Mensaje SOAP enviado
    public $soap_sent="";
    
    function __doRequest($request, $location, $action, $version, $one_way = null)
    {
        //Creamos un DOMDocument
        $doc = new DOMDocument('1.0');
        //Cargamos el XML pasado por parámetro
        $doc->loadXML($request);
        
        //Creamos una instancia de WSSESoap con el documento, sin "mustUnderstand" ni "actor"
        $objWSSE = new WSSESoap($doc,false,false);
        
        //Creamos una instacian de XMLSecurityKey con el RSA SHA1 y de tipo privado
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1,array ('type'=>'private'));
        //Pasamos el valor de passphrase
        $objKey->passphrase=$this->passphrase;
        //Cargamos la clave privada con la ruta del fichero, que es fichero y que no es certificado
        $objKey->loadKey($this->key_file, TRUE);
        
        //Firmamos el mensaje
        $objWSSE->signSoapDoc($objKey);
        
        //Añadimos el BinarySecurityToken, pasamos el contenido del certificado, le decimos que es formato PEM
        $token = $objWSSE->addBinaryToken(file_get_contents($this->cert_file),TRUE);
        //Añadimos el KeyInfo
        $objWSSE->attachTokentoSig($token);
        
        //Añadimos el Timestamp
        $objWSSE->addTimestamp(3600);
        
        //Guardamos el XML enviado
        $this->soap_sent=$objWSSE->saveXML();
		
        //Llamamos al método __doRequest padre
        return parent::__doRequest($this->soap_sent, $location, $action, $version);
    }
}

?>
