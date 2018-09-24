<?php

/**
 * This is the model class for table "tbl_users_access".
 *
 * The followings are the available columns in table 'tbl_users_access':
 * @property integer $id
 * @property string $samaccountname
 * @property string $ip
 * @property string $date_access
 * @property string $sessionid
 * @property string $datecreate
 */
class UsersAccess extends CActiveRecord
{
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users_access';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('samaccountname, ip, date_access, sessionid, datecreate', 'filter', 'filter'=>'trim'),
			array('samaccountname, sessionid', 'length', 'max'=>100),
			array('ip', 'length', 'max'=>20),
			array('date_access, datecreate', 'safe'),
                        array('date_access', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => 'insert'),
                        array('datecreate', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => 'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, samaccountname, ip, date_access, sessionid, datecreate', 'safe', 'on'=>'search'),
		);
	}
        
        /**
        * Este método evalua si un usuario tiene una única sessión
        * @return boolean
        */
       public static function uniqueUser() { 
           if (Yii::app()->session['username'] != '' && Yii::app()->session['sessionid'] != '') {
               $modelUsers = Users::model()->find(array(
                                                           'condition' => 'samaccountname=:username AND sessionid=:session',
                                                           'params' => array(':username' => Yii::app()->user->name,
                                                           ':session' => Yii::app()->session['sessionid']
                                                           )));
                                                           
               if (!$modelUsers) {
                   return false;
               }else{
                   return true;
               }
           }
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
                       
			'id' => 'Id',
			'samaccountname' => 'Nombre Usuario',
			'ip' => 'IP',
			'date_access' => 'Fecha de Ingreso',
			'sessionid' => 'Session ID',
			'datecreate' => 'Fecha de Creación',
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
		$criteria->compare('samaccountname',$this->samaccountname,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('date_access',$this->date_access,true);
		$criteria->compare('sessionid',$this->sessionid,true);
		$criteria->compare('datecreate',$this->datecreate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersAccess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
