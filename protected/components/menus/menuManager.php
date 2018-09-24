<?php

/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */
class menuManager extends CApplicationComponent {

    /**
     * Retorna las opciones HTML y los parametros customizados
     * @param array $param
     */
    public function getHtmlOptions($param = array()) {

        return array_merge($param, array(
            'class' => 'class',
            'style' => 'style',
            'title' => 'title',
            'langCode' =>
            'langCode',
            'dir' => 'dir',
            'href' => 'href',
            'hrefLang' => 'hrefLang',
            'type' => 'rel',
            'rel' => 'rel',
            'rev' => 'rev',
            'shape' => 'shape',
            'coords' => 'coords',
            'target' => 'target',
            'tabIndex' => 'tabIndex',
            'accessKey' => 'accessKey',
            'events' => 'events'));
    }

    /**
     * recorre el objeto de manera recursiva
     * @param type $obj
     */
    function addQuots(&$value) {
        return $value = '"' . $value . '"';
    }

    public function getMenu($condition = '') {
        if (!isset(Yii::app()->session['menuModel'])) {
            Yii::app()->session['menuModel'] = '';
            $menuModel = array();
            $arrMenCreados = array();
            $where = '';
            if($condition != ''){
                $where = "AND (" . $condition . ")";
            }
            if (isset(Yii::app()->session['roles_delphos']) && count(Yii::app()->session['roles_delphos'])) {
                foreach (Yii::app()->session['roles_delphos'] as $rol => $rolObj) {
                    if (is_object($rolObj) || is_array($rolObj)) {                        
                        $modelsMenu = Menu::model()->findAll(array('condition' => "publish like 'si' "
                            . $where,
                            'order' => 'order_menu ASC'));
                        foreach ($modelsMenu as $model) {
                            $clave = $model->id . "-" . $model->controller . "-" . $model->action;
                            if (Yii::app()->session['roles_permisos'][$rol][$model->controller][$model->action] == 1 &&
                                    !in_array($clave, $arrMenCreados)) {
                                $menuModel[] = $model;
                                $arrMenCreados[] = $clave;
                            }
                        }
                    }
                }
                Yii::app()->session['menuModel'] = $menuModel;
            }
        }       
        return Yii::app()->session['menuModel'];
    }

    /**
     * Crea los menus verticales,horizontales
     * @param string $modelMenu
     * @param array $htmloptions
     * @param number $parent
     * @return string
     */
    function build_menu($modelMenu, $htmloptions, $id_alias = '', $parent = 0) {
        foreach ($modelMenu as $index => $val) {
            if ($modelMenu[$index]->parent_id == $parent) {
                $srtAttributes = '';
                $ArrayAttr = array();
                foreach ($htmloptions as $attribute => $value) {
                    if (!is_null($value)) {
                        $ArrayAttr[$attribute] = $modelMenu[$index]->$value;
                    }
                }

                if (self::has_children($modelMenu, $modelMenu[$index]->id)) {
                    $ArrayAttr = array_merge(array('items' => self::build_menu($modelMenu, $htmloptions, $id_alias, $modelMenu[$index]->id)), $ArrayAttr);
                }
                $ArrayMenu[] = array_reverse($ArrayAttr);
            }
        }

        return $ArrayMenu;
    }

    function has_children($modelMenu, $id) {
        foreach ($modelMenu as $index => $val) {
            if ($modelMenu[$index]->parent_id == $id)
                return true;
        }
        return false;
    }

}

?>