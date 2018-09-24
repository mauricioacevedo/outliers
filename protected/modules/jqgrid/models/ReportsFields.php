<?php

/**
 * This is the model class for table "tbl_reports_fields".
 *
 * The followings are the available columns in table 'tbl_reports_fields':
 * @property integer $field_id
 * @property integer $report_id
 * @property string $table_field
 * @property string $field
 * @property string $alias
 * @property string $label
 * @property string $field_find
 * @property string $align
 * @property integer $field_type_id
 * @property string $option_list
 * @property string $select_sql
 * @property string $field_id_list
 * @property string $field_desc_list
 * @property integer $select_complex
 * @property string $function_aggregate
 * @property string $foreign_table
 * @property string $foreign_table_field_id
 * @property string $foreign_table_desc
 * @property string $select_filter
 * @property string $comparison
 * @property string $order_by
 * @property integer $group_by
 * @property integer $field_where
 * @property integer $find_form
 * @property integer $show_in_grid
 * @property integer $show_in_form
 * @property string $group_header
 * @property integer $group_header_columns
 * @property integer $frozen_column
 * @property integer $order_field
 * @property integer $width
 * @property integer $width_column
 * @property integer $editable
 * @property integer $required
 * @property string $formatter
 * @property string $format_options
 * @property string $edit_options
 * @property string $summary_type
 * @property string $summary_tpl
 * @property string $formoptions
 * @property string $editrules
 * @property integer $search
 * @property string $searchrules
 * @property string $text_help
 * @property integer $readonly
 * @property string $defaultvalue
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 *
 * The followings are the available model relations:
 * @property Reports $report
 * @property ReportsFieldType $fieldType
 */
