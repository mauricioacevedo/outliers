<?php

/**
 * This is the model class for table "tbl_import_data_log".
 *
 * The followings are the available columns in table 'tbl_import_data_log':
 * @property integer $id
 * @property integer $module_id
 * @property integer $cod_response
 * @property string $process
 * @property string $import_date
 * @property string $user
 * @property string $content
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 *
 * The followings are the available model relations:
 * @property TblModules $module
 */
class TblImportDataLog extends CActiveRecord
{
    public $foreign_module_id;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_import_data_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module_id, foreign_module_id, cod_response, process, import_date, user, content, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('module_id, cod_response', 'numerical', 'integerOnly'=>true),
			array('process, user', 'length', 'max'=>255),
			array('creadopor, modificadopor', 'length', 'max'=>100),
			array('import_date, content, fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module_id, cod_response, process, import_date, user, content, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'module' => array(self::BELONGS_TO, 'TblModules', 'module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_module_id' => 'Module',
                       
			'id' => 'ID',
			'module_id' => 'Module',
			'cod_response' => 'Cod Response',
			'process' => 'Process',
			'import_date' => 'Import Date',
			'user' => 'User',
			'content' => 'Content',
			'creadopor' => 'Creado por',
			'fechacreacion' => 'Fecha Creación',
			'modificadopor' => 'Modificado Por',
			'fechamodificacion' => 'Fecha Modificación',
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
	public function search($pagination = array( 'pageSize'=>10))
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('module.module_id',$this->module_id,true);
		$criteria->compare('cod_response',$this->cod_response);
		$criteria->compare('process',$this->process,true);
		$criteria->compare('import_date',$this->import_date,true);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
               $criteria->with = array(               			'module'=>array('select'=>'title'),                          
               );           
                $sort = new CSort();
                $sort->attributes = array('id');
                $sort->defaultOrder = array('id' => 'DESC');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>$pagination,
                        'sort' => $sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblImportDataLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
