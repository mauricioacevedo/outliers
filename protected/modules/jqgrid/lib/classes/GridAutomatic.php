<?php

include_once 'Functions.php';

/**
 * Clase para crear una grid de manera automática
 *
 * @author jarzuaga
 */
class GridAutomatic {

    /**
     * Determina los permisos del informa
     */
    public $permisos = array();
    public $arrAttributesFields = array();

    /**
     * Parametros extras para la edición inline
     */
    public $table = '';
    public $ppal_table = '';
    public $extraParamsEditInline = '';
    public $where = '';
    public $join = '';
    public $bd = '';
    public $typeBd = 'mysql';
    public $bdBase = '';
    public $actionDefault = false;
    public $title = '';
    public $aftersavefunc = 'null';
    public $editInLine = false;
    public $add = false;
    public $del = false;
    public $view = false;

    /**
     * Nombre del template del informe automático
     */
    public $template = '';

    /**
     * Nombre del field_key del informa
     */
    public $field_key = '';
    public $arrFieldType = array();

    /**
     * Define si el informe se va a llamar es de un controlador en particular o si es por el controlador automático, esto es para
     * asegurar los informes
     */
    public $manual = array();
    public $error = false;
    public $sessionGrid = '';

    public function __construct() {
        Yii::import("application.modules.jqgrid.models.*");
        $this->bdBase = Yii::app()->db;
        $this->sessionGrid = new CHttpSession;
        $this->sessionGrid->open();
    }

