<?php
/**
 * Éste método convierte con expresiones regulares el contenido de una celda dependiendo el tipo que se
 * le envie
 * @Autor: Jorge Arzuaga
 * 
 * @param string $string
 * @param string $strExpreg
 * @param string $url
 * @param string $type
 * @param string $dimWindow		//Dimensiones de la ventana modal
 * @param string $target
 * @return string
 *
 */
function regularExpressions($string, $strExpreg='', $url='', $type = 'resaltar', $dimWindow=array(), $target='_self')
{  
	if($url != '' && $type == 'resaltar' && $strExpreg != ''){
		$string = preg_replace("/".$strExpreg."/i", "<a href='".$url."' target='".$target."'><b class='ui-state-highlight'>$0</b></a>",$string);
	}elseif($url != '' && $type == 'link'){
		$string = "<a href='".$url."' target='".$target."' class='linkUnderline'>".$string."</a>";
	}elseif($url != '' && $type == 'ventanamodal'){
		list($width,$heigth) = explode("|",$dimWindow);
		$string = "<a onclick=\"AbrirVentanaModal('".$url."','".$width."','".$heigth."',true)\" class='linkUnderline'>".$string."</a>";
    }elseif($strExpreg != ''){
        $string = preg_replace("/".$strExpreg."/i", "<b class='ui-state-highlight'>$0</b>",$string);
    }
    return $string;
}
/**
 * Reemplaza entidades en caracteres legibles
 * tipo puede ser todo o tilde, o simbolos
 */
function replaceEntity ($strText)
{
	
	$strText = str_replace('&aacute;','á',$strText);
	$strText = str_replace('&eacute;','é',$strText);
	$strText = str_replace('&iacute;','í',$strText);
	$strText = str_replace('&oacute;','ó',$strText);
	$strText = str_replace('&uacute;','ú',$strText);
	$strText = str_replace('&Aacute;','Á',$strText);
	$strText = str_replace('&Eacute;','É',$strText);
	$strText = str_replace('&Iacute;','Í',$strText);
	$strText = str_replace('&Oacute;','Ó',$strText);
	$strText = str_replace('&Uacute;','Ú',$strText);
	$strText = str_replace('&ntilde;','ñ',$strText);
	$strText = str_replace('&Ntilde;','Ñ',$strText);
	$strText = str_replace('&auml;','ä',$strText);
	$strText = str_replace('&euml;','ë',$strText);
	$strText = str_replace('&iuml;','ï',$strText);
	$strText = str_replace('&ouml;','ö',$strText);
	$strText = str_replace('&uuml;','ü',$strText);
	$strText = str_replace('&Auml;','Ä',$strText);
	$strText = str_replace('&Euml;','Ë',$strText);
	$strText = str_replace('&Iuml;','Ï',$strText);
	$strText = str_replace('&Ouml;','Ö',$strText);
	$strText = str_replace('&Uuml;','Ü',$strText);
	$strText = str_replace('&sup2;','²',$strText);


	$strText = str_replace('&middot;','·',$strText);
	$strText = str_replace('&ndash;','-',$strText);
	$strText = str_replace('&reg;','®',$strText);
	$strText = str_replace('&bull;','•',$strText);
	$strText = str_replace('&forall;','∀',$strText);
	$strText = str_replace('&part;','∂',$strText);
	$strText = str_replace('&exist;','∃',$strText);
	$strText = str_replace('&empty;','∅',$strText);
	$strText = str_replace('&nabla;','∇',$strText);
	$strText = str_replace('&isin;','∈',$strText);
	$strText = str_replace('&notin;','∉',$strText);
	$strText = str_replace('&ni;','∋',$strText);
	$strText = str_replace('&prod;','∏',$strText);
	$strText = str_replace('&sum;','∑',$strText);
	$strText = str_replace('&minus;','−',$strText);
	$strText = str_replace('&lowast;','∗',$strText);
	$strText = str_replace('&radic;','√',$strText);
	$strText = str_replace('&prop;','∝',$strText);
	$strText = str_replace('&infin;','∞',$strText);
	$strText = str_replace('&ang;','∠',$strText);
	$strText = str_replace('&and;','∧',$strText);
	$strText = str_replace('&or;','∨',$strText);
	$strText = str_replace('&cap;','∩',$strText);
	$strText = str_replace('&cup;','∪',$strText);
	$strText = str_replace('&int;','∫',$strText);
	$strText = str_replace('&there4;','∴',$strText);
	$strText = str_replace('&sim;','∼',$strText);
	$strText = str_replace('&cong;','≅',$strText);
	$strText = str_replace('&asymp;','≈',$strText);
	$strText = str_replace('&ne;','≠',$strText);
	$strText = str_replace('&equiv;','≡',$strText);
	$strText = str_replace('&le;','≤',$strText);
	$strText = str_replace('&ge;','≥',$strText);
	$strText = str_replace('&sub;','⊂',$strText);
	$strText = str_replace('&sup;','⊃',$strText);
	$strText = str_replace('&nsub;','⊄',$strText);
	$strText = str_replace('&sube;','⊆',$strText);
	$strText = str_replace('&supe;','⊇',$strText);
	$strText = str_replace('&oplus;','⊕',$strText);
	$strText = str_replace('&otimes;','⊗',$strText);
	$strText = str_replace('&perp;','⊥',$strText);
	$strText = str_replace('&sdot;','⋅',$strText);
	
	return $strText;
}


function limpiar_tags($tags){
    $tags = strip_tags($tags);
    $tags = stripslashes($tags);
    $tags = htmlspecialchars($tags); 
    return $tags;
}