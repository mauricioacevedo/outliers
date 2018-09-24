<?php
/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */

class menu {
	
	private static $objInstancia	= null;	
	/**
	 *
	 * Metódo singleton por medio del cual se instancia de manera única el objeto de ésta clase
	 */
	public static function singleton()
	{
		if(self::$objInstancia == null)
			self::$objInstancia=new self();
	
		return self::$objInstancia;
	}
	
	/**
	 * Crea un menu con pestañas
	 * @param string $modelMenu
	 * @param array $htmloptions
	 * @return string
	 */
	function build_tabmenu($modelMenu,$htmloptions,$id_alias='')
	{
		$result 		= "<ul>";
		foreach ($modelMenu as $index =>$val)
		{
			$result.= "<li id='".$id_alias.$modelMenu[$index]->id."'>";
			$srtAttributes = '';
			foreach ($htmloptions as $attribute => $value) {
				if(!is_null($value)){
					$srtAttributes .= $attribute."='".$modelMenu[$index]->$value."' ";
				}
			}
			$result.= "<a ".$srtAttributes.">".$modelMenu[$index]->alias."</a>";
			$result.= "<li>";			
		}
		$result 		.= "<ul>";
		return $result;
	}	
	/**
	 * Crea los menus verticales,horizontales
	 * @param string $modelMenu
	 * @param array $htmloptions
	 * @param number $parent
	 * @return string
	 */
	function build_menu($modelMenu,$htmloptions,$id_alias='',$parent=0)
	{ 
		$result 		= "<ul>";
		foreach ($modelMenu as $index =>$val)
		{
			if ($modelMenu[$index]->parent_id == $parent){
				$result.= "<li class='has-sub' id='".$id_alias.$modelMenu[$index]->id."'>";
				$srtAttributes = '';
				foreach ($htmloptions as $attribute => $value) {
					if(!is_null($value)){
						$srtAttributes .= $attribute."='".$modelMenu[$index]->$value."' ";
					}
				}
				$result.= "<a ".$srtAttributes.">".$modelMenu[$index]->alias."</a>";
				if (self::has_children($modelMenu,$modelMenu[$index]->id))
					$result.= self::build_menu($modelMenu,$htmloptions,$id_alias,$modelMenu[$index]->id);
				$result.= "</li>";
			}
		}
		$result.= "</ul>";
		return $result;
	}
	function has_children($modelMenu,$id) {
		foreach ($modelMenu as $index => $val) {
			if ($modelMenu[$index]->parent_id == $id)
				return true;
		}
		return false;
	}
}