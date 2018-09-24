<?php
include_once 'Functions.php';
/**
 * Clase Grid
 * Esta clase construye una grid con vinculada a una consulta SQL
 * @version	$Id: Grid.class.php,v 1.0.0 2013/10/02
 * @access	public
 * @license	GPL version 2 or later.
 * @author	Jorge Arzuaga <jorgearzuaga1@hotmail.com>
 */
class Grid {
	protected $bd					= '';
	public $strGrid					= '';
        /**
         * ID dle reporte automático, sirve para poder establecer los permisos de la Grid, para un CRUD se debe 
         * estar registrado con el ID del reporte para ver los permisos
         */
	public $report_id				= '';
	/**
	 * Determines whether the Grid is a subgrid by default is not a subgrid
	 */
	public $isSubGrid				= false;
	/**
	 * Determines whether the grid contains a subgrid
	 */
	public $hasSubGrid				= false;
	/**
	 * Parametres array subgrid
	 */
	public $paramSubGrid			= array();
	/**
	 * Html Content Grid
	 */
	protected $strHtml				= '';
	/**
	 * Array of columns in the Grid
	 */
	public $columns					= array();
        public $arrNoColumnsQuotePropertys              = array();
	/**
	 * Counting the number of visible columns	
	 */
	public $numberColumnsVisibles	= 0;
	/**
	 * Array of columns in the Grid, in original state
	 */
	public $columnsOriginal			= array();
	/**
	 * This variable define if show the sql query in the reponse
	 */
	public $debug				= '';
	/**
	 * Define if show or no the field total when there is some field money
	 */
	public $showFieldTotal			= true;
	/**
	 * This variable contains the responce in JSON via AJAX Grid
	 */
	public $responce				= '';
	/**
	 * Determines whether fixed columns
	 */
	public $frozenColumns			= false;
	/**
	 * Define the language of the grid, language files are in
	 * /protected/modules/jqgrid/lib/jqGrid/src/i18n/
	 */
	public $language				= 'es';
	/**
	 * Array with the texts in their respective language
	 */
	public $language_txt			= array();
	/**
	 * Define if fields type checkbox show as image or text
	 */
	public $checkbox_image			= false;
	/**
	 * Text modal window to select the fields to export
	 */
	public $textExportWindow		= 'Seleccione los campos a exportar';
	/**
	 * Defines whether the grid can be edited or not
	 */
	public $edit					= false;
	/**
	 * Defines el texto que se muestra cuando no se actualiza el registro
	 */
	public $textNoUpdate			= 'No se actualizó el registro';
	/**
	 * Defines el texto que se muestra cuando no se actualiza el registro
	 */
	public $textNoDelete			= 'No se eliminó el registro';
	/**
	 * Defines extra parameters to insert data
	 */
	public $extraParamsInsert		= array();
	/**
	 * Defines extra parameters to edit data
	 */
	public $extraParamsEdit			= array();
	/**
	 * Defines whether the grid can insert records
	 */
	public $add						= array();
	/**
	 * Defines whether the grid can delete records
	 */
	public $del						= '';
	/**
	 * Defines whether the grid can be searched
	 */
	public $search					= '';
	/**
	 * Defines whether the grid style data view window
	 */
	public $view					= '';
	/**
	 * Determina si se muestra o no el icono de recargar la grid
	 */
	public $iconReloadGrid			= true;
	/**
	 * Sets whether to display the icon to clean filters
	 */
	public $cleanFilters			= false;
	/**
	 * Separator or txt flat file, for which data are exported
	 */
	public $filesSeparator			= ';';
	/**
	 * Field by which column is sorted columns
	 */
	public $sidx 					= '';
	/**
	 * Sort Type column when ordering columns
	 */
	public $sord						= '';
	/**
	 * Array with the alias name of the column as key and the title as value
	 */
	public $arrColAlias					= '';
	/**
	 * Folder Path where the files of the Grid
	 */
	public $pathGrid			= '';
	/**
	 * Folder Path where the imagendes of the buttons on the Grid
	 */
	public $pathImagesButtons		= '';
	/**
	 * Route the application index
	 */
	public $pathIndex			= '';
	/**
	 * Default URL for actions
	 */
	public $urlActionDefault			= '';
        /**
         * Aplica para abrir la acción en la misma ventana
         */
	public $urlActionDefaultTarget			= '';
	/**
	 * Array with the grouping of columns
	 */
	public $groupHeaders			= array();
        
