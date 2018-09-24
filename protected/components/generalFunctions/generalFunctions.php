<?php

/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */
class generalFunctions extends CApplicationComponent {

    protected $allowedExtensionGeneral = array('xls', 'xlsx', 'xlsm');
    public static $allowedExtensionImg = array('xls', 'xlsx');

    protected $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    protected $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    
    public function getAllowedExtensionGeneral() {
        return $this->allowedExtensionGeneral;
    }

    public function getAllowedExtensionImg($ext) {
        if (in_array($ext, $this->allowedExtensionImg($ext))) {
            return true;
        }
    }

    //Para que este metodo funcione correctamente, se debe de subir este archivo al servidor de juegos en formato ANSI
    public function replaceAccent($str) {
        $a = array("\n", "\t", 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 
            'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é',
            'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'A', 'a', 'A',
            'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E',
            'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I',
            'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N', 'n', 'N',
            'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', 'Œ', 'œ', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's',
            'S', 's', 'Š', 'š', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',
            'W', 'w', 'Y', 'y', 'Ÿ', 'Z', 'z', 'Z', 'z', 'Ž', 'ž', '?', 'ƒ', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O',
            'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?', 'Ã-', 'Â-', '\n', '\r');
        $b = array('', '', '&Agrave;', '&Aacute; ', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', 
            '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;',
            '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', 
            '&Uuml;', '&Yacute;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', 
            '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml', '&igrave;', '&iacute;', '&icirc;', 
            '&iuml', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml', '&oslash;', '&ugrave;', 
            '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&yuml', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C',
            'c', 'C', 'c', 'D', 'd', '&ETH;', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g',
            'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j',
            'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O',
            'o', 'O', 'o', '&OElig;', '&oelig;', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 
            'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 
            'y', '&Yuml;', 'Z', 'z', 'Z', 'z', 'Z', 'z', '?', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 
            'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?', 'i', '?', '', '');
        return str_replace($a, $b, $str);
    }
    
    public function showDate($id) {
        return $showDate = '<div id="' . $id . '">' . $this->dias[date('w')] . " " . date('d') . " de " . $this->meses[date('n') - 1] . " de " . date('Y') . '</div>';
    }
    
    
    /*
     * Método para mostrar archivos desde la NAS
     */
    function fileInLine($file, $dir, $forcedownload = false) {
        $mimetype = ARRAY(
        ".pdf" => "application/pdf",
         ".sig" => "application/pgp-signature",
         ".spl" => "application/futuresplash",
         ".class" => "application/octet-stream",
         ".ps" => "application/postscript",
         ".torrent" => "application/x-bittorrent",
         ".dvi" => "application/x-dvi",
         ".gz" => "application/x-gzip",
         ".pac" => "application/x-ns-proxy-autoconfig",
         ".swf" => "application/x-shockwave-flash",
         ".tar.gz" => "application/x-tgz",
         ".tgz" => "application/x-tgz",
         ".tar" => "application/x-tar",
         ".zip" => "application/zip",
         ".mp3" => "audio/mpeg",
         ".m3u" => "audio/x-mpegurl",
         ".wma" => "audio/x-ms-wma",
         ".wax" => "audio/x-ms-wax",
         ".ogg" => "application/ogg",
         ".wav" => "audio/x-wav",
         ".gif" => "image/gif",
         ".jpg" => "image/jpeg",
         ".jpeg" => "image/jpeg",
         ".png" => "image/png",
         ".xbm" => "image/x-xbitmap",
         ".xpm" => "image/x-xpixmap",
         ".xwd" => "image/x-xwindowdump",
         ".css" => "text/css",
         ".html" => "text/html",
         ".htm" => "text/html",
         ".js" => "text/javascript",
         ".asc" => "text/plain",
         ".c" => "text/plain",
         ".cpp" => "text/plain",
         ".log" => "text/plain",
         ".conf" => "text/plain",
         ".text" => "text/plain",
         ".txt" => "text/plain",
         ".spec" => "text/plain",
         ".dtd" => "text/xml",
         ".xml" => "text/xml",
         ".mpeg" => "video/mpeg",
         ".mpg" => "video/mpeg",
         ".mov" => "video/quicktime",
         ".qt" => "video/quicktime",
         ".avi" => "video/x-msvideo",
         ".asf" => "video/x-ms-asf",
         ".asx" => "video/x-ms-asf",
         ".wmv" => "video/x-ms-wmv",
         ".bz2" => "application/x-bzip",
         ".tbz" => "application/x-bzip-compressed-tar",
         ".tar.bz2" => "application/x-bzip-compressed-tar",
         ".odt" => "application/vnd.oasis.opendocument.text",
         ".ods" => "application/vnd.oasis.opendocument.spreadsheet",
         ".odp" => "application/vnd.oasis.opendocument.presentation",
         ".odg" => "application/vnd.oasis.opendocument.graphics",
         ".odc" => "application/vnd.oasis.opendocument.chart",
         ".odf" => "application/vnd.oasis.opendocument.formula",
         ".odi" => "application/vnd.oasis.opendocument.image",
         ".odm" => "application/vnd.oasis.opendocument.text-master",
         ".ott" => "application/vnd.oasis.opendocument.text-template",
         ".ots" => "application/vnd.oasis.opendocument.spreadsheet-template",
         ".otp" => "application/vnd.oasis.opendocument.presentation-template",
         ".otg" => "application/vnd.oasis.opendocument.graphics-template",
         ".otc" => "application/vnd.oasis.opendocument.chart-template",
         ".otf" => "application/vnd.oasis.opendocument.formula-template",
         ".oti" => "application/vnd.oasis.opendocument.image-template",
         ".oth" => "application/vnd.oasis.opendocument.text-web",
        # make the default mime type application/octet-stream.
        "" => "application/octet-stream");
     
        // se obtiene la extension del script!!
        $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $file);
        $ext = "." . $ext;
        $file_mimetype = '';

