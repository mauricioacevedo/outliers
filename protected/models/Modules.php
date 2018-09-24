<?php

/**
 * This is the model class for table "modules".
 *
 * The followings are the available columns in table 'modules':
 * @property integer $module_id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property MvcAccess[] $mvcAccesses
 * @property MvcAttachment[] $mvcAttachments
 * @property MvcErrorLog[] $mvcErrorLogs
 * @property MvcImportDataLog[] $mvcImportDataLogs
 * @property MvcMenu[] $mvcMenus
 * @property MvcNotification[] $mvcNotifications
 * @property MvcNoty[] $mvcNoties
 * @property MvcSiteaccess[] $mvcSiteaccesses
 * @property MvcSitesettings[] $mvcSitesettings
 * @property MvcSqlLog[] $mvcSqlLogs
 */
class Modules extends CActiveRecord
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
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('module_id, title', 'safe', 'on'=>'search'),
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
			'mvcAccesses' => array(self::HAS_MANY, 'MvcAccess', 'module_id'),
			'mvcAttachments' => array(self::HAS_MANY, 'MvcAttachment', 'module_id'),
			'mvcErrorLogs' => array(self::HAS_MANY, 'MvcErrorLog', 'module_id'),
			'mvcImportDataLogs' => array(self::HAS_MANY, 'MvcImportDataLog', 'module_id'),
			'mvcMenus' => array(self::HAS_MANY, 'MvcMenu', 'module_id'),
			'mvcNotifications' => array(self::HAS_MANY, 'MvcNotification', 'modulo_id'),
			'mvcNoties' => array(self::HAS_MANY, 'MvcNoty', 'module_id'),
			'mvcSiteaccesses' => array(self::HAS_MANY, 'MvcSiteaccess', 'module_id'),
			'mvcSitesettings' => array(self::HAS_MANY, 'MvcSitesettings', 'module_id'),
			'mvcSqlLogs' => array(self::HAS_MANY, 'MvcSqlLog', 'module_id'),
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

		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MvcModules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
