<?php

/**
 * This is the model class for table "ossconfig".
 *
 * The followings are the available columns in table 'ossconfig':
 * @property integer $id
 * @property string $configname
 * @property string $servertype
 * @property string $user
 * @property string $passwd
 * @property string $params
 * @property string $wsdl
 * @property string $method
 * @property integer $defaultserver
 */
class Ossconfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_ossconfig';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, defaultserver', 'numerical', 'integerOnly'=>true),
			array('configname, servertype, user, passwd, wsdl, method', 'length', 'max'=>255),
			array('params', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, configname, servertype, user, passwd, params, wsdl, method, defaultserver', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'configname' => 'Configname',
			'servertype' => 'Servertype',
			'user' => 'User',
			'passwd' => 'Passwd',
			'params' => 'Params',
			'wsdl' => 'Wsdl',
			'method' => 'Method',
			'defaultserver' => 'Defaultserver',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('configname',$this->configname,true);
		$criteria->compare('servertype',$this->servertype,true);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('passwd',$this->passwd,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('wsdl',$this->wsdl,true);
		$criteria->compare('method',$this->method,true);
		$criteria->compare('defaultserver',$this->defaultserver);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MvcOssconfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