        foreach ($mimetype as $extension => $value) {
            if ($ext == $extension) {
                $file_mimetype = $value;
                break;
            }
        }

        if ($forcedownload == true) {
            header("Content-type: application/force-download");
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file . '"');
        }

        header('Accept-Ranges: none');
        header('Content-Disposition: inline; filename="' . $dir . $file . '"');
        header("Content-Transfer-Encoding: Binary");
        header("Content-length: " . filesize($dir . $file));
        header('Content-Type: ' . $mimetype);
        readfile("$dir$file");
    }
    
    /*
     * Método general para la carga de archivos, aun se encuentra en ajustes.
     */
    public function uploadFile($attributes,$data,$id = NULL) {
        
        $model = new Users;
        $models = new Attachment;  
        if(!is_null($id)){
            $models =Attachment::model()->findByPk($id);
        }

        $model->attributes = $attributes['name']['file'];
        $uploadedFile = CUploadedFile::getInstance($model, 'file');
        $file_ext = explode(".", $uploadedFile->name); //captura extencion
        $file_ext = end($file_ext);    //recorre el nombre por si hay varios puntos
        $fileName = 'pic-'.Yii::app()->session['users']->samaccountname.'-'.uniqid();
        $models->filename = "{$fileName}.{$file_ext}";  // numero aleatorio  + nombre de archivo                            
        $models->module_id = "1"; //modulo
        $models->attachedby = Yii::app()->session['users']->samaccountname; //usuario
        $models->attacheddate = date('Y-m-d H:i:s'); //fecha
        $models->filepath = PATH_UPLOAD_REGISTROS; //ruta de las NAS
        $models->filesize = $uploadedFile->size; //tmaño
        $models->zipfile = PATH_UPLOAD_REGISTROS . $models->filename; //ruta para enviar                            
        if ($uploadedFile->saveAs($models->zipfile)) {//Guarda el Archivos
            if ($models->save()) {
                return $models->id;;
            }
        }
    }
}

?>