    /**
     *
     * Éste metodo permite crear una grid automatica a partir de la variable $report_id
     * @param string $report_id
     */
    function createGrid($report_id, $manual = true) {     
        /**
         * Traigo los datos generales del informe
         */
        $sql = "SELECT * FROM tbl_reports WHERE report_id='" . (int)$report_id . "' AND status=1";
        $command = $this->bdBase->createCommand($sql);
        $recordSetKey = $command->query();
        $rowRecordsetKey = $recordSetKey->read();
        if ($rowRecordsetKey['status']) {
            /**
             * Si el informe es a partir de un query, llamo al método createGridTable y le paso el id del informe
             */
            if ($rowRecordsetKey['sql_query'] != '') {
                return $this->createGridFromSQL($report_id, $rowRecordsetKey['sql_query'], $rowRecordsetKey['field_key']);
            } else {
                $objAppModel = new AppModel();
                $objPermissionsModel = new PermissionsModel();
                $rowRecordSetPermission = $objPermissionsModel->permissionsReports($report_id);
                if ($rowRecordSetPermission['view_']) {
                    /**
                     * Traigo los campos del informe
                     */
                    $recordSet = $objAppModel->getFieldstable($report_id, $this->where);
                    $this->table = $rowRecordsetKey['ppal_table'];
                    if ($this->where != ''){
                        $this->where = " AND " . $this->where;
                    }

                    $this->join = '';
                    $sql = "SELECT field_id, foreign_table,table_field,field,foreign_table_field_id, select_complex,alias
                             FROM
                                    tbl_reports_fields
                             WHERE
                                   report_id='" . $report_id . "' AND  foreign_table != '' AND
                                   table_field != '' AND    
                                   foreign_table_field_id != '' " . $this->where . " 
                             ORDER BY
                                    order_field";
                    $command = $this->bdBase->createCommand($sql);
                    $recordSet2 = $command->query();
                    $arrForeignTables = array();
                    $arrForeignTablesfield_id = array();
                    $arrTables[] = $this->table;
                    while (($rowRecordset2 = $recordSet2->read()) !== false) {
                        if ($this->table != $rowRecordset2['foreign_table']) {
                            $arrTables[] = $rowRecordset2['foreign_table'];
                            if (in_array($rowRecordset2['foreign_table'], $arrForeignTables)) {
                                $alias = $rowRecordset2['foreign_table'] . '_alias_' . $rowRecordset2['field_id'];
                                $arrForeignTablesfield_id[] = $rowRecordset2['field_id'];
                            } else {
                                $alias = str_replace(".", "_", $rowRecordset2['foreign_table']);
                            }
                            $arrForeignTables[] = $rowRecordset2['foreign_table'];
                            if (!$rowRecordset2['select_complex']) {
                                $this->join .= ' Left Join ' . $rowRecordset2['foreign_table'] . ' as ' . $alias . ' ON ' . $rowRecordset2['table_field'] . '.' . $rowRecordset2['field'] . ' = ' . $alias . '.' . $rowRecordset2['foreign_table_field_id'] . ' ';
                            } else {
                                /**
                                 * Si el select es complejo, tomo la tabla y el campo alias para realiza la relación, es importante
                                 * que el campo alias se llame igual al del campo de la tabla
                                 */
                                $this->join .= ' Left Join ' . $rowRecordset2['foreign_table'] . ' as ' . $alias . ' ON ' . $rowRecordset2['table_field'] . '.' . $rowRecordset2['alias'] . ' = ' . $alias . '.' . $rowRecordset2['foreign_table_field_id'] . ' ';
                            }
                        }
                    }
                    $field_key = $rowRecordsetKey['field_key'];
                    /**
                     * Creo el objeto grid
                     */                    
                    $grid = new Grid(Yii::app()->components['db']->username, Yii::app()->components['db']->password, $rowRecordsetKey['host'], $rowRecordsetKey['bd']);
                    $grid->report_id = $report_id;
                    $this->arrFieldType = $this->sessionGrid['arrFieldType'];

                    $this->permisos['edit'] = $rowRecordSetPermission['edit'];
                    $this->permisos['delete'] = $rowRecordSetPermission['delete_'];
                    $this->permisos['insert'] = $rowRecordSetPermission['insert_'];

                    $this->manual = $rowRecordsetKey['manual'];
                    $grid->bdName = $rowRecordsetKey['bd'];
                    $grid->staticWhere = $rowRecordsetKey['static_where'];
                    $this->width = $rowRecordsetKey['width'];
                    $grid->exportExcel = $rowRecordSetPermission['excel'];
                    $grid->exportTxt = $rowRecordSetPermission['txt'];
                    $grid->exportPdf = $rowRecordSetPermission['pdf'];
                    $grid->exportWord = $rowRecordSetPermission['word'];
                    if ($this->width > 0) {
                        $grid->width = $this->width;
                    }
                    $grid->setGrid($report_id, $this->table . $this->join, $field_key, $this->table, true);
                    if ($rowRecordsetKey['toppager']) {
                        $grid->options['toppager'] = true;
                    } else {
                        $grid->options['toppager'] = false;
                    }
                    $grid->staticWhere .= $objAppModel->whereFieldsTable($report_id);
                    /**
                     * Establezco el objeto de base de datos para armar las opciones tipo listas
                     */
                    if($rowRecordsetKey['bd'] == '' && $rowRecordsetKey['host'] == ''){
                        $rowRecordsetKey['bd'] = DB;
                        $rowRecordsetKey['host'] = INSTANCE;
                    }
                    $dsn = $this->typeBd . ":host=" . $rowRecordsetKey['host'] . ";dbname=" . $rowRecordsetKey['bd'];
                    $this->bd = new CDbConnection($dsn, Yii::app()->components['db']->username, Yii::app()->components['db']->password);
                    $this->bd->charset = 'utf8';
                    $this->attributesFields($arrTables);
                    $arrAttributesFields = $this->arrAttributesFields;
                    if (!is_array($arrAttributesFields)) {
                        echo "Error en la consulta " . $objBd->msgError;
                        exit();
                    }
                    if ($rowRecordsetKey['show_title']) {
                        $this->title = $rowRecordsetKey['description'];
                        $grid->options['caption'] = $this->title;
                    } else {
                        $grid->options['caption'] = '';
                    }
                    /**
                     * Define si se muestra o no el filtro en la barra de titulos de la grid
                     */
                    if ($rowRecordsetKey['toolbarfilter'] == true) {
                        $grid->options['toolbarfilter'] = true;
                    } else {
                        $grid->options['toolbarfilter'] = false;
                    }
                    /**
                     * Establezco si a la grid le pueden insertar registros
                     * Si tiene permisos y si la grid esta configurada para insertar
                     */
                    if ($this->permisos['insert'] && $rowRecordsetKey['insert_']) {
                        $grid->add = true;
                        /**
                         * Parametros extras cuando se agrega desde el formulario
                         */
                        if (is_array(Yii::app()->params['jqgrid']['extraParamsInsert'])) {
                            $grid->extraParamsInsert = Yii::app()->params['jqgrid']['extraParamsInsert'];
                        }
                    }
                    /**
                     * Establezco si a la grid le pueden edit registros
                     * Si tiene permisos y si la grid esta configurada para insertar
                     */
                    $tableCrud = sha1('tblCrudGrid' . $grid->name);
                    $_SESSION['sqlTableCrud'][$tableCrud] = $grid->bdName . "." . $this->table;
                    if ($this->permisos['edit'] && $rowRecordsetKey['edit']) {
                        $grid->edit = true;
                        /**
                         * Parametros extras cuando se agrega desde el formulario
                         */
                        if (is_array(Yii::app()->params['jqgrid']['extraParamsEdit'])) {
                            $grid->extraParamsEdit = Yii::app()->params['jqgrid']['extraParamsEdit'];
                        }
                        if ($this->extraParamsEditInline != '') {
                            $this->extraParamsEditInline = "," . $this->extraParamsEditInline;
                        }
                        if (Yii::app()->params['jqgrid']['extraParamsEditInline'] != '') {
                            $this->extraParamsEditInline = "," . Yii::app()->params['jqgrid']['extraParamsEditInline'];
                        }
                        if ($rowRecordsetKey['edit_inline']) {
                            $this->editInLine = $rowRecordsetKey['edit_inline'];
                        }
                        if ($this->editInLine) {
                            $grid->onSelectRow = " 
											if(rowid){ 
												editparameters = {
																	'keys' 				: true,
																	'oneditfunc' 		: null,
																	'successfunc' 		: null,
																	'url' 				: null,
																    'extraparam' 		: {'type':'update','ignore':'ignore,tableCrud,fields,type,oper,key,id," . Yii::app()->request->csrfTokenName . "',
																							'tableCrud':'" . $tableCrud . "','key':'" . $field_key . "',
																							'" . Yii::app()->request->csrfTokenName . "':'" . Yii::app()->request->csrfToken . "'
																							" . $this->extraParamsEditInline . "
																						},
																	'aftersavefunc' 	: " . $this->aftersavefunc . ",
																	'errorfunc'			: null,
																	'afterrestorefunc' 	: null,
																	'restoreAfterError' : true,
																	'mtype' 			: 'POST'
																}
												jQuery(table_id_" . $grid->name . ").jqGrid('editRow', rowid, editparameters ); 
												lastRowSel = rowid;
											}";
                        }
                    }
                    /**
                     * Establezco si a la grid le pueden edit registros
                     */
                    if ($this->permisos['delete'] && $rowRecordsetKey['delete_']) {
                        $grid->del = true;
                    }
                    /**
                     * Por defecto no muestro el número de las filas
                     */
                    $grid->options['rownumbers'] = false;
                    if ($this->actionDefault == true) {
                        /*
                         * Titulo para cuando quier mostrar solo texto
                         */
                        $grid->icons_title = array('Edit');
                        $grid->haveAction = true;
                        $grid->icons_fields = array(array('valorkey' => $field_key));
                    }
                    $order_by = '';
                    $groupby = '';
                    while (($rowRecordset = $recordSet->read()) !== false) {
                        $arrPropertys = array();
                        $formatoptions = '';
                        $editoptions = '';
                        $arrPropertys['formatter'] = 'text';
                        /**
                         * Configurar las columnas agrupadas
                         */
                        $rowRecordset['field'] = stripcslashes($rowRecordset['field']);
                        if ($rowRecordset['group_header'] != '') {
                            $grid->groupHeaders['titleText'][] = $rowRecordset['group_header'];
                            $grid->groupHeaders['startColumnName'][] = $rowRecordset['alias'];
                            $grid->groupHeaders['numberOfColumns'][] = $rowRecordset['group_header_columns'];
                        }
                        if ($rowRecordset['order_by'] != '') {
                            $order_by .= $rowRecordset['table_field'] . "." . $rowRecordset['field'] . " " . $rowRecordset['order_by'] . ",";
                        }
                        if ($rowRecordset['group_by'] == 1) {
                            $groupby .= $rowRecordset['table_field'] . "." . $rowRecordset['field'] . ",";
                        }

                        $arrOpcionesId = '';
                        $arrOpciones = '';
                        $strOpciones = '';
                        $strOpcionesFiltro = '';

                        $rowRecordset['field_type'] = $this->arrFieldType['field_type'][$rowRecordset['field_type_id']];
                        
                        if ($rowRecordset['frozen_column']) {
                            $arrPropertys['frozen'] = 'true';
                            $grid->options['frozenColumns'] = true;
                        }
                        if ($rowRecordset['summary_type']) {
                            $arrPropertys['summaryType'] = $rowRecordset['summary_type'];
                        }
                        if ($rowRecordset['summary_tpl']) {
                            $arrPropertys['summaryTpl'] = $rowRecordset['summary_tpl'];
                        }
                        /**
                         * Establezco las reglas de mi busqueda
                         * Ej:  "required":true, "number":true, "maxValue":13
                         * http://www.trirand.com/jqgridwiki/doku.php?id=wiki:search_config
                         */
                        if ($rowRecordset['searchrules'] != '') {
                            $arrPropertys['searchrules'] = '{' . $rowRecordset['searchrules'] . '}';
                        }
                        /**
                         * Seteo el tipo de busqueda de acuerdo al tipo de campo
                         */
                        if ($this->arrFieldType['searchtype'][$rowRecordset['field_type_id']] != '') {
                            $arrPropertys['searchtype'] = $this->arrFieldType['searchtype'][$rowRecordset['field_type_id']];
                        }
                        /**
                         * Seteo el tipo de busqueda de acuerdo al tipo de campo
                         */
                        if ($this->arrFieldType['sopt'][$rowRecordset['field_type_id']] != '') {
                            $comparisions = explode(",", $this->arrFieldType['sopt'][$rowRecordset['field_type_id']]);
                            $comparisions = "'" . implode("','", $comparisions) . "'";
                            $arrPropertys['searchoptions'] = "sopt:[" . $comparisions . "]";
                        } else {
                            $arrPropertys['searchoptions'] = "sopt:['cn']";
                        }
                        /**
                         * Si algún día existe el campo de idioma
                         */
                        $idioma = 'label';
                        /**
                         * Si field_find esta seteaddo se busca en esa tabla.campo 
                         */
                        $arrPropertys['field_find'] = $rowRecordset['field_find'];
                        $arrPropertys['fieldType'] = $rowRecordset['field_type'];
                        $arrPropertys['hidden'] = 'false';
                        $arrPropertys['search'] = 'true';
                        if(!$rowRecordset['search']){
                            $arrPropertys['search'] = 'false';
                        }
                        $arrPropertys['label'] = $rowRecordset[$idioma];
                        /**
                         * Por defecto todos los campos de la grid se editan, menos el campo key
                         */
                        $arrPropertys['edithidden'] = 'true';
                        $arrPropertys['editable'] = 'false';
                        $editable = false;
                        if (($grid->edit || $grid->add) && $field_key != $rowRecordset['field'] && $rowRecordset['editable']) {
                            $editable = true;
                            $arrPropertys['editable'] = 'true';
                            $arrPropertys['edithidden'] = 'true';
                        }
                        $search = true;
                        if (!$rowRecordset['show_in_grid'] || $rowRecordset['field_type'] == 'hidden') {
                            $arrPropertys['hidden'] = 'true';
                            $search = false;
                        }
                        $arrPropertys['search'] = 'true';
                        if (!$search || !$rowRecordset['search']) {
                            $arrPropertys['search'] = 'false';
                        }
                        /**
                         * Alineación
                         */
                        $arrPropertys['align'] = $rowRecordset['align'];
                        $arrPropertys['editrules'] = 'required:false';
                        if ($rowRecordset['required']) {
                            $arrPropertys['editrules'] = 'required:true';
                        }
                        if ($rowRecordset['field_type'] == "date") {

                            $arrPropertys['formatter'] = 'date';
                            $formatoptions = "srcformat : 'Y-m-d', newformat : 'Y-m-d'";
                            $arrPropertys['editrules'] .= ',date:true';
                            $arrPropertys['stype'] = 'text';
                            $arrPropertys['searchoptions'] .= ",size: 10,dataInit:function(el){\$(el).datepicker({dateFormat:'yy-mm-dd'});}";
                            if ($editable) {
                                $editoptions = "size: 10,dataInit:function(el){\$(el).datepicker({dateFormat:'yy-mm-dd'});}";
                            }
                        } else if ($rowRecordset['field_type'] == 'currency' || $rowRecordset['field_type'] == 'currency_no_decimals') {
                            /**
                             * Por defecto creo los totales de mi consulta, si el tipo_cmapo es numeric
                             */
                            $arrPropertys['total'] = true;
                            $arrPropertys['formatter'] = 'currency';
                            $grid->showFieldTotal=true;
                            if ($rowRecordset['field_type'] == 'currency_no_decimals') {
                                $formatoptions = 'decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: "$ "';
                            } else {
                                $formatoptions = 'decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 2, prefix: "$ "';
                            }
                            if ($editable) {
                                $arrPropertys['edittype'] = 'currency';
                            }
                        } else if ($rowRecordset['field_type'] == 'checkbox') {
                            /**
                             * Temporalmente los checkbox serán select con SI/NO, dada la limitante que tiene el checkbox
                             */
                            if ($editable) {
                                /*$arrPropertys['formatter'] = 'checkboxFormatter';
                            $grid->arrNoColumnsQuotePropertys[$rowRecordset['field']] = 'formatter';
                            Yii::app()->clientScript->registerScript('checkboxFormatter', " 
                                                    function checkboxFormatter(cellvalue, options, rowObject) {
                                                      if(cellvalue == 1){ 
                                                        $('#'+options['rowId']+'_".$rowRecordset['field']."').prop('checked', true);
                                                        return '".$grid->language_txt['text_yes']."';
                                                      }else{
                                                        $('#'+options['rowId']+'_".$rowRecordset['field']."').prop('checked', false);
                                                        return '".$grid->language_txt['text_no']."';
                                                      }
                                                    }\n", 1);
                                $arrPropertys['edittype'] = 'checkbox';
                                $editoptions = "value:'1:0'";
                                $formatoptions = 'checkbox : {disabled:true}';*/
                                $arrPropertys['edittype'] = 'select';
                                $editoptions = "value:':;1:SI;0:NO'";
                            }
                            $arrPropertys['stype'] = 'select';
                            $arrPropertys['searchoptions'] .= ",value:':;1:SI;0:NO'";
                        } else if ($rowRecordset['field_type'] == 'password') {
                            if ($editable) {
                                $arrPropertys['edittype'] = 'password';
                            }
                        } else if ($rowRecordset['field_type'] == 'textarea') {
                            if ($editable) {
                                $arrPropertys['edittype'] = 'textarea';
                            }
                        } else if ($rowRecordset['field_type'] == 'combox_array' || $rowRecordset['field_type'] == 'combox_table' || $rowRecordset['field_type'] == 'checkboxMultiple') {
                            /**
                             * Si el campo es tipo lista, se organiza para crear un combo
                             */
                            $value = array();
                            $value[] = ':Seleccione';
                            if ($rowRecordset['field_type'] == "combox_array") {
                                list($arrOpctionsId, $arrOpctions) = explode("|", $rowRecordset['option_list']);
                                $arrOpctionsId = explode(":", $arrOpctionsId);
                                $arrOpctions = explode(":", $arrOpctions);
                                foreach ($arrOpctionsId as $key => $OptionId) {
                                    $value[] = $OptionId . ":" . $arrOpctions[$key];
                                }
                            } else if (($rowRecordset['field_type'] == "combox_table" || $rowRecordset['field_type'] == "checkboxMultiple") && $rowRecordset['select_sql'] != '' && $rowRecordset['field_id_list'] != '' && $rowRecordset['field_desc_list'] != '') {
                                /**
                                 * Ejecuto el SQL para armar la lista
                                 */
                                $command1 = $this->bd->createCommand($rowRecordset['select_sql']);
                                $recordSet_1 = $command1->query();   
                                while (($rowRecordset_1 = $recordSet_1->read()) !== false) {
                                    $value[] = $rowRecordset_1[$rowRecordset['field_id_list']] . ':' . str_ireplace("'", "\'", $rowRecordset_1[$rowRecordset['field_desc_list']]);                                    
                                }       
                            }
                            $valuesFilter = $value;
                            if ($rowRecordset['select_filter'] != '') {
                                $valuesFilter = array();
                                $valuesFilter[] = ':Seleccione';
                                $command1 = $this->bd->createCommand($rowRecordset['select_filter']);
                                $recordSet_1 = $command1->query();
                                $rowRecordset_1 = $recordSet_1->readAll();
                                $i = 0;
                                /**
                                 * Obtengo el primer y segundo nombre de columna, el primero corresponde al value de la lista y el
                                 * segundo a la descripción de la lista
                                 */
                                foreach ($rowRecordset_1[0] as $key => $val) {
                                    if ($i == 0) {
                                        $id = $key;
                                    } elseif ($i == 1) {
                                        $desc = $key;
                                    } else {
                                        break;
                                    }
                                    $i++;
                                }
                                foreach ($rowRecordset_1 as $key => $val) {
                                    $valuesFilter[] = $rowRecordset_1[$key][$id] . ':' . str_ireplace("'", "\'", $rowRecordset_1[$key][$desc]);
                                }
                            }
                            $strOpciones		= "value:'".implode(';', $value)."'";
                            $arrPropertys['edittype']	= 'select';
                            $arrPropertys['stype']	= 'select';
                            $arrPropertys['searchoptions'] .= ",value:'".implode(';', $valuesFilter)."'";
                            if(($grid->edit || $grid->add) && $field_key != $rowRecordset['field'] && $rowRecordset['editable'] == true)
                            {
                                    $editoptions	= $strOpciones;			
                            }
                        } else {
                            if ($editable) {
                                if ($arrAttributesFields['type'][$rowRecordset['field']] == 'integer') {
                                    $arrPropertys['formatter'] = 'integer';
                                    $arrPropertys['editrules'] .= ',integer:true';
                                } elseif ($arrAttributesFields['type'][$rowRecordset['field']] == 'double') {
                                    $arrPropertys['formatter'] = 'number ';
                                    $arrPropertys['editrules'] .= ',number:true';
                                } elseif ($arrAttributesFields['type'][$rowRecordset['field']] == 'date') {
                                    $arrPropertys['editrules'] .= ',date:true';
                                }
                                if ($rowRecordset['field_type'] == 'hidden') {
                                    $arrPropertys['editrules'] .= ',hidden:true';
                                }
                            }
                            $arrPropertys['edittype'] = 'text';
                        }

                        if ($rowRecordset['format_options'] != '') {
                            $arrPropertys['formatoptions'] = "{" . $rowRecordset['format_options'] . "}";
                        } elseif ($formatoptions != '') {
                            $arrPropertys['formatoptions'] = "{" . $formatoptions . "}";                            
                        }
                        /**
                         * http://www.trirand.com/jqgridwiki/doku.php?id=wiki:predefined_formatter
                         */                        
                        if ($rowRecordset['formatter'] != '') {
                            $arrPropertys['formatter'] = $rowRecordset['formatter'] ;
                        } 
                        if ($rowRecordset['formoptions'] != '') {
                            $arrPropertys['formoptions'] = "{" . $rowRecordset['formoptions'] . "}";
                        } elseif ($formoptions != '') {
                            $arrPropertys['formoptions'] = "{" . $formoptions . "}";                            
                        }
                        if ($rowRecordset['edit_options'] != '') {
                            $arrPropertys['editoptions'] = "{" . $rowRecordset['edit_options'] . "}";
                        } elseif ($editoptions != '') {
                            $arrPropertys['editoptions'] = "{" . $editoptions . "}";                            
                        }
                        if ($arrPropertys['editrules'] != '' || $rowRecordset['editrules'] != '') {
                            $editrules = $arrPropertys['editrules'];
                            if($editrules != '' && $rowRecordset['editrules'] !=''){
                                $editrules .= ','.$rowRecordset['editrules'];
                            }
                            $arrPropertys['editrules'] = "{" . $editrules . "}";
                        }
                        /**
                         * Ancho de la columna
                         */
                        if ($rowRecordset['width_column'] == '') {
                            $rowRecordset['width_column'] = 0;
                        }
                        $arrPropertys['width'] = $rowRecordset['width_column'];
                        $arrPropertys['searchoptions'] = '{' . $arrPropertys['searchoptions'] . '}';
                        /**
                         * Creo el campo de la grid
                         */
                        if ($rowRecordset['foreign_table'] != '') {
                            /**
                             * Establezco un parametro del campo de la tabla principal para realizar busquedas cuando es tipo combox_table
                             * para que busque por ID de la tabla en cuestión
                             */
                            if ($rowRecordset['select_complex']) {
                                $grid->setColProperty($rowRecordset['alias'], $rowRecordset['foreign_table_desc'], $rowRecordset['alias'], $rowRecordset['table_field'], $arrPropertys);
                            } else {
                                $alias_field_key = '';
                                $rowRecordset['foreign_table'] = str_replace(".", "_", $rowRecordset['foreign_table']);
                                if (in_array($rowRecordsetKey['field_key'], $arrForeignTablesfield_id)) {
                                    $alias_field_key = "_alias_" . $rowRecordsetKey['field_key'];
                                }
                                $grid->setColProperty($rowRecordset['alias'], $rowRecordset['foreign_table'] . $alias_field_key . "." . $rowRecordset['foreign_table_desc'], $rowRecordset['alias'], $rowRecordset['table_field'], $arrPropertys);
                            }
                        } else {
                            if ($rowRecordset['function_aggregate'] != '') {
                                $grid->setColProperty($rowRecordset['alias'], $rowRecordset['function_aggregate'] . "(" . $rowRecordset['table_field'] . "." . $rowRecordset['field'] . ")", $rowRecordset['alias'], $arrPropertys);
                            } elseif ($rowRecordset['select_complex'] == true) {
                                $grid->setColProperty($rowRecordset['alias'], $rowRecordset['field'], $rowRecordset['alias'], $rowRecordset['table_field'], $arrPropertys);
                            } else {
                                $grid->setColProperty($rowRecordset['alias'], $rowRecordset['table_field'] . "." . $rowRecordset['field'], $rowRecordset['alias'], $rowRecordset['table_field'], $arrPropertys);
                            }
                        }
                    }
                    /**
                     * Establecer el order si lo hay
                     */
                    if ($order_by != '') {
                        $grid->orderBy = substr($order_by, 0, -1);
                    }
                    if ($groupby != '') {
                        $grid->groupby = " GROUP BY " . substr($groupby, 0, -1);
                    }
                    return $grid;
                } else {
                    $this->error = true;
                    $this->mensaje['error'][] = 'No poseé permisos para ingresar en ésta área';
                }
            }
        }
    }

