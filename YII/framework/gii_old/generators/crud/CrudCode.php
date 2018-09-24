<?php

class CrudCode extends CCodeModel
{
	public $model;
	public $controller;
	public $columnsForm 			= 2;
	public $generateReport 			= false;
	public $createBreadCrumbs 		= true;
	public $insertController 		= false;
	public $accessRulesDefault 		= false;
	public $defaultYiiBooster 		= false;
	public $toggleButtonRow 		= true;
	public $createFindMethod 		= false;
	public $reportId 			= '';
	public $commentsAsLabels 		= false;
        public $moduleName                      = '';
	public $baseControllerClass		= 'Controller';
	public $enableAjaxValidation	= true;
        public $inputsList;
	public $createField = array();

	private $_modelClass;
	public $_table;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller, moduleName, enableAjaxValidation, generateReport, commentsAsLabels, createFindMethod, insertController, accessRulesDefault, defaultYiiBooster, toggleButtonRow, createBreadCrumbs', 'filter', 'filter'=>'trim'),
			array('model, controller, baseControllerClass, columnsForm', 'required'),
			array('columnsForm', 'numerical'),
			array('model', 'match', 'pattern'=>'/^\w+[\w+\\.]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass', 'match', 'pattern'=>'/^[a-zA-Z_][\w\\\\]*$/', 'message'=>'{attribute} should only contain word characters and backslashes.'),
			array('baseControllerClass', 'validateReservedWord', 'skipOnError'=>true),
			array('model', 'validateModel'),
			array('baseControllerClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model'=>'Model Class',
			'controller'=>'Controller ID',
			'columnsForm'=>'Columns Form',
			'generateReport'=>'Generate Report Automatic',
			'createBreadCrumbs'=>'Create Bread Crumbs',
			'commentsAsLabels'=>'Comments As Labels (In Report Automatic)',
			'accessRulesDefault'=>'Access Rule YII Default',
			'toggleButtonRow'=>'Checkbox ToggleButton Style?',
			'createFindMethod'=>'Create Find Method from CJuiAutoComplete in Controller',
			'defaultYiiBooster'=>'Default Yii Booster Style? If no show in table',
			'insertController'=>'Register Controller an actions (create,update,view,admin)',
			'baseControllerClass'=>'Base Controller Class',
                        'inputsList'=>'Seleccione los campos a Crear',
                        'moduleName'=>'Module Name',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function init()
	{
		if(Yii::app()->db===null)
			throw new CHttpException(500,'An active "db" connection is required to run this generator.');
		parent::init();
	}

	public function successMessage()
	{
		$link=CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target'=>'_blank'));
		$msg = "The controller has been generated successfully. You may $link.";
		if($this->reportId > 0){
			$msg = "The controller has been generated successfully. Your report id is <b>".$this->reportId."</b> You may $link.";
		}
                $msg .= "<br>Permisos Delphos json (Copie el siguiente código en su estructura de permisos)<br><br>";
                $msg .= '"'.$this->controller.'":["create","view","update","delete","admin","index"';
                if($this->createFindMethod){
                  $msg .= ',"buscar'.$this->controller.'"'; 
                }
                if(!$this->generateReport){
                  $msg .= ',"export"'; 
                }
                $msg .= ']';
		return $msg;
	}

	public function validateModel($attribute,$params)
	{ 
                $class=@Yii::import($this->model,true); 
                include_once Yii::getPathOfAlias('application.modules.'.$this->moduleName.'.models.'.$class).'.php';
		
                if($this->hasErrors('model'))
			return;		
		if(!is_string($class) || !$this->classExists($class) && $this->moduleName == ''){
			$this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
                }elseif(!is_subclass_of($class,'CActiveRecord')){
			$this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
                }else
		{
			$table=CActiveRecord::model($class)->tableSchema;
			if($table->primaryKey===null)
				$this->addError('model',"Table '{$table->name}' does not have a primary key.");
			elseif(is_array($table->primaryKey))
				$this->addError('model',"Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			else
			{
				$this->_modelClass=$class;
				$this->_table=$table;
			}
		}
	}

	public function prepare()
	{ 
		$this->files=array();
		$templatePath=$this->templatePath;
		$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';
		/**
		 * Registro el controlador y las acciones creadas 
		 */
		if($this->insertController && $_POST['generate']){
			try {								
				$insert			= "INSERT INTO tbl_controller(controller, description) 
										VALUES ('".$this->controller."','".ucfirst(strtolower($this->controller))."')";
				$command		= Yii::app()->db->createCommand($insert);
				$result 		= $command->execute();
				
				$sql 			= "SELECT controller FROM tbl_controller WHERE  controller= '".$this->controller."'";
				$command		= Yii::app()->db->createCommand($sql);
				$recordSet 		= $command->query();
				$rowRecordSet 	= $recordSet->read();
				if($rowRecordSet)
				{
					$arrAcciones = array('create','update','view','admin', 'delete', 'index', 'buscar'.ucfirst($this->controller));
					foreach ($arrAcciones as $accion) {
						try {
								$insert		= "INSERT INTO tbl_controller_action (controller, action, description)
												VALUES ('".$rowRecordSet['controller']."','".$accion."','".$accion."')";
								$command	= Yii::app()->db->createCommand($insert);
								$result 	= $command->execute();
						} catch (Exception $e) {
							echo $e->getMessage();
						}
					}
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}						
		}
		$this->inputsList = $_POST['inputsList'];
                $this->createField = $_POST['createField'];
                
                if($this->moduleName == ''){
                    $viewPath = $this->viewPath;
                }else{
                    $viewPath = Yii::getPathOfAlias('application.modules.'.$this->moduleName.'.views.'.strtolower($this->model));
                }
               
		$files=scandir($templatePath);
		foreach($files as $file)
		{
			if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
			{                            
				$this->files[]=new CCodeFile(
					$viewPath.DIRECTORY_SEPARATOR.$file,
					$this->render($templatePath.'/'.$file)
				);
			}
		} 
                if($this->moduleName == ''){
                    $controllerPath = $this->controllerFile;
                }else{
                    $controllerPath = Yii::getPathOfAlias('application.modules.'.$this->moduleName.'.controllers').DIRECTORY_SEPARATOR.ucfirst($this->controller).'Controller.php';
                }
		$this->files[]=new CCodeFile(
				$controllerPath,
				$this->render($controllerTemplateFile)
		);
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}

	public function getControllerID()
	{
		if($this->getModule()!==Yii::app())
			$id=substr($this->controller,strpos($this->controller,'/')+1);
		else
			$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getUniqueControllerID()
	{
		$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}

	public function getViewPath()
	{
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass,$column)
	{
		return "CHtml::activeLabelEx(\$model,'{$column->name}')";
	}

	public function generateInputField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "CHtml::activeCheckBox(\$model,'{$column->name}')";
		elseif(stripos($column->dbType,'text')!==false)
			return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='activePasswordField';
			else
				$inputField='activeTextField';

			if($column->type!=='string' || $column->size===null)
				return "CHtml::{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function generateActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\$model,'{$column->name}')";
	}

	public function generateActiveField($modelClass,$column,$tableSchema = '')
	{
                $spanInput = 'span6';
		if($column->isForeignKey){
			$key 	= $tableSchema->foreignKeys[$column->name][1];
			$description		= $key;	
			$arrForeignColumns 	= Yii::app()->db->schema->tables[$tableSchema->foreignKeys[$column->name][0]]->columns;
			if(is_array($arrForeignColumns)){
				foreach ($arrForeignColumns as $key1 => $arrColumn){
					if($key1 != $key){
						$description = $key1;
						break;
					}
				}
				$table  	= $tableSchema->foreignKeys[$column->name][0];
				$arrTable	= explode('_', $table);
				$table		= '';
				foreach ($arrTable as $value) {
					$table .= $value;
				}
				$table	= str_ireplace('tbl_p_', '', $table);
				$table	= str_ireplace('tbl_', '', $table);
				$table	= str_ireplace('_', '', $table);	
				$table  = ucfirst($value);
                                
                                $command    = Yii::app()->db->createCommand('SELECT count(*) as count FROM '.$tableSchema->foreignKeys[$column->name][0]);
                                $resultResistencia  = $command->query();
                                $recordResistencia  = $resultResistencia->readAll();
                                $numRecords = $recordResistencia[0]['count'];
                                $multiple = '';
                                if($numRecords <= 15){
                                   $prompt = "'prompt' => 'Seleccione'";
                                    if($this->inputsList[$column->name] == 'multiple'){
                                        $multiple = " 'multiple' => true";
                                        $prompt = '';
                                    }
                                    if($this->inputsList[$column->name] == 'select2Row'){
                                        return "\$modelList = Documento::model()->findAll();
                                        \$fieldTypeFormOptions = array();
                                        foreach (\$modelList as \$value) {
                                            \$fieldTypeFormOptions[] = \$value->".$description.";
                                        }
                                            echo \$form->select2Row(
                                             \$model,
                                             '{$column->name}',
                                               array(
                                                'asDropDownList' => false,
                                                'options' => array(
                                                    'tags' => \$fieldTypeFormOptions,
                                                    'placeholder' => 'Seleccione',
                                                    'width' => '40%',
                                                    'tokenSeparators' => array(',', ' ')
                                                    )
                                                )
                                             )";    
                                    }else{
                                        return "\$fieldTypeFormOptions = CHtml::listData(".$table."::model()->findAll(), '".$key."', '".$description."');
                                            echo \$form->dropDownListRow(
                                             \$model,
                                             '{$column->name}',
                                             \$fieldTypeFormOptions, 
                                             array(".$prompt.$multiple.")
                                             )";    
                                    }
                                }elseif($numRecords > 15){
                                    $controller = ucfirst($this->controller);
                                    return " echo '<div class=\"control-group\">';
                                            echo \$form->labelEx(\$model, '{$column->name}', array('class'=>'control-label'));
                                            echo '<div class=\"controls\">';
                                            echo \$form->hiddenField(\$model, '{$column->name}');
                                            \$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                                'attribute'=>'foreign_{$column->name}',
                                                'model'=>\$model,
                                                'sourceUrl'=>array('".$table."/buscar".$table."'),
                                                'value'=>\$_POST['{$column->name}'],
                                                'name'=>'name',
                                                'id'=>'foreign_{$column->name}',
                                                'options'=>array(
                                                    'minLength'=>'4',
                                                    'select'=>\"js:function(event, ui) {
                                                            $('#{$controller}_{$column->name}').val(ui.item.id);
                                                        }\",
                                                    'change'=>\"js:function(event, ui) {                                                        
                                                            if(!ui.item){
                                                                $('#{$controller}_{$column->name}').val('');
                                                            }
                                                        }\",                                                        
                                                ),
                                                'htmlOptions'=>array(
                                                                'id'=>'foreign_{$column->name}',
                                                                'size'=>70,
                                                                'maxlength'=>45,
                                                                ),
                                                ));  
                                                echo '</div>';
                                                echo '</div>'";
                                }
			}
		}elseif($column->type==='boolean' || $column->dbType==='int(1)' || $column->dbType==='tinyint(1)' || $column->dbType==='bit(1)'){
                  
                        if($this->toggleButtonRow){ 
                            return "echo \$form->toggleButtonRow(\$model,'{$column->name}', array('enabledLabel' => 'Si','disabledLabel' => 'No'))";
                        }else{
                            return "\$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
                                    echo \$form->checkBox(\$model,'{$column->name}')";
                        }
		}elseif($column->dbType==='datetime'){
                     return  "echo \$form->datetimepickerRow(
                                            \$model,
                                            '{$column->name}',
                                             array('options' => array(
                                                                        'showMeridian' => false,
                                                                        'minuteStep' => 5    
                                                                        ),
                                                  'htmlOptions' =>  array()                      
                                                  )
                                           )";
		}
		elseif($column->dbType==='date'){                    
                     return  "echo \$form->datepickerRow(
                                            \$model,
                                            '{$column->name}',
                                             array('options' => array(
                                                                        'language' => 'es',
                                                                        'format' => 'yyyy-mm-dd'
                                                                        ),
                                                  'htmlOptions' =>  array('class' => 'input-small')                      
                                                   )   
                                           )";
		}
		elseif($column->dbType==='time'){                        
                     return  "echo \$form->timepickerRow(
                                            \$model,
                                            '{$column->name}',
                                             array('options' => array(
                                                                        'showMeridian' => false
                                                                        ),
                                                  'htmlOptions' =>  array('class' => 'input-small',
                                                                            'size' => 4)                      
                                                   )
                                           )";
		}
		elseif(stripos($column->dbType,'text')!==false)
			return "echo \$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class' => '".$spanInput."'))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordFieldRow';
			else
				$inputField='textFieldRow';

			if($column->type!=='string' || $column->size===null)
				return "echo \$form->{$inputField}(\$model,'{$column->name}',array('class' => '".$spanInput."'))";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "echo \$form->{$inputField}(\$model,'{$column->name}',array('maxlength'=>$maxLength,'class' => '".$spanInput."'))";
			}
		}
	}

	public function guessNameColumn($columns)
	{
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'name'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'title'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if($column->isPrimaryKey)
				return $column->name;
		}
		return 'id';
	}
}