        /**
         * Determina si es autoresponsive
         */
        public $responsive                      = true;
	/**
	 * Alias ​​the field by which you perform the clustering
	 */
	public $groupField				= array();
	/**
	 * Default URL for actions in modal window
	 */
	public $urlActionModalDefault	= '';
	/**
	 * Options for actions for default URL in modal window
	 */
	public $urlActionModalOptions	= '';
	/**
	 * Get additional variables that are passed to the actions of the grid
	 */
	public $varsUrl					= '';
	/**
	 * Array with fields that are associated with the URL nombre_get => campo_value
	 */
	public $urlActionCampo			= array();
	/**
	 * Fields that are associated with the URL field_name => array (nombre_get => campo_value)
	 * This $ urlActionCampo prevails properties and serves to when I need to send particulars for each
	 * Field and is formed like this: $ grid-> urlActionFieldLink ['field_name'] = array ('var_get' => 'alias_campo');
	 */
	public $urlActionFieldParam		= array();
	/**
	 * Array with the type of action to take, eg modal dialog
	*/
	public $icons_action			= array();
	/**
	 * Array with the option to dialog as same of jquery
	*/
	public $icons_action_options	= array();
	/**
	 * Array with JS function name to be executed, the default URL is passed and the key field
	 */
	public $icons_action_js			= array();
	/**
	 * Associative array with the url of the icons displayed in the column actions
	 */
	public $icons_url				= array();
	/**
	 * Associative array with fields in the query we want to be added to the GET variables
	 * URL shown in column actions
	 */
	public $icons_fields			= array();
	/**
	 * Array with the target for each action, applies when $ icons_action != dialog
	 */
	public $icons_target			= array();
	/**
	 * Array with images that are shown in the column actions
	 */
	public $icons_img				= array();
	/**
	 * Array containing the titles of the posts floating stock icons
	 */
	public $icons_text				= array();
	/**
	 * Array that contains the message text floating stock icons
	 */
	public $icons_title				= array();
	/**
	 * Define whether or not shown action Column
	 */
	public $haveAction				= false;
	/**
	 * Name of title that will appear in the Action column
	 */
	public $title_action			= 'Acción';
	/**
	 * Column width percentage action
	 */
	public $widthAction     		= 20;
	/**
	 * Defines whether or not to display search operators when $ filterToolbar = true
	 */
	public $searchOperators			= true;
	/**
	 * Defines the type of search filters titles
	 */
	public $defaultSearch			= 'cn';
	/**
	 * Determines whether to display multiple search option
	 */
	public $multipleSearch			= true;
	/**
	 * Determines whether to display the option to search by group, ie add an OR or AND
	 */
	public $multipleGroup			= false;
	/**
	 * Determines whether or not to display the query that is being made in the search window
	 */
	public $showQuery				= true;
	/**
     * Js Content added to each row of the grid, when you right click
     */
   public $onRightClickRow			= '';
   /**
    * Js Content that adds to the grid in the complete event
    */
   public $gridComplete				= '';
   /**
    * Array of grid events after insert/update data
    */
   public $arrAfterEvents			= array();
   /**
    *  Array of grid events before insert/update data
    */
   public $arrBeforeEvents			= array();
   /**
    * Js Content added to each row of the grid
    */
   public $afterInsertRow			= '';
   /**
    * Content js to execute the grid to start the Resize a cell
    */
   public $resizeStart				= '';
   /**
    * Content js to execute the grid to finish a cell Resize
    */
   public $resizeStop				= '';
   /**
    * Content js to execute the grid to select a row
    */
   public $onSelectRow				= '';
   /**
    * Content js to execute the grid to select a row
    */
   public $beforeSelectRow				= '';
   /**
    * Content js to execute the grid to select a row
    */
   public $beforeEditCell       		= '';
   /**
    * Content js to execute after loading the edit form and addition
    */
   public $beforeShowForm			= '';
   /**
    * Content js to execute after loading the edit form and addition
    */
   public $afterShowForm			= '';
	/**
	 * Window size of the edit form grid
	 */
	public $widthFormEdit			= 'auto';	
	/**
	 * Defines whether to display the export options of the grid
	 */
	public $showExport   		= true;
	/**
	 * Contains the text generated in the export
	 */
	protected  $export				= '';
	/**
	 * Contains the text generated in the export
	 */
	protected  $exportContentTxt				= '';
	/**
	 * Contains the SQL that runs on the export methods
	 */
	public $strSqlExport          		= '';
	/**
	 * This property is used in the PDF export method and what function does is run as its content, is passed as a parameter the object
	 * MPDF, this must be received by reference to modify its properties. This function must be defined in	 
	 */
	public $functionSetExportFilePdf		= '';
	/**
	 * This property is used in the method to export Excel and what function does is run as its contents, this function must be defined 
	 */
	public $functionSetExportFileExcelHtml	= '';
	/**
	 * Array with Field order exporting
	 */
	public $arrSqlOrderExport		= array();
	/**
	 * Image path is placed in the body
	 */
	public $pathImgPdfBody			= '';
	/**
	 * Image path is placed at the beginning of the pdf as a header
	 */
	public $pathImgPdf				= '';
	/**
	 * Array with columas to be exported, you must enter Y in the position of columns to export or otherwise N
	 */
	public $rowsExport         	= '';
	/**
	 * Number of columns to be exported
	 */
	public $numRowsExport        = 0;
	/**
	 * Defines whether to export the column titles
	 */
	public  $exportTitle			= true;
	/**
	 * Defines whether or not to display the icon export to excel
	 */
	public $exportExcel			= true;
	/**
	 * Defines whether or not to display the icon export to csv ;
	 */
	public $exportCsv				= false;
	/**
	 * Defines whether or not to display the icon export to word
	 */
	public $exportWord				= true;
	/**
	 * Defines whether or not to display the icon export to txt
	 */
	public $exportTxt				= true;
	/**
	 * Defines whether or not to display the icon export to pdf
	 */
	public $exportPdf				= true;
	/**
	 *String with all the buttons created and will be displayed on the bottom bar of the grid
	 */
	protected $strButtons		= '';
	/**
	 * Number of times you refill the grid
	 */
	public $reloadNumber			= 0;
	/**
	 * Sets whether to display the icon to show / hide columns
	 */
	public $show_hide_columns		= false;
	/**
	 * Array with the filters applied to the Grid
	 */
	public $filters					= array();
	/**
	 * Array with translation options sent by the Grid where
	 */
	protected  $traduceOpWhere		= array("eq" => "=","ne" => "<>", "lt" => "<", "le" => "<=", "gt" => ">", "ge" => ">=", "in" => "in",
                                                        "ni" => "ni", "nu" => "is null", "nn" => "is not null", "bw" => "bw", "bn" => "bn", "ew" => "ew",
                                                        "en" => "en", "cn" => "cn", "nc" => "nc" );
	/**
	 * Name of the grid
	 */
	public $name               	= "MyGrid";
	/**
	 * Unique name of the Grid
	 */
	public $uniqueName			= '';
	/**
	 * Name of the primary field of Grid
	 */
	public $keyField			= '';
	/**
	 * Name of the parent table, the grid where the main operations were carried
	 */
	public $ppalTable			= '';	
	/**
	 * Defines whether or not the input semuestra and the search button when the navigation bar is at the top
	 */
	public $inputSearch              = true;
	/**
	 * Field post sent from the input that searches all fields
	 */
	public $gridInputFind       	= '';
	/**
	 * Text displayed in the input to search by keyword
	 */
	public $textInputSearch 		= 'Buscar Palabra Clave';
	/**
	 * Sets whether or not the word highlighted in each data matching the query
	 */
	public $standOutFind       	= true;
	/**
	 * Contains the conditions that apply to the Grid
	 */
	public $where                	= '';
	/**
	 * Contains the JSON filters send by GET when do it search
	 */
	public $filtersSearch                	= '';
	/**
	 * Contains fixed conditions are burned in the code and do not change during when the Grid does upadte
	 */
	public $whereUpdate          	= '';
	/**
	 * Contains fixed conditions are burned in the code and do not change during when the Grid does delete
	 */
	public $whereDelete          	= '';
	/**
	 * Contains fixed conditions are burned in the code and do not change during the execution of the Grid
	 */
	public $staticWhere           	= '';
	/**
	 * Identify options in the Grid grouping, include the word GROUP BY
	 */
	public $groupby              	= '';
	/**
    * Contains the SQL armed and that is executed by the grid
    */
  	public $sql                	= '';
  	/**
  	 * Contains select each field as an array
  	 */
  	public $arrSqlExport          	= array();
	/**
    * Contains the SQL select run
    */
  	public $selectSql				= array();
    /**
	 * Defines whether to create a key field from keyField
	 */
	public $createFieldId		= true;
    /**
	 * Judgment sql FROM the grid, you can use INNER, LEFT, and so on
	 */
	public $fromSql				= '';
	/**
	 * Maximum number of pages to show in the query
	 */
	public $max_page             	= 0;
	/**
	 * Current page number of the page of the Grid
	 */
	public $actualPage           	= 0;
	/**
	 * Initial Order grid
	 */
	public $orderBy				= '';
	/**
	 * Determines whether the query is performed through a SQL query
	 */
	public $dataFromSQL				= true;
	/**
	 * Determines whether the query is performed through an array
	 */
	public $dataFromArray			= false;
	/**
	 * Array containing the data to be displayed in the grid
	 */
	public $dataArray				= array();
	/**
	 * Array containing the data displayed in the Grid, with filters
	*/
	public $dataArrayTmp				= array();
	/**
	 * Determines whether the query is performed through a Webservice
	*/
	public $webservice				= false;
	/**
	 * Url of the webservice that will return the data
	 */
	public $urlWebservice			= '';
	/**
	 * Array containing the data returned by the webservice
	 */
	public $dataWebservice			= array();
	/**
	 * Determines the maximum number of records to display in the grid
	 */
	public $limit                	= '';
	/**
	 * Contains the initial SQL and returns the number of records in the grid
	 */
	public $sqlCount             	= '';
	/**
	 * Numbers of total records query
	 */
	public $registerNumbers				= 0;
	/**
	 * Numbers of records in the query
	 */
	public $registerNumbersQuery		= 0;
	/**
	 * Number of results by default in the grid
	 */
	public $resultPage    				= 20;
	/**
	 * Defines whether distinct applied to the query
	 */
	public $distinct				= false;
	/**
	 * Name of the database query
	 */
	public $bdName				= '';	
	/**
	 * Path of the folder on the grid
	 */		 
	public $assetFolder		= '';
	/**
	 * Management Session variables
	 */
	protected $session			= '';
	/**
	 *
	 * Method constructor which initializes the grid with some parameters
	 *
	 * @ Param string $username // user name database
	 * @ Param string $password // User Password database connection
	 * @ Param string $host 	// Host where the database
	 * @ Param string $database // Name of the database in which the query is made
	 */
	public function __construct($username='', $password='', $host='localhost', $database='', $typeBd='mysql')
	{ 
		if($username !='' && $password !='' && $host !='' && $database !=''){ 
			$dsn			= $typeBd.":host=".$host.";dbname=".$database;
			$this->bd 		= new CDbConnection($dsn,$username,$password);
                        $this->bd->charset      = 'utf8';
		}else{ 
			$this->bd 		= Yii::app()->db;   // assuming you have configured a "db" connection
		}		
		Yii::import("application.modules.jqgrid.models.*");
		$this->assetFolder 	= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.jqgrid.lib.jqgrid'));
		$this->session	= new CHttpSession;
		$this->session->open();		
		$this->setGridOptions();
		$this->responce				= new stdClass();
		$this->responce->page 		= 0;
		$this->responce->total 		= $this->max_page;
		$this->responce->records 	= 0;
		$this->responce->userdata	= '';
		/**
		 * Folder Path of the Grid
		 */
		$this->pathGrid				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.jqgrid.lib')).'/';
		$this->pathImagesButtons	= $this->pathGrid."images/";		
		if(!isset($this->session['arrFieldType'])){
			/**
			 * Armo an array of field types the application and save in session
			 */
                    try{
                            $sql 					= "SELECT * FROM tbl_reports_field_type";
                            $command				= $this->bd->createCommand($sql);
                            $recordSet				= $command->query();
                            while(($rowRecordSet = $recordSet->read())!==false)
                            {			
                                    $_SESSION['arrFieldType']['field_type'][$rowRecordSet['field_type_id']] 	= $rowRecordSet['field_type'];				
                                    $_SESSION['arrFieldType']['searchtype'][$rowRecordSet['field_type_id']] 	= $rowRecordSet['searchtype'];
                                    $_SESSION['arrFieldType']['sopt'][$rowRecordSet['field_type_id']] 			= $rowRecordSet['comparisons'];				
                            }
                         } catch (Exception $ex) {
                                $error = 'Error en la ejecución de la base de datos';
                         }   
		} 
		require_once(Yii::getPathOfAlias('application.modules.jqgrid.lib.language').DIRECTORY_SEPARATOR.'lan-'.$this->language.'.php');
		$this->language_txt = $language;
		
		$this->textExportWindow = $this->language_txt['textExportWindow'];
		$this->textInputSearch 	= $this->language_txt['textInputSearch'];
	}
	/**
	 *
	 * This method initializes the global parameters of the Grid
	 *
	 * @author Jorge Arzuaga jorgearzuaga1@hotmail.com
	 *
	 * @ param string $name 			// Name of the Grid
	 * @ Param string $fromSql 			// From the query (may include inner relations, left, etc.),
	 * @ Param string $keyField 		// Id of the query field, used mostly for when you make changes to the Grid.
	 * @ Param string $ppalTable 		// Name of the parent table
	 * @ Param string $createFieldId 	// It can automatically create a first field from the main field
	 */
	function setGrid($name, $fromSql, $keyField, $ppalTable, $createFieldId = true)
	{		
		$this->name				= $name;
		/**
		 * Unique name is created Siun accents and the value gmmktime
		*/
		$this->uniqueName		= substr($name,0,2).gmmktime();
		$this->keyField			= $keyField;
		$this->ppalTable		= $ppalTable;
		$this->fromSql			= $fromSql;		
		$this->createFieldId	= $createFieldId;		
		/**
		 * Path page running the Crud of the Grid
		 */
		$this->pathIndex			= Yii::app()->request->baseUrl."/index.php";
		/**
		 * include the CSS and Js of jqGrid
		 */		
		Yii::app()->clientScript->registerCssFile( $this->assetFolder . '/css/ui.jqgrid.css' );		
		Yii::app()->clientScript->registerScriptFile( $this->assetFolder . '/js/i18n/grid.locale-'.$this->language.'.js' );
		Yii::app()->clientScript->registerScriptFile( $this->assetFolder . '/js/jquery.jqGrid.min.js' );
		Yii::app()->clientScript->registerScriptFile( $this->assetFolder . '/js/funcionesParticulares.js' );
	}
	/**
	 * Method to create the actions of the grid, such as buttons, links.
	 */
	function createActions()
	{
		/**
		 * If have actions
		 */
		if($this->haveAction)
		{
			$this->strGrid .=", gridComplete: function(asc){
											".$this->gridComplete."
											var ids = jQuery(table_id_".$this->name.").jqGrid('getDataIDs'); ";
			$strVarTemp2 	= '';
			$strVar			= '';
			foreach ($this->icons_url as $key => $url)
			{
				$this->strGrid  .= " var url".$key."=''; var urlClave".$key."='';";
				$strVarTemp2 .= " url".$key." =''; urlClave".$key." ='';";
			}
			$this->strGrid .=" 
									for(var i=0;i < ids.length;i++){
												/** Devuelve el id de las filas */
												var cl = ids[i];
												";
			
			
			foreach ($this->icons_url as $key => $url)
			{
				$strVars 			= '';
				$strVarsClaveValor 	= ''; 
				foreach ($this->icons_fields[$key] as $keys => $values)
				{  
					/**
					 * Extraidp el value para cada campo solicitado en icons_fields y lo almaceno
					 * en una variable JS
					 */
					$strVars .="  url".$key." += '".$keys."='+jQuery(table_id_".$this->name.").jqGrid ('getCell', cl, '".$values."')+'&';
			            								";
                                                                                                ;
					$strVarsClaveValor .="  urlClave".$key." = cl; ";
				}
				$this->strGrid .= $strVars.$strVarsClaveValor;
				$strVar  		.= "a".$key."+";
				$onclick 		 = '';
				/**
				 * $this->icons_action[$key] == 'DIALOG' open the dialog
				 */
				if (isset($this->icons_action[$key]) && strtoupper($this->icons_action[$key]) == 'DIALOG')
				{
					$options_dialog = "{width:100%, height:350}";				
					if($this->icons_action_options[$key] != ''){
						$options_dialog = str_replace("'", "\'", $this->icons_action_options[$key]);
					}
					$onclick = ' onclick=\"openDlgExportGrid(\'\',\''.$url.'&'.$this->varsUrl.'&"+url'.$key.'+"\',{'.$options_dialog.'})\"';					
				}
				elseif (isset($this->icons_action[$key]) &&  strtoupper($this->icons_action[$key]) == 'JS')
				{
					$onclick = ' onclick=\"'.$this->icons_action_js[$key].'(\'"+urlClave'.$key.'+"\',\''.$url.'&'.$this->varsUrl.'&"+url'.$key.'+"\')\"';
				}
				else
				{
					/**
					 * Set the URL where you execute the action
					 */
					$onclick = "href='".$url."&".$this->varsUrl."&\"+url".$key."+\"'";
				}
	
				/**
				 * If icons_img have any image
				 */
				$title 		= '';
				$titleAyuda	= '';
				if(isset($this->icons_title[$key])){
					$this->icons_title[$key] = str_replace("'", "", $this->icons_title[$key]);
					if($this->icons_title[$key] != ''){
						$title 		= $this->icons_title[$key];
						$titleAyuda = $this->icons_title[$key]."|".$this->icons_text[$key];
					}
				} 
				if(!isset($this->icons_target[$key])){
					$this->icons_target[$key] = '_self';
				}
				if(isset($this->icons_img[$key]) && $this->icons_img[$key] != '')
				{
					$this->strGrid .=" a".$key." = \"&nbsp;<a ".$onclick." style='cursor:pointer' target='".$this->icons_target[$key]."'><img title='".$title."' titleAyuda='".$titleAyuda."'  border='0' style='cursor:pointer' align='absmiddle' src='".$this->icons_img[$key]."' /></a>\";";
				}
				else if(isset($this->icons_title[$key]) && $this->icons_title[$key] != '')
				{
					/**
					 * If there are no images and if there titles, show the link
					 */
					$this->strGrid .=" a".$key." = \"&nbsp;<a ".$onclick." style='cursor:pointer' target='".$this->icons_target[$key]."' title='".$title."' titleAyuda='".$titleAyuda."' class='link'>".$this->icons_title[$key]."</a>&nbsp;\";";
				}
				
			}
			if($strVar != ''){
				$strVar = substr($strVar, 0,-1);
				$this->strGrid .="
									jQuery(table_id_".$this->name.").jqGrid('setRowData',ids[i],{grid_accion:".$strVar."}); ".$strVarTemp2."
									";
			}
			$this->strGrid .="
					}
				}";
		}
	}
	/**
	 * Create new buttons in the navigation bar the grid
	 *
	 * @param string $caption
	 * @param string $buttonIcon
	 * @param string $onClickButton
	 * @param string $iconId
	 * @param string $iconUrl
	 * @param string $title
	 */
	function createButton($caption, $buttonIcon, $onClickButton, $iconId = '', $iconUrl = '', $title = '', $url='')
	{
		$strmyGrid = '';
		if($onClickButton != '')
		{							
			if($this->options['toppager']){
				$strmyGrid .="
							jQuery(table_id_".$this->name.").navButtonAdd(toppager_id_".$this->name.",{
												   buttonicon:'".$buttonIcon."',
												   caption:'".$caption."',
												   title:'".$title."',
												   id:'".$this->uniqueName.$iconId."_top',								   
												   position:'last',
												   	onClickButton: function(){
												     ".$onClickButton."
												   },
												});";
				if($iconId != '' && $iconUrl != ''){
					$strmyGrid .=" $('#".$this->uniqueName.$iconId."_top').find('.ui-icon').css({'background-image':'url(\'".$iconUrl."\')', 'background-position':'0'}); ";
					$strmyGrid .=" $('#".$this->uniqueName.$iconId."_top').find('.ui-icon').addClass('openDlgExportGrid'); ";
					$strmyGrid .=" $('#".$this->uniqueName.$iconId."_top').find('.ui-icon').attr('url','".$url."'); ";
					$strmyGrid .=" $('#".$this->uniqueName.$iconId."_top').find('.ui-icon').attr('id','".$this->uniqueName.$iconId."_img'); ";
				}
			}
			$this->strButtons .= $strmyGrid;
		}
	}
	/**
	 * Create a button to export according to the type sent
	 * @param string $type
	 */
	function createButtonExport($type)
	{
		$url 			= $this->pathIndex."?r=jqgrid/Grid/export&tipo=".$type."&name=".$this->name;
		$onClickButton	= '';
		switch ($type)
		{
			case 'excelHtml':
				$image = 'excel.gif';
				break;
			case 'csv':
				$image = 'csv.png';
				break;
			case 'excel':
				$image = 'excel.gif';
				break;
			case 'txt':
				$image = 'plain.png';
				break;
			case 'word':
				$image = 'msword.gif';
				break;
			case 'pdf':
				$image = 'pdf.png';
				break;
		}
		$height	= 350;
		$width	= 550;
		$onClickButton = "openDlgExportGrid('#".$this->uniqueName.$type."_img', '".$url."', {'title':'".$this->textExportWindow."','autoOpen':false,'width':'".$width."','height':".$height.", resizable: false})";		
		$this->createButton('', '', $onClickButton, $type, $this->pathImagesButtons.$image,$this->textExportWindow, $url);
	}
	/**
	 * A method in which you create all the buttons on the grid
	 */
	function createButtons()
	{		
		/**
		 * Defines whether or not to display the icon to refresh the Grid
		 */
		if($this->iconReloadGrid)
		{
			$onClickButton 		= "$('#gridInputFind".$this->name."').val('');
	   							$('#Grid_".$this->name."').jqGrid('setGridParam', { search: false, postData: { \"filters\": \"\",gridInputFind:''} }).trigger(\"reloadGrid\");
	    						var grid = jQuery('#Grid_".$this->name."');
								grid[0].clearToolbar();
								$('#gridInputFind".$this->name."').val('".$this->textInputSearch."');
	    							";
			$this->createButton('', 'ui-icon-refresh', $onClickButton, '', '', $this->language_txt['button_reload']);
		}
		/**
		 * Clean filters on the grid, the grid recharging without any search criteria
		 */
		if($this->cleanFilters)
		{
			$onClickButton	 		 = "$('#gridInputFind".$this->name."').val('');
	   								$('#Filtros_".$this->name."').html('');
	   								$('#Grid_".$this->name."').jqGrid('setGridParam', { search: false, postData: { \"filters\": \"\",gridInputFind:''} }).trigger(\"reloadGrid\");
	    							var grid = jQuery('#Grid_".$this->name."');
									grid[0].clearToolbar();
									$('#gridInputFind".$this->name."').val('".$this->textInputSearch."');
	   								";
			$this->createButton('', '', $onClickButton, 'cleanFilters', $this->pathGrid."images/limpiar_filtros.png",$this->language_txt['button_remove_filters']);
		}
		/**
		 * Define export buttons
		 */
		/*if($this->exportExcelHtml){
			$this->createButtonExport('excelHtml');
		}*/
		if($this->exportExcel){
			$this->createButtonExport('excelHtml');
		}
		if($this->exportPdf){
			$this->createButtonExport('pdf');
		}
		if($this->exportWord){
			$this->createButtonExport('word');
		}
		if($this->exportTxt){
			$this->createButtonExport('txt');
		}
		if($this->exportCsv){
			$this->createButtonExport('csv');
		}
		/**
		 * Sets whether to display the icon to show / hide columns
		 */
		if($this->show_hide_columns)
		{
			$onClickButton 		= "show_hide_columns".$this->name."(table_id_".$this->name.")";
			$this->createButton('', '', $onClickButton, 'delete-column', $this->pathGrid."images/delete-column.png",$this->language_txt['button_hide_show_columns']);
		}
	}
	/**
	 * 
	 * This method registers all the Grid options in properties
	 * @author jarzuas
	 * 1/10/2013
	 *
	 * @param array $arrOptions
	 */
	public function setGridOptions ($arrOptions = array()){
		$this->options['rowNum'] 		= 12;
		$this->options['rowList'] 		= '10,12,20,30,50'; 
		$this->options['rownumbers'] 	= false;
		$this->options['hiddengrid'] 	= false;
		$this->options['footerrow']		= false;
		$this->options['multiSort']		= true;
		$this->options['height']		= '100%';
		$this->options['width']			= 'auto';
		$this->options['sortorder'] 	= 'asc';
		$this->options['sortname']		= $this->keyField;
		$this->options['toppager'] 		= false;	
		$this->options['caption'] 		= $this->name;	
		$this->options['toolbarfilter']	= true;
		$this->options['autowidth']		= true;
                $this->options['shrinkToFit']   = true;
					
		foreach ($arrOptions as $option => $value){
			$this->options[$option] = $value;
		}			
	}
	/**
	 * 
	 * This method makes certain options string grid that comes as bool
	 * @author jarzuas
	 * 6/11/2013
	 *
	 */
	public function setGridOptionsStr(){
		$this->options['rownumbers_str'] 	= $this->options['rownumbers'] == true ? 'true': 'false';
		$this->options['hiddengrid_str'] 	= $this->options['hiddengrid'] == true ? 'true': 'false';
		$this->options['footerrow_str'] 	= $this->options['footerrow'] == true ? 'true': 'false';
		$this->options['multiSort_str'] 	= $this->options['multiSort'] == true ? 'true': 'false';
		$this->options['toppager_str']		= $this->options['toppager'] == true ? 'true': 'false';		
		$this->options['autowidth_str']		= $this->options['autowidth'] == true ? 'true': 'false';		
		$this->options['shrinkToFit']		= $this->options['shrinkToFit'] == true ? 'true': 'false';		
	} 
	/**
	 * 
	 * This method sets the navigation options grid
	 * @author jarzuas
	 * 23/10/2013
	 *
	 * @param string $name
	 * @param array $arrOptions
	 *
	 */
	public function setNavOptions($name, $arrOptions = array()){
		$this->navOptionsName = $name;
		foreach ($arrOptions as $option => $value){
			$this->navOptions[$option] = $value;
		}
	}
	/**
	 * 
	 * This method establishes the properties of the columns of the grid
	 * @author jarzuas
	 * 23/10/2013
	 *
	 * @param string $columnName
	 * @param string $field
	 * @param string $alias
	 * @param string $table
	 * @param array $arrOptions
	 * @param string $isSQL
	 *
	 */
	public function setColProperty($columnName, $field, $alias, $table, $arrOptions=array(), $isSQL = true){
		if(($field != '' || $field != null) && $columnName != '' && $alias != '' && $table != ''){ 			
			$this->columnsOriginal['isSql'][] 	= $isSQL;
			$this->columnsOriginal['name'][] 	= $columnName;
			$this->columnsOriginal['field'][] 	= $field;
			$this->columnsOriginal['alias'][] 	= $alias;
			if($isSQL){
				$this->arrColAlias[]									= $alias;
				$this->arrSqlExport[$columnName] 						= $field." as ".$alias;
				$this->columnsOriginal['propertys'][$columnName]['export'] 	= true;
				$this->columnsOriginal['propertys'][$columnName]['table'] 	= $table;				
			}
			if(isset($arrOptions['hidden'])){
				if($arrOptions['hidden'] == '' || $arrOptions['hidden'] == null){
					$arrOptions['hidden'] = 'false';
				}
			}else{
				$arrOptions['hidden'] = 'false';
			}

			foreach ($arrOptions as $property => $value){
				$this->columnsOriginal['propertys'][$columnName][$property] = $value;
				if($property == 'hidden'){
					$this->columnsOriginal['hidden'][$columnName] 	= $value;
				}
			}
		}
	}	
	/**
	 * Export grid data to different formats, excel, pdf, txt, word
	 */
	function export(){
		if($_REQUEST['name'] != ""){
			$grid = unserialize($this->session["ObjGrid" . $_REQUEST['name']]);                        
                        $export = false;
                        if($_REQUEST['tipo'] == 'pdf' && $grid->exportPdf){
                            $export = true;
                        }elseif(($_REQUEST['tipo'] == 'excel' || $_REQUEST['tipo'] == 'excelHtml') && $grid->exportExcel){
                            $export = true;                        
                        }elseif($_REQUEST['tipo'] == 'pdf' && $grid->exportPdf){
                            $export = true;
                        }elseif($_REQUEST['tipo'] == 'word' && $grid->exportWord){
                            $export = true;
                        }elseif($_REQUEST['tipo'] == 'csv' && $grid->exportCsv){
                            $export = true;                        
                        }elseif($_REQUEST['tipo'] == 'txt' && $grid->exportTxt){
                            $export = true;
                        } 
                        if($export){                                                    
                                /**
                                 * I select only the columns that are visible and harmonized the sql with the same
                                 */
                                $columns = array();
                                if($_GET['columns']){
                                        $columns = explode("|", substr($_GET['columns'], 0, - 1));
                                }elseif($_POST['columns']){
                                        $columns = $_POST['columns'];
                                }
                                for($i = 0;$i < $grid->noCampos;$i ++){
                                        $grid->rowsExport[$i] = 'N';
                                }
                                $grid->arrSqlOrderExport = '';
                                if(count($grid->columns) > 0){
                                        foreach ($grid->columns['name'] as $key => $columName){
                                                $grid->rowsExport[$columName] = 'N';
                                        }
                                }
                                foreach($columns as $colName){
                                        if($grid->arrSqlExport[$colName] != ''){
                                                $grid->rowsExport[$colName] 	= 'Y';
                                                $grid->strSqlExport[] 			= $grid->arrSqlExport[$colName];
                                                $grid->arrSqlOrderExport[] 		= $colName;
                                                $grid->numRowsExport++;
                                        }
                                }
                                $grid->strSqlExport = implode(',', $grid->strSqlExport);
                                if($grid->orderBy != ''){
                                        $order_by = ' ORDER BY ' . $grid->orderBy;
                                }
                                /**
                                 * Establezco el where
                                 */
                                $grid->getWhere($grid->session["filtersSearch_".$grid->name]);                        
                                $where = $grid->where;               
                                if($where != ''){
                                  $where = ' WHERE '.$where;
                                }
                                if($grid->staticWhere != ''){
                                    if($where != ''){
                                        $where .= ' AND ';
                                    }else{
                                        $where = ' WHERE ';
                                    }
                                    $where .= $grid->staticWhere;
                                }
                                if($grid->options['caption'] == ''){
                                        $fileName = 'File Export';
                                }else{
                                        $fileName = $grid->options['caption'];
                                }

                                switch($_REQUEST['tipo']){
                                        /*case 'excel':
                                                include_once 'GridExcel.class.php';
                                                GridExcel::exportExcel($grid);
                                                $grid->createExportable("SELECT " . $grid->strSqlExport . " FROM " . $grid->fromSql . " " . $grid->where . $grid->groupby . $order_by);
                                                header("Content-Type: application/vnd.ms-excel");
                                                header('Content-Disposition: attachment; filename="' . $grid->options['caption'] . '.xls"');
                                                echo utf8_decode("<html>" . $grid->session['export' . $grid->name] . "</html>");
                                                $grid->session['export' . $grid->name] = '';
                                                break;*/
                                        case 'pdf':
                                                $grid->createExportable("SELECT " . $grid->strSqlExport . " FROM " . $grid->fromSql . " " . $where . $grid->groupby . $order_by);
                                                ini_set("memory_limit", "512M");
                                                
                                                $pdf = Yii::createComponent('application.extensions.mpdf.mpdf');                                                
                                                $format = 'A4';
                                                if($_GET['orientacion'] == 'L'){
                                                        $format .= '-L';
                                                }
                                                $mpdf = new mpdf('', $format, 0, '', 15, 15, 16, 16, 9, 9, $_GET['orientacion']);    
                                                /**
                                                 * Configuraciones particulares del PDF de acuerdo a la aplicación
                                                 */
                                                if(function_exists($grid->functionSetExportFilePdf)){
                                                        $return = call_user_func($grid->functionSetExportFilePdf, $mpdf, $grid);
                                                        $grid->export = $return . $grid->export;
                                                }
                                                $mpdf->use_embeddedfonts_1252 = true; // false is default
                                                $mpdf->setAutoTopMargin = 'stretch';
                                                if($grid->pathImgPdf != ''){
                                                        $mpdf->SetHTMLHeader("<img src='" . $grid->pathImgPdf . "' />");
                                                }
                                                $grid->export = iconv("UTF-8","UTF-8//IGNORE",$grid->export);                                                
                                                
                                                $mpdf->WriteHTML($grid->export);
                                                $mpdf->Output($fileName . '.pdf', 'D');
                                                exit;
                                                break;
                                        case 'excelHtml':
                                                $grid->createExportable("SELECT " . $grid->strSqlExport . " FROM " . $grid->fromSql . " " . $where . $grid->groupby . $order_by);
                                                header("Content-Type: application/vnd.ms-excel");					
                                                header('Content-Disposition: attachment; filename="' . $fileName . '.xls"');
                                                echo "<html>";
                                                /**
                                                 * Configuraciones particulares del Excel de acuerdo a la aplicación
                                                 */
                                                if(function_exists($grid->functionSetExportFileExcelHtml)){
                                                        $return = call_user_func($grid->functionSetExportFileExcelHtml);
                                                        $grid->export = $return . $grid->export;
                                                }
                                                echo utf8_decode($grid->export);
                                                echo "</html>";
                                                exit;
                                                break;
                                        case 'word':
                                                $grid->createExportable("SELECT " . $grid->strSqlExport . " FROM " . $grid->fromSql . " " . $where . $grid->groupby . $order_by);
                                                header("Content-Type: application/vnd.ms-mord");
                                                header('Content-Disposition: attachment; filename="' . $fileName . '.doc"');
                                                echo utf8_decode("<html>" . $grid->export . "</html>");
                                                break;
                                        case 'csv':
                                                $grid->export_options['caption'] = false;
                                                $grid->createExportable("SELECT " . $grid->strSqlExport . " FROM " . $grid->fromSql . " " . $where . $grid->groupby . $order_by);
                                                header("Content-Type: application/csv");
                                                header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
                                                echo utf8_decode($grid->exportContentTxt);
                                                exit;
                                                break;
                                        case 'txt':
                                                $grid->createExportable("SELECT " . $grid->strSqlExport . " FROM " . $grid->fromSql . " " . $where . $grid->groupby . $order_by);
                                                header("Content-Type: application/txt");
                                                header('Content-Disposition: attachment; filename="' . $fileName . '.txt"');
                                                echo utf8_decode($grid->exportContentTxt);
                                                exit;
                                                break;
                                }
                        }else{
                            return false;
                        }
		}
	}
	/**
	 * Method to recharge the Grid
	 */
	function reload(){
		if($_REQUEST['name'] != ""){
			$grid 		= unserialize($this->session["ObjGrid" . $_REQUEST['name']]);
			$filters 	= '';
                        $grid->session["filtersSearch_".$grid->name] = '';
			if(isset($_REQUEST['filters'])){
				$filters 	= json_decode(str_replace('\"', '"', $_REQUEST['filters']));
                                $grid->session["filtersSearch_".$grid->name] = $filters;
			}
			$grid->gridInputFind = '';
			if(isset($_REQUEST['gridInputFind']) && $_REQUEST['gridInputFind'] != '' && $_REQUEST['gridInputFind'] != $grid->textInputSearch){
				/**
				 * If this parameter is sent, it searches all fields of the grid with OR
				 */
				$grid->where = '';
				
				$grid->gridInputFind = $_REQUEST['gridInputFind'];
				$grid->standOutFind = true;
				foreach ($grid->columns['name'] as $key => $columName){
					$field	= $grid->columns['field'][$key];				
					if($field != '' && $_REQUEST['gridInputFind'] != '' && $field != "''"){
						$whereTmp .= $field . " LIKE '%" . mysql_escape_string($_REQUEST['gridInputFind']) . "%' OR ";
					}
				}
				$whereTmp = substr($whereTmp, 0, - 4);
				$grid->where .= " (" . $whereTmp . ") ";
			}else{
				/* if($this->multipleGroup == 'false'){ */
				$grid->getWhere($filters);
				/*
				 * }else{ $grid->getWhereGroup($filters); }
				 */
			}
			if($grid->isSubGrid){
				foreach($grid->paramSubGrid as $key => $campo){
					$staticWhere .= $campo . ' = ' . mysql_escape_string($_REQUEST['id']) . " AND ";
				}
				if($staticWhere != ''){
					$staticWhere = substr($staticWhere, 0, - 4);
				}
				$grid->staticWhere = $staticWhere;
			}
			$grid->createData();
			echo json_encode($grid->responce);
		}
	}
	/**
	 * This method will arm the order by according to the title of each column is for informational purposes only user
	 *
	 * @param string $ordenarBy
	 * @return string
	 */
	function showOrderBy($ordenarBy){
		$newOrderBy = '';
		$arrOrder	= array();
		if($ordenarBy != ''){
			$arrOrder  	= explode(', ',trim($ordenarBy));
			foreach ($arrOrder as $value) {
				list($campoOrder,$order) = explode(' ', $value);
				/**
				 * If the field contains the table, the separated just to get the name of the field
				*/
				$campoOrder = explode('.', $campoOrder);
				if($campoOrder[1] != ''){
					$campoOrder = $campoOrder[1];
				}else{
					$campoOrder = $campoOrder[0];
				}
				$newOrderBy .= trim($campoOrder)." ".strtoupper(trim($order)).", ";
			}
			if($newOrderBy != ''){
				$newOrderBy = substr($newOrderBy, 0,-2);
			}
				
			if(trim($newOrderBy) == '' && $this->sidx != ''){
				$newOrderBy  .= $this->arrColAlias[$this->sidx]." ".strtoupper($this->sord);
			}
		}
		return $newOrderBy;
	}
	/**
	 * Method to create the count of consultation and find out how many records returned
	 *
	 * @param string $distinct
	 */
	function getSQLCount($distinct=''){
		/**
		 * We establish where the Grid
		 */
		$where_tmp = '';
		if ($this->staticWhere != '')
			$where_tmp = $this->staticWhere;
		 
		if ($this->where != '')
		{
			if($where_tmp != '')
				$where_tmp .= ' AND ';
		  
			$where_tmp .= $this->where;
		}
		if ($where_tmp != "")
		{
			$this->where = str_replace("WHERE","",$where_tmp);
			$this->where = " WHERE ".$where_tmp;
		}
		/**
		 * Set the query to run count (campo_id) to determine the number of records
		 * The Grid
		 */
		$this->sqlCount				= "SELECT ".$distinct." Count(*) as noregs
									   	FROM
									   	".$this->fromSql."
									   	".$this->where."
									   	".$this->groupby;
	}
	/**
	 * This method is located creates the SQL statement that is executed to bring the data to be displayed in the Grid
	 *
	 * @param string $order_by
	 * @param string $distinct
	 * @param string $limit
	 */
	function getSQL($orderBy='', $distinct='',$limit=''){
		$this->sql 	= "SELECT ".$distinct." ".implode(', ', $this->selectSql)."
					   	FROM ".$this->fromSql."
					   	".$this->where."
					   	".$this->groupby."
					   	".$orderBy."
					   	LIMIT ".$limit;
	}
	/**
	 * This method searches the given array according to overall grid filter
	 * @param string $value
	 */
	public function filterArray($value){
		$pos	= strripos($value, $this->gridInputFind);
		if ($pos === false) {
			return false;
		}else{
			return true;
		}
	}
	/**
	 * Method for painting and return data in JSON format
	 */
	function createData()
	{ 	
		/**
		 * Recibo la página actual enviada por la jqGrid
		 */
		$this->actualPage 	= $_REQUEST['page'];
		$error				= false;
		/**
		 * Recibo el número de registros a mostrar en la página
		 */
		if($_REQUEST['rows'] > 0){
			$this->resultPage = $_REQUEST['rows'];
		}
		$_REQUEST['sidx'] = trim($_REQUEST['sidx']);
		$_REQUEST['sord'] = trim($_REQUEST['sord']);
		if($_REQUEST['sidx'] != 'grid_accion'){
			if($_REQUEST['order_by'] != '')
			{
				$this->orderBy = $_REQUEST['order_by'];
			}
			elseif($_REQUEST['sidx'] != '' && $_REQUEST['sord'] != '')
			{
				if(substr(trim($_REQUEST['sidx']), -1) == ','){
					$_REQUEST['sidx'] = substr(trim($_REQUEST['sidx']), 0,-1);
				}
				if(in_array(substr(trim($_REQUEST['sidx']),-4), array(' asc','desc'))){
					$this->orderBy 	= $_REQUEST['sidx'];
				}else{
					$this->orderBy 	= $_REQUEST['sidx'].' '.$_REQUEST['sord'];
				}
				$this->sidx 	= $_REQUEST['sidx'];
				$this->sord 	= $_REQUEST['sord'];				
			}
		}
		if(!isset($_SESSION["ObjGrid".$this->name."reloadNumber"])){
			$_SESSION["ObjGrid".$this->name."reloadNumber"] = 0;
		}
		$_SESSION["ObjGrid".$this->name."reloadNumber"]++;
		$this->reloadNumber = $this->session["ObjGrid".$this->name."reloadNumber"];
		$distinct = '';
		if($this->distinct){
			$distinct = ' DISTINCT ';
		}
		if(trim($this->orderBy) != ''){
			$this->orderBy = ' ORDER BY '.$this->orderBy;
		}
		/**
		 * Aplicar filtros a la data si es de un array
		 *
		 */
		$this->dataArrayTmp = array();
		if($this->gridInputFind != '' && $this->dataFromArray){
			foreach ($this->dataArray as $arrTmp){
				if(count(array_filter($arrTmp, array($this,'filterArray'))) > 0){
					$this->dataArrayTmp[] = $arrTmp;
				}
			}
		}elseif($this->gridInputFind == '' && $this->dataFromArray){
			$this->dataArrayTmp = $this->dataArray;
		}
		
		if($this->dataFromSQL){
			$this->getSQLCount($distinct); 
                        try{ //echo $this->sqlCount;
                                $command		= $this->bd->createCommand($this->sqlCount);
                                $recordSet 		= $command->query();
                                $rowRecordSet	= $recordSet->read();
                                if($this->groupby != ''){
                                        $this->registerNumbers	= count($rowRecordSet);
                                }else{
                                        $this->registerNumbers	= $rowRecordSet['noregs'];
                                }
                           } catch (Exception $ex) {
                                $error = 'Error en la ejecución de la base de datos';
                                if(defined('YII_DEBUG')){
                                        if(YII_DEBUG){
                                            $error .="<br>".$ex->getMessage();
                           }     
                                    }
                           }     
		}elseif($this->dataFromArray){
			$this->registerNumbers = count($this->dataArrayTmp);
		}elseif($this->webservice){
			/**
			 * Instancio el objeto para consumir el webservice
			 */
			$objWebservice	= new Webservice();
			$objWebservice->conectarCliente($this->urlWebservice);
			if($objWebservice->errores == '')
			{
				try
				{
					$response 			= $objWebservice->cliente->getTotalData($this->where, $this->groupby, $this->orderBy, $strUsuario, $strPassword);
					$this->registerNumbers = $response[0];
					$error 				= $response[1];
				}
				catch (Exception $exception)
				{
					$error = $exception->getMessage();
				}
			}
		} 
		if($this->registerNumbers > 0)
		{
			$this->max_page 	 	= ceil($this->registerNumbers / $this->resultPage);
			//$this->responce->rows 	= array();
			/**
			 * Determino el limit, y número de la página a mostrar
			 */
			if (!((int) $this->actualPage) > 0 or $this->registerNumbers == 0){
				$this->actualPage = 1;
			}elseif ($this->actualPage > $this->max_page){
				$this->actualPage = $this->max_page;
			}
			$intPosInicial 	= ($this->actualPage - 1)*$this->resultPage;
	
			/**
			 * Envio variables requeridas por la jqGrid
			 */
			$this->responce->page 						= $this->actualPage;
			$this->responce->total 						= $this->max_page;
			$this->responce->records 					= $this->registerNumbers;
			$this->responce->userdata['order'] 			= $this->showOrderBy($this->orderBy);
			$this->responce->userdata['reloadNumber'] 	= $this->reloadNumber;
			if($this->limit == ''){
				$limit = $intPosInicial.", ".$this->resultPage;
			}else{
				$this->max_page 	 		= ceil($this->limit / $this->resultPage);
				$intPosInicial 				= ($this->actualPage - 1)*$this->resultPage;
				if(($this->limit-$intPosInicial) < $this->resultPage){
					$this->resultPage = $this->limit-$intPosInicial;
				}
				$limit 						= $intPosInicial.", ".$this->resultPage;
				$this->responce->page 		= $this->actualPage;
				$this->responce->total 		= $this->max_page;
				$this->responce->records 	= $this->limit;
			}
			/**
			 * Obtengo miSql de la consulta
			 */
			if($this->dataFromSQL){
				$this->getSQL($this->orderBy, $distinct, $limit);
				/**
				 * Ejecuto el SQL de todos los campos de la Grid
				*/
				//echo $this->sql;EXIT;
                                try{
                                    $command					= $this->bd->createCommand($this->sql);
                                    $recordSet 					= $command->query();
                                    $rowRecordSetArray			= $recordSet->readAll();
                                    $this->registerNumbersConsulta = count($rowRecordSetArray);
                                } catch (Exception $ex) {
                                    $error = 'Error en la ejecución de la base de datos';
                                    if(defined('YII_DEBUG')){
                                        if(YII_DEBUG){
                                            $error .="<br>".$ex->getMessage();
                                        }
                                    }
                                }
			}elseif($this->dataFromArray){
				/**
				 * Extraigo los registros para la paginación
				 */
                           
				$dataArray	= array_slice($this->dataArrayTmp, $intPosInicial, $this->resultPage);                                 
				$this->registerNumbersConsulta = count($dataArray);
			}elseif($this->webservice){
				/**
				 * Obtengo los datos del Webservice
				 */
				if($objWebservice->errores == '')
				{
					try
					{
						$response 					= $objWebservice->cliente->getData($this->where, $this->groupby, $order_by, $limit, $strUsuario, $strPassword);
						$this->dataWebservice		= $response[0];
						$this->registerNumbersConsulta = count($this->dataWebservice);
						$this->registerNumbers 		= $response[1];
						$error 						= $response[2];
					}
					catch (Exception $exception)
					{
						$error = $exception->getMessage();
					}
				}
			}
			/**
			 * Errores en la consulta
			 */
			if(defined('YII_DEBUG')){
                            if(YII_DEBUG){
				$this->responce->sql 		= $this->sql;
                            }
                        }
			/**
			 * Totalizar Campos
			 */
			$fieldsTotal	= array();
			$j 				= 0;
			/**
			 * Paso los datos a la variable $this->responce->rows que contendra el JSON
			 */
			if(1==1)
			{ 
				$index		= 0;
				for($j=0; $j<$this->registerNumbersConsulta; $j++)
				{
					if($this->dataFromSQL){
						$rowRecordSet 	= $rowRecordSetArray[$index];
					}elseif($this->dataFromArray){
						$rowRecordSet 	= $dataArray[$index];
					}elseif($this->webservice){
						$rowRecordSet 	= $this->dataWebservice[$j];
					}
		
					$arrayDatos		= '';
					/**
					* Si hay edición ó adición de registros el id es el mismo keyField
					*/
					//if($this->add != 'false' || $this->edit != 'false' || $this->del != 'false'){
						$this->responce->rows[$j]['id']	= $rowRecordSet[$this->keyField];
				//	}else{
					//		$this->responce->rows[$j]['id']	= $j;
					//}		
					foreach ($this->columns['name'] as $key => $name){
						$alias 		= $this->columns['alias'][$key];
						$fieldValue = '';
						if(isset($rowRecordSet[$alias])){												
							$fieldValue = $rowRecordSet[$alias];
						}
						$fieldValue = limpiar_tags($fieldValue);                                                
						
						if(isset($this->columns['propertys'][$name]['total']) && $this->columns['propertys'][$name]['total'] || 
							(isset($this->columns['propertys'][$name]['avg']) && $this->columns['propertys'][$name]['avg']))
						{
							$fieldsTotal[$j]+= $fieldValue;
						}
						if($this->standOutFind)
						{
							$standOutFind = true;
							if($this->haveAction && $j == 0){
								$standOutFind = false;
							}
							if($standOutFind){
								$fieldValue = regularExpressions($fieldValue, $this->gridInputFind,'','nada');
							}
						}
						if(isset($this->columns['propertys'][$name]['regularExpression']) && $this->columns['propertys'][$name]['regularExpression'] && 
						   isset($this->columns['propertys'][$name]['regularExpressionType']) && $this->columns['propertys'][$name]['regularExpressionType'] != '')
						{
							if($this->columns['propertys'][$name]['regularExpression'])
							{
								/**
								* Por defecto filters se llena en la busqueda, pero se puede enviar el tipo de filtro
								*/
								$expreg = $this->filters[$alias];
							}
							$strUrlTmp 				= '';
							$urlActionDimWindow	= '';
							if(isset($this->urlActionFieldParam[$alias])){
								foreach ($this->urlActionFieldParam[$alias] as $campoGet => $valueTmp){
									$strUrlTmp .= "&".$campoGet."=".$rowRecordSet[$valueTmp];
									}
							}else{
								foreach ($this->urlActionCampo as $campoGet => $valueTmp){
										$strUrlTmp .= "&".$campoGet."=".$rowRecordSet[$valueTmp];
								}
							}
							if($this->urlActionDefault != ''){
								$strUrlTmp = $this->urlActionDefault.$strUrlTmp;
							}else{
								$strUrlTmp = $this->urlActionFieldLink[$alias].$strUrlTmp;
								$urlActionDimWindow = $this->urlActionDimWindow[$alias];
							}
							if($this->columns['propertys'][$name]['regularExpressionType'] == ''){
								$this->columns['propertys'][$name]['regularExpressionType'] = 'resaltar';
							}
							$arrayDatos[] = regularExpressions($fieldValue, $expreg, $strUrlTmp, $this->columns['propertys'][$name]['regularExpressionType'],$urlActionDimWindow, $this->columns['propertys'][$name]['regularExpressionTarget']);
						}elseif (isset($this->columns['propertys'][$name]['function']) && $this->columns['propertys'][$name]['function'] != ''){
							/**
							* Armo los parametros a pasar a la función y realizo el llamado de la misma
							*/
							$arrParam = array();
							foreach ($this->columns['propertys'][$name]['functionParameters'] as $fieldParam) {
								$arrParam[] = $rowRecordSet[$fieldParam];
							}							
							include_once( Yii::getPathOfAlias($this->columns['propertys'][$name]['pathFunction']).'.php' );
							$arrayDatos[] = call_user_func_array(''.$this->columns['propertys'][$name]['function'].'' , $arrParam);
						}elseif (isset($this->columns['propertys'][$name]['fieldType']) && $this->columns['propertys'][$name]['fieldType'] == 'observations'){
                                                    	$arrayDatos[] = '<a class="obs'.$alias.$j.' link" onclick="verObs(\'obs'.$alias.$j.'\',\'divToolTip'.$this->name.'\',\'\')"  titleObs="'.str_replace('"', '', $fieldValue).'"><span>Ver</span></a>';
						}elseif (isset($this->columns['propertys'][$name]['fieldType']) && $this->columns['propertys'][$name]['fieldType'] == 'password'){
							$arrayDatos[] = '**********';
						}elseif (isset($this->columns['propertys'][$name]['fieldType']) && $this->columns['propertys'][$name]['fieldType'] == 'checkbox'){
							if($this->checkbox_image){
									if ($fieldValue == 1){
				   						$arrayDatos[] = '<img src="'.$this->pathGrid.'images/checkbox_si.png" height="18" width="18"/>';
									}elseif ($fieldValue == 0){
										$arrayDatos[] = '<img src="'.$this->pathGrid.'images/checkbox_no.png" height="18" width="18"/>';
									}
							}else{
                                                                //$arrayDatos[] = $fieldValue;
								if ($fieldValue == 1){
									$arrayDatos[] = strtoupper($this->language_txt['text_yes']);
								}elseif ($fieldValue == 0){
									$arrayDatos[] = strtoupper($this->language_txt['text_no']);
                                                                }
							}
						}elseif (isset($this->columns['propertys'][$name]['fieldType']) && $this->columns['propertys'][$name]['fieldType'] == 'percentaje'){
		   						$arrayDatos[] = $fieldValue."%";
						}else{
								$arrayDatos[] = htmlspecialchars_decode($fieldValue);
		   				}
	   				}
	   				$this->responce->rows[$j]['cell'] = $arrayDatos;
		   			$index++;
				}
			}
								/**
								* Creo las variables totales del JSON
								*/
				if($this->showFieldTotal){
							foreach ($fieldsTotal as $key => $totalValor)
							{
				   				if($this->campos[$key]->total)
				   					$this->responce->userdata[$this->campos[$key]->alias] = $totalValor;
								else if($this->campos[$key]->avg)
									$this->responce->userdata[$this->campos[$key]->alias] = $totalValor/$this->registerNumbers;
							}				
				}
		}else{
				$this->responce->userdata['reloadNumber'] = $this->reloadNumber;
				$this->responce->page 		= 0;
				$this->responce->total 		= 0;
				$this->responce->records 	= 0;
				$this->responce->rows		= array();
			if($error != ''){
				$this->responce->error .= $error;
			}
			if(defined('YII_DEBUG')){
                            if(YII_DEBUG){
				$this->responce->sql 		= $this->sqlCount;
                            }
			}
		}
	}
	/**
	 * This method returns me where my grid
	 * 
	 * @author Jorge Arzuaga jorgearzuaga1@hotmail.com
	 * 8/04/2013
	 *        
	 * @param array $filters        	
	 */
	function getWhere($filters){
		$this->where = ''; 
		if($filters){
			/**
			 * Decodifico los filtros devuelto por la jqGrid
			 */
			$groupOp = ' ' . $filters->groupOp . ' ';
			
			foreach($filters->rules as $key => $value){ 
				$field = $filters->rules[$key]->field;				
				$table = $this->columns['propertys'][$field]['table'];
				$fieldType = $this->columns['propertys'][$field]['fieldType'];
				$field_find = $this->columns['propertys'][$field]['field_find'];
				$field_in	= $table.'.'.$field;
				if($field_find != ''){
					$field_in = $field_find;
				}
				/**
				 * Translate options where
				 */
				$op = strtr($filters->rules[$key]->op, $this->traduceOpWhere);				
				$this->where .= $this->rulesWhere($op,$field_in , $filters->rules[$key]->data, $groupOp);
				$this->filters[$field] = $filters->rules[$key]->data;
			}
			$this->where = substr($this->where, 0, - 4);
		}
	}	
	/**
	 *
	 *
	 * This method translates the grid where sent by a sql where
	 * 
	 * @author Jorge Arzuaga <jorgearzuaga1@hotmail.com>
	 *        
	 * @param string $op        	
	 * @param string $field        	
	 * @param string $data        	
	 * @param string $groupOp        	
	 * @return string
	 */
	function rulesWhere($op, $field, $data, $groupOp){
                $data = mysql_escape_string($data);
		switch($op){
			case 'bw': //
				$where = $field . " LIKE '" . $data . "%'" . $groupOp;
				break;
			case 'bn':
				$where = $field . " NOT LIKE '" . $data . "%'" . $groupOp;
				break;
			case 'ni':
				/**
				 * Deben venir los datos separados por comas (,)
				 */
				$data = explode(',', $data);
				$data = implode("','", $data);
				if($data != ''){
					$where = $field . " NOT IN ('" . $data . "')" . $groupOp;
				}
				break;
			case 'in':
				/**
				 * Deben venir los datos separados por comas (,)
				 */
				$data = explode(',', $data);
				$data = implode("','", $data);
				if($data != ''){
					$where = $field . " IN ('" . $data . "')" . $groupOp;
				}
				break;
			case 'ew':
				$where = $field . " LIKE '%" . $data . "'" . $groupOp;
				break;
			case 'en':
				$where = $field . " NOT LIKE '%" . $data . "'" . $groupOp;
				break;
			case 'cn':
				$where = $field . " LIKE '%" . $data . "%'" . $groupOp;
				break;
			case 'nc':
				$where = $field . " NOT LIKE '%" . $data . "%'" . $groupOp;
				break;
			case 'nn':
				$where = "(" . $field . " IS NOT NULL OR " . $field . " != '') " . $groupOp;
				break;
			case 'isn':
				$where = "(" . $field . " IS NULL OR " . $field . " = '')" . $groupOp;
				break;
			default:
				if($op == '='){
					$comillas = "'";
				}
				$where = $field . " " . $op . " " . $comillas . $data . $comillas . $groupOp;
				break;
		}
		return $where;
	}
	/**
	 * Create the file to export the grid (Excel, PDF, Word, plain text)
	 * 
	 * @param string $sql        	
	 */
	function createExportable($sql){
		ini_set("memory_limit", "100M");
		if($this->dataFromSQL){
                        try{
                            $command = $this->bd->createCommand($sql);
                            $recordSet = $command->query();
                            $dataArray = $recordSet->readAll();
                            $registerNumbersQuery = count($dataArray);
                           } catch (Exception $ex) {
                             $error = 'Error en la ejecución de la base de datos';
                           } 
		}elseif($this->dataFromArray){
			$registerNumbersQuery = count($this->dataArrayTmp);
			$dataArray = $this->dataArrayTmp;
		}
		$this->exportContentTxt = '';
		$this->export = '';
		if($this->exportTitle){
			$this->export = '<table border="1" cellspacing="0" cellpadding="0" witdh="100%">';
			if($this->options['caption'] != ''){
				$this->export .= '<tr>
										<td bgcolor="#F5F5F5" colspan="' . ($this->numRowsExport + 1) . '" align="center" ><strong>' . $this->titulo . '<strong></td>
									</tr>';
			}
			$this->export .= '<tr><td width="5%" bgcolor="#F5F5F5" align="center" ><strong>'.$this->language_txt['text_no_registers'].'<strong></td>';
			foreach($this->arrSqlOrderExport as $columName){
				if($this->columns['propertys'][$columName]['fieldType'] != 'imagen' && $this->rowsExport[$columName] == 'Y'){
					$label = $this->columns['propertys'][$columName]['label'];
					$this->export .= '<th width="' . $this->columns['propertys'][$columName]['width'] . '%" class="noRegs" align="center" valign="middle">' . $label . '</td>';
					$this->exportContentTxt .= $label . $this->filesSeparator;
				}
			}
			$this->export .= '</tr>';
			$this->exportContentTxt .= "\r\n";
		}
		$j = 0;
		$m = 1;
		$index = 0;
		// Construimos los detalles de la tabla
		for($j = 0;$j < $registerNumbersQuery; $j ++){
			$rowRecordSet = $dataArray[$index];
			set_time_limit(100);
			$this->export .= '<tr>
						<td bgcolor="#F5F5F5" align="center">' . $m . '</td>';
			foreach($this->arrSqlOrderExport as $columName){
				$fieldType = $this->columns['propertys'][$columName]['fieldType'];
				if($fieldType != 'imagen' && $this->rowsExport[$columName] == 'Y'){
                                        $fieldValue = limpiar_tags($rowRecordSet[$columName]);
					if($fieldValue == '')
						$fieldValue = '&nbsp;';
					
					if($fieldType == 'checkbox'){						
						if ($fieldValue == 1){
							$fieldValue = strtoupper($this->language_txt['text_yes']);
						}elseif ($fieldValue == 0){
							$fieldValue = strtoupper($this->language_txt['text_no']);
						}
					}elseif(isset($this->columns['propertys'][$columName]['function'])){
						/**
						 * Armo los parametros a pasar a la función y realizo el llamado de la misma
						 */
						$arrParam = array();
						foreach($this->columns['propertys'][$columName]['functionParameters'] as $fieldParam){
							$arrParam[] = $rowRecordSet[$fieldParam];
						}
                                                include_once( Yii::getPathOfAlias($this->columns['propertys'][$name]['pathFunction']).'.php' );
						$fieldValue = call_user_func_array($this->columns['propertys'][$columName]['function'], $arrParam);
					}elseif($fieldType == 'currency'){
						$fieldValue = numberFormat($fieldValue, '$ ', 2);
					}elseif($fieldType == 'password'){
                                            $fieldValue = '**********';
					}elseif($fieldType == 'currency_no_decimals'){
						$fieldValue = numberFormat($fieldValue, '$ ', 0);
					}elseif($fieldType == 'percentaje'){
						$fieldValue = $fieldValue . "%";
					}
					$this->export .= '<td align="' . $this->columns['propertys'][$columName]['align'] . '">' . $fieldValue . '</td>';
					/**
					 * Solo para exportar archivos planos
					 */
					$fieldValue = html_entity_decode($fieldValue, ENT_QUOTES | ENT_IGNORE, "UTF-8");					
					$arrReplace = array(
							"\n",
							"\r",
							"\r\n",
							"*",
							"&nbsp;" 
					);
					$fieldValue = str_replace($arrReplace, " ", trim($fieldValue));
					/**
					 * tipo puede ser todo o tilde, o simbolos
					 */
					$fieldValue = replaceEntity($fieldValue);
					
					$this->exportContentTxt .= $fieldValue . $this->filesSeparator;
				}
			}
			
			$index ++;
			$this->export .= '</tr>';
			$this->exportContentTxt .= "\r\n";
			$m ++;
		}
		if($this->gran_totalesStr != ""){
			$this->export .= $this->gran_totalesStr;
		}
		$this->export .= '</table>';
		//$this->session["export" . $this->name] = $this->export;
	}
	/**
	 * 
	 * This method creates the grid and returns the object
	 * @author jarzuas
	 * 22/10/2013
	 *
	 * @param bool $edit
	 * @param bool $add
	 * @param bool $del
	 * @param bool $search
	 * @param bool $view
	 * @return string
	 *
	 */
	public function renderGrid($edit = null, $add = null, $del = null, $search = true, $view = true)
	{	
		$this->edit		= $edit;
		$this->add		= $add;
		$this->del		= $del;
		$this->search	= $search;
		$this->view		= $view;
		
		if($this->hasSubGrid){
			Yii::app()->clientScript->registerScriptFile( $this->assetFolder . '/src/grid.subgrid.js' );
		}
		/**
		 * It creates the first field of the grid taking the $tabla_ppal campo_id and by default not shown
		 *
		 */ 
		$this->setGridOptionsStr();
		if($this->haveAction)
		{ 
			$this->setColProperty('grid_accion', 'grid_accion', 'grid_accion', 'grid_accion', array('label'=>$this->title_action,'width'=>$this->widthAction.'px',  'align'=>'center', 'search'=>'false', 'export' => false), false);
		}
		if($this->createFieldId)
		{
			$this->setColProperty($this->keyField, $this->ppalTable.".".$this->keyField, $this->keyField, $this->ppalTable, array('label'=>$this->keyField,'width'=>'1px', 'hidden'=>'true', 'search'=>'false'), true);
		}
		/**
		 * Reorder the columns to make that visible first, this bug that s epresenta when there are hidden columns
		 * filtertoolbar
		 */
		$columnsVisible 		= array();
		$columnsHidden 			= array();
		foreach ($this->columnsOriginal['name'] as $key => $columnName){		
			if($this->columnsOriginal['hidden'][$columnName] == 'false'){
				$columnsVisible['isSql'][] 					= $this->columnsOriginal['isSql'][$key];
				$columnsVisible['name'][] 					= $columnName;
				$columnsVisible['field'][] 					= $this->columnsOriginal['field'][$key];
				$columnsVisible['alias'][] 					= $this->columnsOriginal['alias'][$key];
				$columnsVisible['propertys'][$columnName] 	= $this->columnsOriginal['propertys'][$columnName];
				$this->numberColumnsVisibles++;
			}else{
				$columnsHidden['isSql'][] 					= $this->columnsOriginal['isSql'][$key];
				$columnsHidden['name'][] 					= $columnName;
				$columnsHidden['field'][] 					= $this->columnsOriginal['field'][$key];
				$columnsHidden['alias'][] 					= $this->columnsOriginal['alias'][$key];
				$columnsHidden['propertys'][$columnName] 	= $this->columnsOriginal['propertys'][$columnName];
			}
		} 
		$this->columns = array_merge_recursive($columnsVisible, $columnsHidden);
		
		$arrColumnsQuotePropertys = array('edittype', 'searchtype', 'align', 'width', 'stype', 'formatter', 'summaryType', 'summaryTpl');
		$arrSelfPropertys         = array('mostrar', 'fieldType', 'total', 'avg', 'regularExpressionType', 'regularExpression', 'pathFunction',
						'regularExpressionTarget', 'function', 'functionParameters', 'export', 'selectSql', 'table', 'field_find');
		$colLabels = array();
		$colModels = array();
		/**
		 * Armo the columns and their models
		 */
		$this->strGrid = "";
		foreach ($this->columns['name'] as $key => $columName){
			$alias			= $this->columns['alias'][$key];
			$field			= $this->columns['field'][$key]; 
			$arrColAlias[] 		= "'".$alias."':'".$columName."'";
			if($this->columns['isSql'][$key]){
				$this->selectSql[] 	= htmlspecialchars_decode($field)." as ".$alias;
			}
			foreach ($this->columns['propertys'][$columName] as $property => $value){
				if($property == 'label'){
					$colLabels[] = "'".$value."'";
				}elseif(!in_array($property, $arrSelfPropertys)){
					if(in_array($property, $arrColumnsQuotePropertys) && $this->arrNoColumnsQuotePropertys[$columName] != $property){
						$arrColModels[] = $property.":'".$value."'";
					}else{
						$arrColModels[] = $property.":".$value."";
					}
				}
			}
			$colModels[] 	= "{name:'".$alias."', ".implode(",", $arrColModels)."}";
			$arrColModels	= array();
		}
		$colLabels = implode(",", $colLabels);
		$colModels = implode(",\n", $colModels);
		
		
		$this->strGrid .= $this->varsJs."\n";
		$this->strGrid .= "var table_id_".$this->name."     = '#Grid_".$this->name."';\n";
		$this->strGrid .= "var pager_id_".$this->name."     = '#Pager_".$this->name."';\n";
		$this->strGrid .= "var toppager_id_".$this->name."  = '#Grid_".$this->name."_toppager';\n";
		$this->strGrid .= "var arrColAlias                  = {".implode(',', $arrColAlias)."};\n";  	//Array con el alias y name de las columnas
		if(!$this->isSubGrid){
			$this->strGrid .= " $(document).ready(function() {\n";
		}
		if(!$this->isSubGrid){
			$this->strGrid .= "$(table_id_".$this->name.").jqGrid({\n";
		}else{
			$this->strGrid .= "$(\"#\"+subgrid_table_id).jqGrid({\n";
		}
		$paramWhere = "',";
		if($this->isSubGrid){
			$paramWhere = "&id='+row_id,";
		}
		$this->strGrid .= "url 					: '".$this->pathIndex."?r=jqgrid/Grid/reload&name=".$this->name.$paramWhere."\n";		
		$this->strGrid .= "scrollrows 				: true,\n";
		$this->strGrid .= "datatype				: 'json',\n";
		$this->strGrid .= "mtype				: 'GET',\n";
		$this->strGrid .= "colNames				: [".$colLabels."],\n";
		$this->strGrid .= "colModel				: [".$colModels."],\n";
		$this->strGrid .= "toppager				: ".$this->options['toppager_str'].",\n"; 			// Numero de registros por página\n";
		$this->strGrid .= "rowNum				: ".$this->resultPage.",\n"; 			// Numero de registros por página\n";
		$this->strGrid .= "rowList				: [".$this->options['rowList']."],\n"; 			// Lista del combo con números de páginas\n";
		$this->strGrid .= "rownumbers				: ".$this->options['rownumbers_str'].",\n"; 		// Si se muestra o no el numero del registro\n";
		$this->strGrid .= "rownumWidth				: '30',\n"; 									// Tamaño de la columna donde se muestra el número del registro\n";
		$this->strGrid .= "autowidth				: ".$this->options['autowidth_str'].",\n"; 	// Por defecto el ancho es automático y al 100%\n";
		$this->strGrid .= "viewrecords				: true,\n"; 									// Mostrar Registros
		$this->strGrid .= "hiddengrid				: ".$this->options['hiddengrid_str'].",\n"; 		// Si se muestra oculta o no la Grid al cargarse
		$this->strGrid .= "editurl				: '".$this->pathIndex."?r=jqgrid/Ajax/crud',\n"; // Url de la página de las operaciones Crud
		$this->strGrid .= "gridview				: false,\n";
		$this->strGrid .= "footerrow 				: ".$this->options['footerrow_str'].",\n";
		$this->strGrid .= "userDataOnFooter			: true,\n";
		$this->strGrid .= "altRows 				: true,\n";
		$this->strGrid .= "height				: '".$this->options['height']."',\n";
		$this->strGrid .= "width				: '".$this->options['width']."',\n";
		$this->strGrid .= "multiSort				: ".$this->options['multiSort_str'].",\n";			
		if(isset($this->options['subGrid']) && $this->options['subGrid'] != ''){ 
			$this->strGrid .= "subGrid				: true,\n";
			$this->strGrid .= "subGridRowExpanded	: function(subgrid_id, row_id) {\n";
			$this->strGrid .= "var subgrid_table_id, pager_id; subgrid_table_id = subgrid_id+\"_t\"; pager_id = \"p_\"+subgrid_table_id;";
			$this->strGrid .= "$(\"#\"+subgrid_id).html(\"<table id='\"+subgrid_table_id+\"' class='scroll'></table><div id='\"+pager_id+\"' class='scroll'></div>\");\n";
			$this->strGrid .= $this->options['subGrid'];
			$this->strGrid .= "},";
		}			
                $this->strGrid .= "
                loadError: function(xhr,status, err){
                                    try {
                                        jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class=\"ui-state-error\">'+ err+' '+xhr.responseText +'</div>', jQuery.jgrid.edit.bClose,
                                        {buttonalign:'right'});
                                    } catch(e) {
                                        alert(xhr.responseText);
                                    }
                                },
		loadComplete 			: function(){
                                                                            var myData = $(table_id_".$this->name.").jqGrid('getGridParam', 'userData');
                                                                            if(myData != undefined){
                                                                                    if(myData.order != undefined){
                                                                                            var arrSort 	= myData.order.split(', ');
                                                                                            var strOrder 	= '';
                                                                                            var campo 		= '';
                                                                                            for(i=0; i<arrSort.length; i++){
                                                                                                    campo 	= arrSort[i].split(' ');
                                                                                                    if(arrColAlias[campo[0]] != undefined){
                                                                                                            strOrder+= arrColAlias[campo[0]].trim()+' '+campo[1].trim()+', ';
                                                                                                    }
                                                                                            }
                                                                                            strOrder = strOrder.substring(0,(strOrder.length-2));
                                                                                            var Pager_right = $('#Pager_".$this->name."_right').children().html();
                                                                                            $('#Pager_".$this->name."_right').children().html('Ordenado por: '+strOrder+' | '+Pager_right);
                                                                                            Pager_right = $('#Grid_".$this->name."_toppager_right').children().html();
                                                                                            $('#Grid_".$this->name."_toppager_right').children().html('Ordenado por: '+strOrder+' | '+Pager_right);
                                                                                    }																	
                                                                                    var records 	= $(table_id_".$this->name.").jqGrid('getGridParam', 'records');
                                                                                    var reloadNumber 	= myData.reloadNumber;\n
                                                                            }";																						
		$this->strGrid .= "	}\n";
		/**
		 * Agrupamiento
		 */
		if(count($this->groupField) >= 1)
		{
			$groupField 		= '';
			$groupColumnShow 	= '';
			$groupOrder 		= '';
			foreach ($this->groupField['name'] as $name => $arr) {
				$groupField .= "'".$name."',";
				if($this->groupField['columnShow'][$name]){
					$groupColumnShow 	.= "true,";
				}else{
					$groupColumnShow 	.= "false,";
				}
				if($this->groupField['order'][$name] == ''){
					$groupOrder 		.= "'asc',";
				}else{
					$groupOrder 		.= "'".$this->groupField['order'][$name]."',";
				}
				if($this->groupField['summary'][$name]){
					$groupSummary 		.= "true,";
				}else{
					$groupSummary 		.= "false,";
				}
			}
			$groupField 		= substr($groupField, 0,-1);
			$groupColumnShow 	= substr($groupColumnShow, 0,-1);
			$groupOrder 		= substr($groupOrder, 0,-1);
			$groupSummary 		= substr($groupSummary, 0,-1);
			$this->strGrid .=",
            			  	grouping			: true,
            			  	groupingView 		: {
							groupText 		: ['<b>{0}</b>'],
            			  			groupCollapse 		: false,										
            			  			groupField 		: [" . $groupField . "],
            			  			groupColumnShow 	: [" . $groupColumnShow . "],	            			  			
            			  			groupOrder		: [" . $groupOrder . "],
            			  			groupSummary 		: [" . $groupSummary . "],
                                                        groupDataSorted 	: true
				        	}";
                }
		/**
		 * It created the grid actions
		 */
		$this->createActions();
		
		
		/**
		 * Si $this->urlClic != '' entonces se genera la función que al dar doble click sobre la columnas,
		 * envia el campo_id a la url indicada
		 */
		if($this->urlActionDefault != "")
		{
			/**
			 * Se debe enviar la URL seguido del nombre del campo id =
			 */
			$this->strGrid .=  ",
                                            ondblClickRow: function(id) {
	            			  	var idCell = jQuery(table_id_".$this->name.").jqGrid ('getCell', id, '".$this->keyField."');
                                                window.open('".$this->urlActionDefault."'+idCell+'&".$this->varsUrl."','".$this->urlActionDefaultTarget."'); 
                                            }";
		}elseif($this->urlActionModalDefault != "")
		{
			/**
			 * Si es tipo modal de abre en una ventana
			 */			
			$this->urlActionModalOptions  = "{".$this->urlActionModalOptions."}";			
			$this->strGrid .=  ",
                                            ondblClickRow: function(id) {
	            			  	var idCell = jQuery(table_id_".$this->name.").jqGrid ('getCell', id, '".$this->keyField."');
	            			  	openDlgExportGrid('iddialog'+id,'".$this->urlActionModalDefault."'+idCell+'&".$this->varsUrl."',".$this->urlActionModalOptions.");
                                            }";
		}
                
		if($this->options['caption'] != ''){
			$this->strGrid .= ",caption			: '".$this->options['caption']."'\n"; // Titulo de la Grid
		}
                $this->strGrid .= ",shrinkToFit			: ".$this->options['shrinkToFit']."\n";  // Esta propiedad se rqeuiere cuando hay columnas frozen";   
		
		if(isset($this->options['frozenColumns']) && $this->options['frozenColumns']){
			$this->frozenColumns = true;
		}
		if($this->options['sortorder'] != ''){
			$this->strGrid .= ",sortname			: '".$this->options['sortname']."',\n";
			$this->strGrid .= "sortorder			: '".$this->options['sortorder']."'\n";
		}
                
                /**
		 * Si existe resizeStart, creo el evento
		 */
		if($this->resizeStart != '')
		{
			$this->strGrid .= ", resizeStart: function(event, index) {
					            		".$this->resizeStart."
					        			}";
		}
		/**
		 * Si existe resizeStop, creo el evento
		 */
		if($this->resizeStop != '')
		{
			$this->strGrid .= ", resizeStop: function(event, index) {
					            		".$this->resizeStop."
					        			}";
		}
		/**
		 * Si existe onSelectRow, la pinto
		 */
		if($this->onSelectRow != '')
		{
			$this->strGrid .= ", onSelectRow: function(rowid) { 
					            		".$this->onSelectRow."
					        			}";
		}
		/**
		 * Si existe onSelectRow, la pinto
		 */
		if($this->beforeSelectRow != '')
		{
			$this->strGrid .= ", beforeSelectRow: function (rowid) { 
					            		".$this->beforeSelectRow."
					        			}";
		}
		/**
		 * Si existe beforeEditCell, la pinto
		 */
		if($this->beforeEditCell != '')
		{
			$this->strGrid .= ", beforeEditCell: function(rowid, cellname, value, irow, icol) {
					            		".$this->beforeEditCell."
					        			}";
		}
		/**
		 * Si existe afterInsertRow, la ingreso
		 */
		if($this->afterInsertRow != '')
		{
			$this->strGrid .= ", afterInsertRow: function(rowid, rowdata, rowelem) {
									            		".$this->afterInsertRow."
										}";
		}
		/**
		 * Si existe onRightClickRow, la ingreso
		 */
		if($this->onRightClickRow != '')
		{
			$this->strGrid .= ", onRightClickRow: function(rowid,iRow,iCol,e) {
	            			 ".$this->onRightClickRow."
	        			}";
		}
                /**
                 * Si existe gridComplete, la ingreso
                 */
                if($this->gridComplete != '' && !$this->haveAction)
                {
                        $this->strGrid .= ", gridComplete: function(){
                                                        ".$this->gridComplete."
                                                        }";
                }
		/***
		 * Termina Creación básica del script
		*/
		$this->strGrid .= " 	});\n";
		
		
		if($this->options['toolbarfilter'])
		{
			
			$searchOperators = $this->searchOperators == true ? 'true': 'false';
			$this->strGrid .= "
				/**
				* Colocar la busqueda en los titulos
				*/
				jQuery(table_id_".$this->name.").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true, defaultSearch: '".$this->defaultSearch."', searchOperators : ".$searchOperators."});\n";
		}
		if($this->frozenColumns){
                    $this->strGrid  .= " jQuery(table_id_".$this->name.").jqGrid('setFrozenColumns'); ";
		}		
		$jsEdit 		= '';
		$jsAdd 			= '';
		$jsDel 			= '';
		$beforeEdit		= '';
		$afterEdit		= '';
		$beforeInsert	= '';
		$afterInsert	= '';
		$beforeDelete	= '';
		$afterDelete	= '';
		/**
		 * MANEJO DE EVENTOS
		 */
		/**
		 * Establezco las opciones de edicción, eliminación etc, de l a Grid
		 */
		/**
		 * Establezco los campos a ignore en el envio POST
		 */
		$ignorePost	= 'ignore,tableCrud,type,oper,key,id,'. Yii::app()->request->csrfTokenName;
		/**
		 * Creo una variable de session si no ha sido definida
		 * para poder utilizar la acción CRUD del AjaxCtr
		 */
		$tableCrud	= sha1('tblCrudGrid'.$this->name);
		if($this->whereUpdate != ''){
			$_SESSION['whereUpdate'][$tableCrud]	= $this->whereUpdate;
		}
		if($this->whereDelete != ''){
			$_SESSION['whereDelete'][$tableCrud]	= $this->whereDelete;
		}
		if($this->bdName != ''){
			$_SESSION['sqlTableCrud'][$tableCrud]	= $this->bdName.".".$this->ppalTable;
		}else{
			$_SESSION['sqlTableCrud'][$tableCrud]	= $this->ppalTable;
		}
                $_SESSION['gridReportName'][$tableCrud]	= $this->report_id;
                
		if($this->del)
		{
			$jsDel ="onclickSubmit : function(eparams) {
						      return {ignore:'".$ignorePost."',tableCrud:'".$tableCrud."',type:'delete',key:'".$this->keyField."',".Yii::app()->request->csrfTokenName.":'".Yii::app()->request->csrfToken."'}
					},";
                        if($this->afterSubmitDel == ''){
				$jsDel .="afterSubmit: function(response,postdata){
                                                    var myresponse = response.responseText;
                                                    if(response.responseText==1){
                                                        success=true;
                                                     }else{ 
                                                        success = false;
                                                        myresponse = '".$this->textNoDelete."';
                                                     }                  
                                            return [success,myresponse];
                                        },";
                         }else{
                             $jsDel .="afterSubmit: function(response,postdata){
                                             ".$this->afterSubmitDel."      
                                        },";
                         } 
		}
		if($this->add)
		{
			$extraParams = '';
			foreach ($this->extraParamsInsert as $key => $value) {
				$extraParams .= ",".$key.":'".$value."'";
			}
			$jsAdd ="onclickSubmit : function(eparams) {
						      return {ignore:'".$ignorePost."',tableCrud:'".$tableCrud."',type:'insert',key:'".$this->keyField."'".$extraParams.",".Yii::app()->request->csrfTokenName.":'".Yii::app()->request->csrfToken."'}
					},";
                        if($this->afterSubmitAdd == ''){
                            $jsAdd .="afterSubmit: function(response,postdata){
                                                    if(response.responseText==1){
                                                        success=true;
                                                     }else{ 
                                                        success = false;
                                                     }                  
                                            return [success,response.responseText] ;
                                        },";
                         }else{
                             $jsAdd .="afterSubmit: function(response,postdata){
                                             ".$this->afterSubmitAdd."      
                                        },";
                         }                    
		}
		if($this->edit)
		{ 
			$extraParams = '';
			foreach ($this->extraParamsEdit as $key => $value) {
				$extraParams .= ",".$key.":'".$value."'";
			}
			$jsEdit ="onclickSubmit : function(eparams) {
                                                      $('#divJs').empty();
						      return {ignore:'".$ignorePost."',tableCrud:'".$tableCrud."',type:'update',key:'".$this->keyField."'".$extraParams.",".Yii::app()->request->csrfTokenName.":'".Yii::app()->request->csrfToken."'}
					},";
                        if($this->afterSubmitEdit == ''){
                            $jsEdit .="afterSubmit: function(response,postdata){
                                                    var myresponseEdit = response.responseText;
                                                    if(response.responseText==1){
                                                        success=true;
                                                     }else{ 
                                                        success = false;
                                                        myresponseEdit = '".$this->textNoUpdate."';
                                                     }                  
                                            return [success,myresponseEdit];
                                        },";
                         }else{
                             $jsEdit .="afterSubmit: function(response,postdata){
                                             ".$this->afterSubmitEdit."      
                                        },";
                         }
		}
		/**
		 * After
		 */
		foreach ($this->arrAfterEvents as $key => $event){
			if($this->$event != '')
			{
				$$event ="
								,afterSubmit: function (response, postdata){
									if(response.responseText >= 1)
							        		{
							        	 		".$this->$event.";
							        	 		jQuery(table_id_".$this->name.").trigger('reloadGrid');
												$('.ui-widget-overlay').remove();
							        	 		$('#".$this->arrAfterWindow[$event]."'+table_id_".$this->name.".substring(1)).remove();
							        	 	}
									}";
					
			}
		}
		/**
		 * Before
		 * Note: you must add the following line at the end on the property beforeEdit
		 * return return[bool(true,false),mensaje(mensaje a mostrar en caso de error)];
		 */
		foreach ($this->arrBeforeEvents as $type => $event){
			if($this->$event != '')
			{
				$$event ="
								,beforeSubmit: function(postdata, formid) {
									".$this->$event.";
								}";
			}
		}
		
		$this->edit 			= $this->edit == true ? 'true': 'false';
		$this->add 				= $this->add == true ? 'true': 'false';
		$this->del 				= $this->del == true ? 'true': 'false';
		$this->search 			= $this->search == true ? 'true': 'false';
		$this->view 			= $this->view == true ? 'true': 'false';
		$this->multipleSearch 	= $this->multipleSearch == true ? 'true': 'false';
		$this->multipleGroup 	= $this->multipleGroup == true ? 'true': 'false';
		$this->showQuery 		= $this->showQuery == true ? 'true': 'false';
		
		$this->strGrid .= "jQuery(table_id_".$this->name.").jqGrid('navGrid',pager_id_".$this->name.",{\n";
		$this->strGrid .= "edit		:".$this->edit.",\n";
		$this->strGrid .= "add		:".$this->add.",\n";
		$this->strGrid .= "del		:".$this->del.",\n";
		$this->strGrid .= "search	:".$this->search.",\n";
		$this->strGrid .= "view		:".$this->view.",\n";
		$this->strGrid .= "refresh:false\n";
			if($this->options['toppager']){
			$this->strGrid .=",cloneToTop:true";
		}		
		$this->strGrid .="},
						  	{
									".$jsEdit."
									closeAfterEdit: true
									".$beforeEdit."
									".$afterEdit."
									,afterShowForm: function() {
                                                                            ".$this->afterShowForm."
                                                                          },
									beforeShowForm: function(formid) {
                                                                            ".$this->beforeShowForm."
                                                                          },
							        width:\"".$this->widthFormEdit."\",
								},
								{
									".$jsAdd."
									closeAfterAdd: true
									".$beforeInsert."
									".$afterInsert."
									,afterShowForm: function() {
								    	".$this->afterShowForm."
								     },
							        width:\"".$this->widthFormEdit."\",
								},
								{
									".$jsDel."
									closeAfterDelete: true
									".$beforeDelete."
									".$afterDelete."
									,afterShowForm: function() {
							          ".$this->afterShowForm."
							        }
								},
								{
									multipleSearch:".$this->multipleSearch.",
														 multipleGroup:".$this->multipleGroup.",
														 showQuery: ".$this->showQuery."				    
								},								
								{
									width:\"".$this->widthFormEdit."\",
								
								});";
		/**
		 * 	Here are passed to the grid additional buttons created in the method createButton();
		*/
		$this->strGrid 	.= $this->strButtons;
		
		/**
		 * If I set the search in the title bar, the hidden action column
		 */
		if($this->options['toolbarfilter']){
			$this->strGrid .= "$('#gs_grid_accion').hide();";
		}
		$groupHeaders = '';
		if(count($this->groupHeaders) > 0){
			foreach ($this->groupHeaders['titleText'] as $key => $title) {
				$groupHeaders .= "{startColumnName: '".$this->groupHeaders['startColumnName'][$key]."',
										numberOfColumns: ".$this->groupHeaders['numberOfColumns'][$key].",
										titleText: '<em>".$title."</em>'},";
			}
		}
                
                $this->strGrid .= "jQuery('#edit_'+ table_id_".$this->name.").addClass('ui-state-disabled');";
                $this->strGrid .= "jQuery('#del_' + table_id_".$this->name.").addClass('ui-state-disabled');";
                if($this->responsive){
                    $this->strGrid .= "$(window).bind('resize', function() {
                                            $('#Grid_".$this->name."').setGridWidth($(window).width()-80);
                                        }).trigger('resize');";
                }
		if($groupHeaders != ''){
			$groupHeaders = substr($groupHeaders, 0,-1);
			$this->strGrid .= "jQuery('#Grid_".$this->name."').jqGrid('setGroupHeaders', { useColSpanStyle: true,
																			groupHeaders:[".$groupHeaders." ]});";
		}
		$this->strGrid .= "
							jQuery('.ui-jqgrid-title').replaceWith('<div style=\"text-align: center;\"><span>'+jQuery('.ui-jqgrid-title').text() + '</span></div>');
							";
		if($this->options['toppager']){
			$this->strGrid .= "$('#Pager_".$this->name."').remove();
								  $('.ui-pg-button').css('cursor','pointer');" ;
			if($this->inputSearch){
				$this->strGrid .= "var inputSearch = '<input style=\"width:98%;\" class=\"gridInputFind\" id=\"gridInputFind".$this->name."\" name=\"gridInputFind".$this->name."\" value=\"".$this->textInputSearch."\" onblur=\"if(this.value == \'\' || this.value == \'".$this->textInputSearch."\'){ this.value= \'".$this->textInputSearch."\'; }\" onfocus=\"if(this.value == \'".$this->textInputSearch."\'){this.value= \'\';}\" onkeypress=\" var keycode = (event.keyCode ? event.keyCode : event.which); if(keycode == 13) {buscarEnGrid".$this->name."(\'Grid_".$this->name."\')}\" />';
									  $('.ui-pg-table .navtable > tbody>tr')                                                                             
                                                                                        .append('<td id=\"99999999_strDivBuscar\">'+inputSearch+'</td>');									  
                                                                          \n";
			}
		}
		if($this->options['toppager'] && $this->options['width'] >100){
			$this->strGrid .= " 	var posicion 		= $('#Grid_".$this->name."_toppager').offset();
								 	$('#pg_Grid_".$this->name."_toppager').css('width',($(window).width()-posicion.left));";
		}
		$this->createButtons();
		$this->strGrid .= $this->strButtons;		
		/**
		 * END document.ready
		 */
		if(!$this->isSubGrid){
			$this->strGrid .= " });";
		}
		if($this->options['toppager']){
			$this->strGrid .= "function buscarEnGrid".$this->name."(id){
									jQuery('#'+id).jqGrid('setGridParam',{postData: {gridInputFind:$('#gridInputFind".$this->name."').val()}});
									jQuery('#'+id).jqGrid('setGridParam').trigger(\"reloadGrid\");
								}\n";
		}
		/**
		 * Sampling the search input, this bug detected when there is a hidden field
		 */
		Yii::app()->clientScript->registerScript('grid', " $(document).ready(function() {\n
                                                                                jQuery('.ui-search-input').css('display','block');\n
                                                                   });\n", 1);