class ReportsFields extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reports_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('report_id, table_field, field, alias, label, field_find, align, field_type_id, option_list, select_sql, field_id_list, field_desc_list, select_complex, function_aggregate, foreign_table, foreign_table_field_id, foreign_table_desc, select_filter, comparison, order_by, group_by, field_where, find_form, show_in_grid, show_in_form, group_header, group_header_columns, frozen_column, order_field, width, width_column, editable, required, formatter, format_options, edit_options, summary_type, summary_tpl, formoptions, editrules, search, searchrules, text_help, readonly, defaultvalue, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('report_id, table_field, field, alias, label', 'required'),
			array('report_id, field_type_id, select_complex, group_by, field_where, find_form, show_in_grid, show_in_form, group_header_columns, frozen_column, order_field, width, width_column, editable, required, search, readonly', 'numerical', 'integerOnly'=>true),
			array('table_field, field_find, field_id_list, foreign_table_field_id, formatter, summary_type, summary_tpl, formoptions, defaultvalue, creadopor, modificadopor', 'length', 'max'=>100),
			array('field, field_desc_list, foreign_table_desc', 'length', 'max'=>1000),
			array('alias', 'length', 'max'=>30),
			array('label, option_list, select_sql, select_filter', 'length', 'max'=>500),
			array('align', 'length', 'max'=>10),
			array('function_aggregate, group_header', 'length', 'max'=>400),
			array('foreign_table', 'length', 'max'=>40),
			array('comparison', 'length', 'max'=>2),
			array('order_by', 'length', 'max'=>4),
			array('format_options, edit_options, editrules', 'length', 'max'=>200),
			array('searchrules', 'length', 'max'=>300),
			array('text_help', 'length', 'max'=>1500),
			array('fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('field_id, report_id, table_field, field, alias, label, field_find, align, field_type_id, option_list, select_sql, field_id_list, field_desc_list, select_complex, function_aggregate, foreign_table, foreign_table_field_id, foreign_table_desc, select_filter, comparison, order_by, group_by, field_where, find_form, show_in_grid, show_in_form, group_header, group_header_columns, frozen_column, order_field, width, width_column, editable, required, formatter, format_options, edit_options, summary_type, summary_tpl, formoptions, editrules, search, searchrules, text_help, readonly, defaultvalue, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'report' => array(self::BELONGS_TO, 'Reports', 'report_id'),
			'fieldType' => array(self::BELONGS_TO, 'ReportsFieldType', 'field_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'field_id' => 'Field',
			'report_id' => 'Id del informe relacionado con la tabla tbl_informes',
			'table_field' => 'Nombre de la tabla del campo por lo general es la misma tabla principal ',
			'field' => 'Campo tal cual se tomaría del select, puede incluir una sentencia compleja, IF, CASE ect., en ese se marca la casilla select_complejo como true',
			'alias' => 'alias único de la consulta',
			'label' => 'Titulo de la columna que se mostrará en la Grid',
			'field_find' => 'Columna con la tabla por la cual se hará la consulta aplica para cuando se quiere buscar por texto en tablas cruzadas',
			'align' => 'Alineación del campo left,rigth,center',
			'field_type_id' => 'Id del Tipo de campo que se encuentra en la tabla tbl_p_tipo_campo_form',
			'option_list' => 'Opcione de las listas estáctica separadas por pipe |',
			'select_sql' => 'SQL de la consulta a la tabla de opciones',
			'field_id_list' => 'nombre del campo id del cual se toman los valores dela lista para los campos tipo lista_tabla',
			'field_desc_list' => 'nombre del campo descripción del cual se toman las descripción de la lista para los campos tipo lista_tabla',
			'select_complex' => 'Si el campo "campo" contiene IF, CASE u otro tipo de sentencia que no sea el campo solo, se debe marcar como verdadero para que funcione la consulta',
			'function_aggregate' => 'Si ejecuta alguna función agregada tipo MAX, COUNT etc',
			'foreign_table' => 'Nombre de la tabla a la cual se realizará la relación con la tabla ingresada en el campo Tabla (LEFT JOIN)',
			'foreign_table_field_id' => 'Nombre del campo por medio del cual se realiza la relación la relación con el campo ingresada en la opción Campo (Tabla.Campo = Tabla Foranea.Campo ID Tabla Foranea)',
			'foreign_table_desc' => 'Nombre del campo que se mostrará en la consulta',
			'select_filter' => 'En este campo se envia el select completo de la lista, , el primer campo se toma con el ID y el segundo como la Descripción',
			'comparison' => '"eq" => "=","ne" => "<>", "lt" => "<", "le" => "<=","gt" => ">","ge" => ">="',
			'order_by' => 'Solo se debe colocar el tipo ASC, DESC',
			'group_by' => 'Determina si un campo se devuelve para hacer group by',
			'field_where' => 'Indica si a una consulta se le aplica where a traves de éste campo',
			'find_form' => 'Indica si es un filtro del formulario de busqueda',
			'show_in_grid' => '1 Si, 0 No',
			'show_in_form' => 'Show In Form',
			'group_header' => 'Nombre de la columna agrupadas a partir de esta',
			'group_header_columns' => 'Número de columnas a agrupar a partir de esta',
			'frozen_column' => 'Si la columna se inmoviliza cuando se desplazan a la derecha',
			'order_field' => 'Orden en que se toman las variables',
			'width' => 'Width',
			'width_column' => 'Ancho de la columna en la grid',
			'editable' => 'Si el campo es editable o no 0 ó 1',
			'required' => 'Si el campo es requerido al momento de la edición',
			'formatter' => 'Formatter',
			'format_options' => 'Format Options',
			'edit_options' => 'Edit Options',
			'summary_type' => 'Summary Type',
			'summary_tpl' => 'Summary Tpl',
			'formoptions' => 'Formoptions',
			'editrules' => 'Editrules',
			'search' => 'Search',
			'searchrules' => 'Searchrules',
			'text_help' => 'Text Help',
			'readonly' => 'Readonly',
			'defaultvalue' => 'Defaultvalue',
			'creadopor' => 'Creadopor',
			'fechacreacion' => 'Fechacreacion',
			'modificadopor' => 'Modificadopor',
			'fechamodificacion' => 'Fechamodificacion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('field_id',$this->field_id);
		$criteria->compare('report_id',$this->report_id);
		$criteria->compare('table_field',$this->table_field,true);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('field_find',$this->field_find,true);
		$criteria->compare('align',$this->align,true);
		$criteria->compare('field_type_id',$this->field_type_id);
		$criteria->compare('option_list',$this->option_list,true);
		$criteria->compare('select_sql',$this->select_sql,true);
		$criteria->compare('field_id_list',$this->field_id_list,true);
		$criteria->compare('field_desc_list',$this->field_desc_list,true);
		$criteria->compare('select_complex',$this->select_complex);
		$criteria->compare('function_aggregate',$this->function_aggregate,true);
		$criteria->compare('foreign_table',$this->foreign_table,true);
		$criteria->compare('foreign_table_field_id',$this->foreign_table_field_id,true);
		$criteria->compare('foreign_table_desc',$this->foreign_table_desc,true);
		$criteria->compare('select_filter',$this->select_filter,true);
		$criteria->compare('comparison',$this->comparison,true);
		$criteria->compare('order_by',$this->order_by,true);
		$criteria->compare('group_by',$this->group_by);
		$criteria->compare('field_where',$this->field_where);
		$criteria->compare('find_form',$this->find_form);
		$criteria->compare('show_in_grid',$this->show_in_grid);
		$criteria->compare('show_in_form',$this->show_in_form);
		$criteria->compare('group_header',$this->group_header,true);
		$criteria->compare('group_header_columns',$this->group_header_columns);
		$criteria->compare('frozen_column',$this->frozen_column);
		$criteria->compare('order_field',$this->order_field);
		$criteria->compare('width',$this->width);
		$criteria->compare('width_column',$this->width_column);
		$criteria->compare('editable',$this->editable);
		$criteria->compare('required',$this->required);
		$criteria->compare('formatter',$this->formatter,true);
		$criteria->compare('format_options',$this->format_options,true);
		$criteria->compare('edit_options',$this->edit_options,true);
		$criteria->compare('summary_type',$this->summary_type,true);
		$criteria->compare('summary_tpl',$this->summary_tpl,true);
		$criteria->compare('formoptions',$this->formoptions,true);
		$criteria->compare('editrules',$this->editrules,true);
		$criteria->compare('search',$this->search);
		$criteria->compare('searchrules',$this->searchrules,true);
		$criteria->compare('text_help',$this->text_help,true);
		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('defaultvalue',$this->defaultvalue,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReportsFields the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
