<?php

/**
 * This is the model class for table "tbl_users".
 *
 * The followings are the available columns in table 'tbl_users':
 * @property integer $user_id
 * @property string $givenname
 * @property string $sn
 * @property string $samaccountname
 * @property string $employeenumber
 * @property string $departmentnumber
 * @property string $department
 * @property string $id_profile
 * @property string $cn
 * @property string $mail
 * @property string $passwd
 * @property string $sessionid
 * @property string $last_visit_date
 * @property integer $user_status
 * @property string $immediate_boss
 * @property string $immediate_boss_mail
 * @property string $streetaddress
 * @property string $headquarters
 * @property string $telephonenumber
 * @property string $mobile
 * @property string $location
 * @property integer $module_id
 * @property integer $pic_profile_id
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 *
 * The followings are the available model relations:
 * @property TblReportsPermissionsRoles[] $tblReportsPermissionsRoles
 * @property TblReportsPermissionsRoles[] $tblReportsPermissionsRoles1
 * @property TblReportsPermissionsUsers[] $tblReportsPermissionsUsers
 * @property TblUserstatus $userStatus
 * @property TblUsersPermissions[] $tblUsersPermissions
 */
class TblUsers extends CActiveRecord
{
    public $foreign_user_status;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('givenname, sn, samaccountname, employeenumber, departmentnumber, department, id_profile, cn, mail, passwd, sessionid, last_visit_date, user_status, foreign_user_status, immediate_boss, immediate_boss_mail, streetaddress, headquarters, telephonenumber, mobile, location, module_id, pic_profile_id, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('samaccountname', 'required'),
			array('user_status, module_id, pic_profile_id', 'numerical', 'integerOnly'=>true),
			array('givenname, sn, samaccountname, employeenumber, departmentnumber, department, cn, mail, immediate_boss, immediate_boss_mail, streetaddress, headquarters, telephonenumber, mobile, location', 'length', 'max'=>255),
			array('id_profile', 'length', 'max'=>11),
			array('creadopor, modificadopor', 'length', 'max'=>100),
			array('passwd, sessionid, last_visit_date, fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, givenname, sn, samaccountname, employeenumber, departmentnumber, department, id_profile, cn, mail, passwd, sessionid, last_visit_date, user_status, immediate_boss, immediate_boss_mail, streetaddress, headquarters, telephonenumber, mobile, location, module_id, pic_profile_id, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'tblReportsPermissionsRoles' => array(self::HAS_MANY, 'TblReportsPermissionsRoles', 'creadopor'),
			'tblReportsPermissionsRoles1' => array(self::HAS_MANY, 'TblReportsPermissionsRoles', 'modificadopor'),
			'tblReportsPermissionsUsers' => array(self::HAS_MANY, 'TblReportsPermissionsUsers', 'username'),
			'userStatus' => array(self::BELONGS_TO, 'TblUserstatus', 'user_status'),
			'tblUsersPermissions' => array(self::HAS_MANY, 'TblUsersPermissions', 'samaccountname'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_user_status' => 'User Status',
                       
			'user_id' => 'User',
			'givenname' => 'Givenname',
			'sn' => 'Sn',
			'samaccountname' => 'Samaccountname',
			'employeenumber' => 'Employeenumber',
			'departmentnumber' => 'Departmentnumber',
			'department' => 'Department',
			'id_profile' => 'Id Profile',
			'cn' => 'Cn',
			'mail' => 'Mail',
			'passwd' => 'Passwd',
			'sessionid' => 'Sessionid',
			'last_visit_date' => 'Last Visit Date',
			'user_status' => 'User Status',
			'immediate_boss' => 'Immediate Boss',
			'immediate_boss_mail' => 'Immediate Boss Mail',
			'streetaddress' => 'Streetaddress',
			'headquarters' => 'Headquarters',
			'telephonenumber' => 'Telephonenumber',
			'mobile' => 'Mobile',
			'location' => 'Location',
			'module_id' => 'Module',
			'pic_profile_id' => 'Pic Profile',
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
	public function search($pagination = array( 'pageSize'=>100))
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('givenname',$this->givenname,true);
		$criteria->compare('sn',$this->sn,true);
		$criteria->compare('samaccountname',$this->samaccountname,true);
		$criteria->compare('employeenumber',$this->employeenumber,true);
		$criteria->compare('departmentnumber',$this->departmentnumber,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('id_profile',$this->id_profile,true);
		$criteria->compare('cn',$this->cn,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('passwd',$this->passwd,true);
		$criteria->compare('sessionid',$this->sessionid,true);
		$criteria->compare('last_visit_date',$this->last_visit_date,true);
		$criteria->compare('userStatus.user_status',$this->user_status,true);
		$criteria->compare('immediate_boss',$this->immediate_boss,true);
		$criteria->compare('immediate_boss_mail',$this->immediate_boss_mail,true);
		$criteria->compare('streetaddress',$this->streetaddress,true);
		$criteria->compare('headquarters',$this->headquarters,true);
		$criteria->compare('telephonenumber',$this->telephonenumber,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('pic_profile_id',$this->pic_profile_id);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
               $criteria->with = array(               			'tblReportsPermissionsRoles'=>array('select'=>'user_id'),               			'tblReportsPermissionsRoles1'=>array('select'=>'user_id'),               			'tblReportsPermissionsUsers'=>array('select'=>'user_id'),               			'userStatus'=>array('select'=>'id'),               			'tblUsersPermissions'=>array('select'=>'user_id'),                          
               );           
                $sort = new CSort();
                $sort->attributes = array('user_id');
                $sort->defaultOrder = array('user_id' => 'DESC');

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
	 * @return TblUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
