<?php

/**
 * This is the model class for table "tbl_reports".
 *
 * The followings are the available columns in table 'tbl_reports':
 * @property integer $report_id
 * @property string $report
 * @property string $description
 * @property string $host
 * @property string $bd
 * @property string $ppal_table
 * @property string $field_key
 * @property string $sql_query
 * @property integer $toolbarfilter
 * @property integer $show_title
 * @property integer $manual
 * @property integer $toppager
 * @property integer $width
 * @property integer $edit_inline
 * @property integer $edit
 * @property integer $insert_
 * @property integer $delete_
 * @property integer $status
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 *
 * The followings are the available model relations:
 * @property PAyuda[] $pAyudas
 * @property PMenu[] $pMenus
 * @property ReportsFields[] $reportsFields
 * @property ReportsPermissionsRoles[] $reportsPermissionsRoles
 */
class Reports extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reports';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('report, description, host, bd, ppal_table, field_key, sql_query, toolbarfilter, show_title, manual, toppager, width, edit_inline, edit, insert_, delete_, status, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('report, description, ppal_table, field_key', 'required'),
			array('toolbarfilter, show_title, manual, toppager, width, edit_inline, edit, insert_, delete_, status', 'numerical', 'integerOnly'=>true),
			array('report, host, bd, creadopor, modificadopor', 'length', 'max'=>100),
			array('description', 'length', 'max'=>500),
			array('ppal_table, field_key', 'length', 'max'=>40),
			array('sql_query, fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('report_id, report, description, host, bd, ppal_table, field_key, sql_query, toolbarfilter, show_title, manual, toppager, width, edit_inline, edit, insert_, delete_, status, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'pAyudas' => array(self::HAS_MANY, 'PAyuda', 'report_id'),
			'pMenus' => array(self::HAS_MANY, 'PMenu', 'report_id'),
			'reportsFields' => array(self::HAS_MANY, 'ReportsFields', 'report_id'),
			'reportsPermissionsRoles' => array(self::HAS_MANY, 'ReportsPermissionsRoles', 'report_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'report_id' => 'Report',
			'report' => 'Report',
			'description' => 'Description',
			'host' => 'Host',
			'bd' => 'Bd',
			'ppal_table' => 'Ppal Table',
			'field_key' => 'Field Key',
			'sql_query' => 'Sql Query',
			'toolbarfilter' => 'Toolbarfilter',
			'show_title' => 'Show Title',
			'manual' => 'Manual',
			'toppager' => 'Toppager',
			'width' => 'Porcentaje',
			'edit_inline' => 'Edit Inline',
			'edit' => 'Edit',
			'insert_' => 'Insert',
			'delete_' => 'Delete',
			'status' => '1 Activo, 0 Inactivo',
			'creadopor' => 'Create By',
			'fechacreacion' => 'Create Date',
			'modificadopor' => 'Modified By',
			'fechamodificacion' => 'Modified Date',
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

		$criteria->compare('report_id',$this->report_id);
		$criteria->compare('report',$this->report,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('host',$this->host,true);
		$criteria->compare('bd',$this->bd,true);
		$criteria->compare('ppal_table',$this->ppal_table,true);
		$criteria->compare('field_key',$this->field_key,true);
		$criteria->compare('sql_query',$this->sql_query,true);
		$criteria->compare('toolbarfilter',$this->toolbarfilter);
		$criteria->compare('show_title',$this->show_title);
		$criteria->compare('manual',$this->manual);
		$criteria->compare('toppager',$this->toppager);
		$criteria->compare('width',$this->width);
		$criteria->compare('edit_inline',$this->edit_inline);
		$criteria->compare('edit',$this->edit);
		$criteria->compare('insert_',$this->insert_);
		$criteria->compare('delete_',$this->delete_);
		$criteria->compare('status',$this->status);
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
	 * @return Reports the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