    /**
     *
     * Éste metodo permite crear una grid automatica a partir de la tabla enviada, es de tener en
     * cuenta que el campo key no seactualiza
     * @param string $strTableName		//Nombre de la tabla ó report_id si no es tipo tabla
     * @param string $field_key			//field_key por el cual se va a realizar la actualización, éste campo debe ser serial
     * @param string $add				//Atributo de inserción
     * @param string $edit				//Atributo de edición
     */
    function createGridFromSQL($report_id, $sql) {
        
        if($sql != ''){
            $command = $this->bdBase->createCommand($sql.' LIMIT 0,1');
            $dataReader = $command->query();
            $rows = $dataReader->readAll();
            $rows = $rows[0];
            
            //print_r($command->getMetaData()); exit;
            
            
            

            $sql = "SELECT * FROM tbl_reports WHERE report_id='" . (int)$report_id . "' AND status=1";
            $command = $this->bdBase->createCommand($sql);
            $recordSetKey = $command->query();
            $rowRecordsetKey = $recordSetKey->read();
            if ($rowRecordsetKey['status']) {
                 if ($rowRecordsetKey['bd'] == '') {
                    $rowRecordsetKey['bd'] = Yii::app()->params['jqgrid']['dbname_base'];
                 }
                 $grid = new Grid(Yii::app()->components['db']->username, Yii::app()->components['db']->password, $rowRecordsetKey['host'], $rowRecordsetKey['bd']);
                    
            
        
       
            $arrTables[] = $this->ppal_table;
            $arrAttributesFields = array();
            $arrAttributesFields = $this->attributesFields($arrTables);
            
            $grid->setGrid($rowRecordsetKey['report'] . $report_id, $this->table . $this->join, $rowRecordsetKey['field_key'], $this->ppal_table);
            if ($rowRecordsetKey['toppager']) {
                $grid->options['toppager'] = true;
            } else {
                $grid->options['toppager'] = false;
            }
            /**
             * Define si se muestra o no el filtro en la barra de titulos de la grid
             */
            if ($rowRecordsetKey['filtertoolbar'] == true) {
                $grid->options['toolbarfilter'] = true;
            } else {
                $grid->options['toolbarfilter'] = false;
            }
            $grid->options['caption'] = ucwords(strtolower($rowRecordsetKey['description']));
            /**
             * Establezco si a la grid le pueden insertar registros
             */
            if ($field_key != '') {
                if ($rowRecordsetKey['insert_']) {
                    $grid->add = true;
                } else {
                    $grid->add = $add;
                }
                /**
                 * Establezco si a la grid le pueden edit registros
                 */
                if ($rowRecordsetKey['edit']) {
                    $grid->edit = true;
                } else {
                    $grid->edit = $edit;
                }
            }
            foreach ($arrAttributesFields['name'] as $field => $value) {
                if ($field != '') {
                    $label = $field;
                    if ($arrLabels[$field] != '') {
                        $label = $arrLabels[$field];
                    }
                    $arrPropertys['label'] = $label;
                    $arrPropertys['align'] = 'left';
                    if ($arrAttributesFields['type'][$field] != '') {
                        $arrPropertys['fieldType'] = $arrAttributesFields['type'][$field];
                    }
                    if (($grid->edit || $grid->add) && $field_key != $field) {
                        /**
                         * Creo el atributo editable true para cada campo y de acuerdo al tipo
                         * le envio la regal de edición
                         */
                        $editrules = 'required:false';
                        if ($this->arrFieldType[$arrAttributesFields['type'][$field]] == 'int') {
                            $editrules.= 'number:true';
                        } elseif ($this->arrFieldType[$arrAttributesFields['type'][$field]] == 'date') {
                            $editrules .= 'date:true';
                        }
                        $arrPropertys['edittype'] = 'text';
                        $arrPropertys['editrules'] = '{' . $editrules . '}';
                    }
                    if ($field_key != $field) {
                        /**
                         * Establezco el campo para el select
                         */
                        if ($arrAttributesFields['table_field'][$field] != '') {
                            $grid->setColProperty($field, $arrAttributesFields['table_field'][$field] . "." . $field, $field, $arrPropertys);
                        } else {
                            $grid->setColProperty($field, $this->table . "." . $field, $field, $arrPropertys);
                        }
                    }
                }
            }
            return $grid;
        }
        }
    }
/**
     *
     * Éste metodo permite crear una grid automatica a partir de la tabla enviada, es de tener en
     * cuenta que el campo key no seactualiza
     * @param string $strTableName		//Nombre de la tabla ó report_id si no es tipo tabla
     * @param string $field_key			//field_key por el cual se va a realizar la actualización, éste campo debe ser serial
     * @param string $add				//Atributo de inserción
     * @param string $edit				//Atributo de edición
     */
    function createGridFromTable($strTabla) {
        if($strTabla != ''){
            $this->ppal_table = $strTabla;
            $arrAttributesFields = array();
            $arrAttributesFields = $this->attributesFieldsTable($strTabla);  
            $connectionString = trim(Yii::app()->components['db']->connectionString);
            $connectionString = str_ireplace('mysql:', '', $connectionString);            
            $connectionString = explode(';',$connectionString);
            $arrConString = array();
            foreach ($connectionString as $key => $value){
                list($myKey, $myValue) = explode('=', $value);
                $arrConString[$myKey] = $myValue;
            }            
            $grid = new Grid(Yii::app()->components['db']->username, Yii::app()->components['db']->password, $arrConString['host'], $arrConString['dbname']);                 
            $grid->report_id = $this->report_id;
            $grid->setGrid($this->ppal_table, $this->ppal_table, $this->primaryKey, $this->ppal_table, false);            
            $grid->options['caption'] = ucwords(strtolower($this->ppal_table));
            $grid->options['toppager'] = true;
            $grid->options['toolbarfilter'] = true;
            $grid->add = true;
            $grid->edit = true;
            foreach ($arrAttributesFields['name'] as $key => $field) {                
                if ($field != '') {
                    $label = $field;
                    if ($arrLabels[$field] != '') {
                        $label = $arrLabels[$field];
                    }
                    $arrPropertys['label'] = $label;
                    $arrPropertys['align'] = 'left';
                    if ($arrAttributesFields['type'][$field] != '') {
                        $arrPropertys['fieldType'] = $arrAttributesFields['type'][$field];
                    }
                    if (($grid->edit || $grid->add) && $field_key != $field) {
                        /**
                         * Creo el atributo editable true para cada campo y de acuerdo al tipo
                         * le envio la regal de edición
                         */
                        $editrules = 'required:true';
                        if($arrAttributesFields['allowNull'][$field] == 1){
                            $editrules = 'required:false';
                        }
                        if ($this->arrFieldType[$arrAttributesFields['type'][$field]] == 'int') {
                            $editrules.= 'number:true';
                        } elseif ($this->arrFieldType[$arrAttributesFields['type'][$field]] == 'date') {
                            $editrules .= 'date:true';
                        }
                        $arrPropertys['edithidden'] = 'true';
                        $arrPropertys['editable'] = 'true';
                        $arrPropertys['edittype'] = 'text';
                        $arrPropertys['editrules'] = '{' . $editrules . '}';
                    } 
                    if ($field_key != $field) {
                        /**
                         * Establezco el campo para el select
                         */
                        $grid->setColProperty($field, $this->ppal_table . "." . $field, $field, $this->ppal_table, $arrPropertys);                        
                    }
                }
            }
            return $grid;        
        }
    }
    
