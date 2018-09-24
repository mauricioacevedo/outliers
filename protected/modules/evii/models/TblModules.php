<?php

/**
 * This is the model class for table "tbl_modules".
 *
 * The followings are the available columns in table 'tbl_modules':
 * @property integer $module_id
 * @property string $title
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 *
 * The followings are the available model relations:
 * @property TblAttachment[] $tblAttachments
 * @property TblErrorLog[] $tblErrorLogs
 * @property TblImportDataLog[] $tblImportDataLogs
 * @property TblMenu[] $tblMenus
 * @property TblNotification[] $tblNotifications
 * @property TblNoty[] $tblNoties
 * @property TblSitesettings[] $tblSitesettings
 * @property TblSqlLog[] $tblSqlLogs
 */
class TblModules extends CActiveRecord
{
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_modules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('title', 'length', 'max'=>255),
			array('creadopor, modificadopor', 'length', 'max'=>100),
			array('fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('module_id, title, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'tblAttachments' => array(self::HAS_MANY, 'TblAttachment', 'module_id'),
			'tblErrorLogs' => array(self::HAS_MANY, 'TblErrorLog', 'module_id'),
			'tblImportDataLogs' => array(self::HAS_MANY, 'TblImportDataLog', 'module_id'),
			'tblMenus' => array(self::HAS_MANY, 'TblMenu', 'module_id'),
			'tblNotifications' => array(self::HAS_MANY, 'TblNotification', 'modulo_id'),
			'tblNoties' => array(self::HAS_MANY, 'TblNoty', 'module_id'),
			'tblSitesettings' => array(self::HAS_MANY, 'TblSitesettings', 'module_id'),
			'tblSqlLogs' => array(self::HAS_MANY, 'TblSqlLog', 'module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                       
			'module_id' => 'Module',
			'title' => 'Title',
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

		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
               $criteria->with = array(               			'tblAttachments'=>array('select'=>'title'),               			'tblErrorLogs'=>array('select'=>'title'),               			'tblImportDataLogs'=>array('select'=>'title'),               			'tblMenus'=>array('select'=>'title'),               			'tblNotifications'=>array('select'=>'module_id'),               			'tblNoties'=>array('select'=>'title'),               			'tblSitesettings'=>array('select'=>'title'),               			'tblSqlLogs'=>array('select'=>'title'),                          
               );           
                $sort = new CSort();
                $sort->attributes = array('module_id');
                $sort->defaultOrder = array('module_id' => 'DESC');

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
	 * @return TblModules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
