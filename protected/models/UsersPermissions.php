<?php

/**
 * This is the model class for table "tbl_users_permissions".
 *
 * The followings are the available columns in table 'tbl_users_permissions':
 * @property integer $id
 * @property string $samaccountname
 * @property integer $action_id
 * @property integer $access
 *
 * The followings are the available model relations:
 * @property ControllerAction $action
 * @property Users $samaccountname0
 */
class UsersPermissions extends CActiveRecord
{
    public $foreign_samaccountname;
    public $foreign_action_id;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users_permissions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('samaccountname, foreign_samaccountname, action_id, foreign_action_id, access', 'filter', 'filter'=>'trim'),
			array('action_id, access', 'numerical', 'integerOnly'=>true),
			array('samaccountname', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, samaccountname, action_id, access', 'safe', 'on'=>'search'),
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
			'action' => array(self::BELONGS_TO, 'ControllerAction', 'action_id'),
			'samaccountname0' => array(self::BELONGS_TO, 'Users', 'samaccountname'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_samaccountname' => 'Samaccountname',
                                   'foreign_action_id' => 'Action',
                       
			'id' => 'ID',
			'samaccountname' => 'Samaccountname',
			'action_id' => 'Action',
			'access' => 'Access',
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
		$criteria->compare('action_id',$this->action_id);
		$criteria->compare('access',$this->access);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersPermissions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