    /**
     *
     * Éste método devuelve un array con los atributos de los campos de una consulta o tabla
     * @author jarzuas
     * 7/10/2013
     *
     * @param array $arrTables
     * @return array
     */
    function attributesFieldsTable($table) {           
            $arrColumns = Yii::app()->db->schema->getTable($table)->columns;
            //print_r($arrColumns); exit;
            if (is_array($arrColumns)) {
                foreach ($arrColumns as $columnName => $column) {
                    $this->arrAttributesFields['name'][] = $columnName;
                    $this->arrAttributesFields['max_length'][$columnName] = $column->size;
                    $this->arrAttributesFields['type'][$columnName] = $column->type;
                    $this->arrAttributesFields['table'][$columnName] = $table;
                    $this->arrAttributesFields['isPrimaryKey'][$columnName] = $column->isPrimaryKey;                    
                    $this->arrAttributesFields['allowNull'][$columnName] = $column->allowNull;                    
                    if($column->isPrimaryKey){
                        $this->primaryKey = $columnName;
                    }
                }
            }
        return $this->arrAttributesFields;
    }
    /**
     *
     * Éste método devuelve un array con los atributos de los campos de una consulta o tabla
     * @author jarzuas
     * 7/10/2013
     *
     * @param array $arrTables
     * @return array
     */
    function attributesFields($arrTables) {
        foreach ($arrTables as $key => $table) {
            $arrColumns = $this->bd->schema->tables[$table]->columns;
            if (is_array($arrColumns)) {
                foreach ($arrColumns as $columnName => $column) {
                    $this->arrAttributesFields['max_length'][$columnName] = $column->size;
                    $this->arrAttributesFields['type'][$columnName] = $column->type;
                    $this->arrAttributesFields['table'][$columnName] = $table;
                }
            }
        }
        return $this->arrAttributesFields;
    }

}