/**
		 * Muestro los input de busqueda, esto por un bug detectado cuando hay un campo oculto
		 */	
// 		$this->strGrid .= $strOcultarColumns;
// 		$this->strGrid .= "		}\n";
		$this->strHtml 	= "<table id=\"Grid_".$this->name."\"></table>\n";
		$this->strHtml .= "<div id=\"Pager_".$this->name."\" ></div>\n";
		$this->strHtml .= "<div id=\"Filtros_".$this->name."\"></div>\n";
		$this->strHtml .= "<div id=\"divToolTip".$this->name."\"></div>\n";
		$this->strHtml .= "<div id=\"dialogExportGrid\">\n
                                                                <div id=\"grid-img-load\"><img src=\"".$this->pathImagesButtons."loading1.gif\"></div>
								<iframe id=\"export-grid-frame\" width=\"100%\" height=\"100%\" frameBorder=\"0\"></iframe>\n
							</div>\n";
		Yii::app()->clientScript->registerScript('grid-Export', "
					$('#document').ready(function(){
						jQuery('#dialogExportGrid').dialog({'autoOpen':false});
					});
					\n", 1);
		Yii::app()->clientScript->registerScript('grid-Export-function', "			
					function openDlgExportGrid(id,url,option){
							if(url != undefined){
								$(\"#export-grid-frame\").attr(\"src\",url);
							}else{
								$(\"#export-grid-frame\").attr(\"src\",$(id).attr(\"url\"));
							}
							$(\"#dialogExportGrid\").dialog(\"open\"); 
							if(option != undefined){
								$(\"#dialogExportGrid\").dialog(\"option\", option);
							} 
                                                        $(\"#dialogExportGrid\").dialog('widget').position({my:'center', at:'center', of:window});
                                                        $(\"#grid-img-load\").hide();
							 return false;
					};\n", 1);
		$this->strHtml .= "<div id=\"divVentanaModal\"></div>\n";
		Yii::app()->clientScript->registerScript('grid', $this->strGrid, 1);
		/**
		 * Serialized the object and put it in the session variable of the same name in the Grid
		 */
		$this->session["ObjGrid".$this->name] = serialize($this);
		return $this->strHtml;		
	}
	
	/**
	 *
	 * This method converts the HTML table format jqGrid
	 *
	 * @author Jorge Arzuaga jorgearzuaga1@hotmail.com
	 * 4/02/2013
	 *
	 * @param string $strId
	 */
	function tableToGrid($strId){
		if($strOptions == ''){
			$strOptions = '
				   			';
		}
		$this->edit 			= $this->edit == true ? 'true': 'false';
		$this->add 				= $this->add == true ? 'true': 'false';
		$this->del 				= $this->del == true ? 'true': 'false';
		$this->search 			= $this->search == true ? 'true': 'false';
		$this->view 			= $this->view == true ? 'true': 'false';
		$this->multipleSearch 	= $this->multipleSearch == true ? 'true': 'false';
		$this->multipleGroup 	= $this->multipleGroup == true ? 'true': 'false';
		$this->showQuery 		= $this->showQuery == true ? 'true': 'false';
		
		$js = '$(document).ready(function() {
				tableToGrid("#'.$strId.'", {
   					pager		: "#'.$strId.'pager",
				   	rowNum		: '.$this->resultPage.',
				   	rownumbers	: '.$this->options['rownumbers_str'].',
				   	viewrecords	: true,
				   	loadui		: true,
			   			height		: "'.$this->options['height'].'",
						width		: "'.$this->options['width'].'",
			   			toppager	: true,
			   			rowList		: ['.$this->options['rowList'].']
  				});
   				jQuery("#'.$strId.'").trigger("reloadGrid");
   				jQuery("#'.$strId.'").jqGrid("navGrid","'.$strId.'pager",{
   								edit:'.$this->edit.',
                                add:'.$this->add.',
                                del:'.$this->del.',
                                search:'.$this->search.',
                                view:'.$this->view.',
								refresh:false,
								cloneToTop:true
   								},
								{},{},{},
								{
									multipleSearch:'.$this->multipleSearch.',
									multipleGroup:'.$this->multipleGroup.',
									showQuery: '.$this->showQuery.'
								},
								{
									width:"auto"
								}
								);';
		if($this->filterToolbar)
		{
			$js .= '
					/**
					 * Place the search in the titles
					 */
					$("#'.$strId.'").jqGrid("filterToolbar",{stringResult: true,searchOnEnter : true, defaultSearch: "'.$this->defaultSearch.'"});';
		}
		if($this->options['toppager']){
			$js.='$("#'.$strId.'pager").remove();';
		}
		$js .= "});";
		Yii::app()->clientScript->registerScript('tableToGrid', $js, 2);
		return '<div id="'.$strId.'pager"></div>';
	}
}