<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $samaccountname
 * @property string $employeenumber
 * @property string $departmentnumber
 * @property string $department
 * @property string $profile
 * @property string $cn
 * @property string $givenname
 * @property string $sn
 * @property string $mail
 * @property string $immediate_boss
 * @property string $streetaddress
 * @property string $headquarters
 * @property string $telephonenumber
 * @property string $mobile
 * @property string $passwd
 * @property string $sessionid
 * @property string $last_visit_date
 * @property integer $user_status
 * @property string $location
 * @property integer $pic_profile_id
 *
 * The followings are the available model relations:
 * @property MvcUserstatus $userStatus
 */
class Users extends CActiveRecord
{
    public $file;
    public $validaCampos;
    public $modules;    
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
            array('samaccountname','required', 'on'=> 'updateUser'),
            array('pic_profile_id','required', 'on'=> 'updateProfileImage'),
            
			//array('samaccountname, immediate_boss, immediate_boss_mail, validaCampos, user_status', 'required', 'on'=>'register','message'=>'Este campo es obligatorio'),
//            array('file', 'file', 'types'=> join(',',Yii::app()->generalFunctions->getAllowedExtensionGeneral()), 'message'=>'El archivo es obligatorio', 'on'=>'register' ),
            array('samaccountname', 'unique', 'message'=>'El usuario ya se encuentra registrado', 'on'=>'register'),
            array('modules', 'required', 'message'=>'(Seleccione almenos una opción)', 'on'=>'register'),
            
			array('user_status', 'numerical', 'integerOnly'=>true),
			array('samaccountname, employeenumber, departmentnumber, department, id_profile, cn, mail, givenname, sn, telephonenumber, streetaddress, mobile, department, location, headquarters', 'length', 'max'=>255),
			array('passwd, sessionid, last_visit_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, givenname, sn, samaccountname, employeenumber, departmentnumber, department, id_profile, cn, mail, passwd, sessionid, last_visit_date, user_status, location', 'safe', 'on'=>'search'),
            
           // array('immediate_boss_mail', 'email'),
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
			'userStatus' => array(self::BELONGS_TO, 'Userstatus', 'user_status'),
			'userProfile' => array(self::BELONGS_TO, 'Profiles', 'id_profile'),
//			'userProfileImg' => array(self::BELONGS_TO, 'MvcAttachment', 'pic_profile_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'samaccountname' => 'Usuario de red',
			'employeenumber' => 'Registro',
			'departmentnumber' => 'Centro de actividades',
			'department' => 'Departamento',
			'id_profile' => 'Perfil',
			'cn' => 'Nombre',
			'givenname' => 'Nombre',
			'sn' => 'Apellido',
			'mail' => 'Correo electrónico',
			'immediate_boss' => 'Jefe inmediato',
			'immediate_boss_mail' => 'Correo Jefe inmediato',
			'department' => 'Dependencia',
			'streetaddress' => 'Dirección',
			'headquarters' => 'Sede',
			'telephonenumber' => 'Teléfono',
			'mobile' => 'Celular',
			'file' => 'Seleccionar el archivo "Solicitud de permisos"',
			'modules' => 'Seleccione los módulos donde requiera permisos',
            'location' => 'Ciudad',                                 
			'passwd' => 'Passwd',
			'sessionid' => 'Sessionid',
			'last_visit_date' => 'Fecha última visita',
			'user_status' => 'Estado usuario',
			'pic_profile_id' => 'Imagen de perfil',
		);
	}

    /**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function addErrorUser()
	{
        $this->addError('samaccountname','El usuario es incorrecto');
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
		$criteria->compare('user_status',$this->user_status);
		$criteria->compare('location',$this->location);
//		$criteria->compare('pic_profile_id',$this->pic_profile_id);

		//return new CActiveDataProvider($this, array(
	    //    'pagination' => array(
	    //         'pageSize' => 25,
	    //    ),			
		//	'criteria'=>$criteria,
		//));
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
	 * @return MvcUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
