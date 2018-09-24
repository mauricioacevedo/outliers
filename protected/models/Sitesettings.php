<?php

/**
 * This is the model class for table "tbl_sitesettings".
 *
 * The followings are the available columns in table 'tbl_sitesettings':
 * @property integer $id
 * @property integer $module_id
 * @property string $offline
 * @property string $debug
 * @property string $textoffline
 * @property string $endofflinetime
 * @property string $oauth
 * @property string $bantime
 * @property integer $session_timeout
 * @property integer $show_help
 *
 * The followings are the available model relations:
 * @property Oauth $oauth0
 * @property Modules $module
 */
class Sitesettings extends CActiveRecord
{
    public $foreign_module_id;
    public $foreign_oauth;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sitesettings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module_id, foreign_module_id, offline, debug, textoffline, endofflinetime, oauth, foreign_oauth, bantime, session_timeout, show_help', 'filter', 'filter'=>'trim'),
			array('module_id, oauth', 'required'),
			array('module_id, session_timeout, show_help', 'numerical', 'integerOnly'=>true),
			array('offline, debug', 'length', 'max'=>255),
			array('oauth, bantime', 'length', 'max'=>11),
			array('textoffline, endofflinetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module_id, offline, debug, textoffline, endofflinetime, oauth, bantime, session_timeout, show_help', 'safe', 'on'=>'search'),
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
			'oauth0' => array(self::BELONGS_TO, 'Oauth', 'oauth'),
			'module' => array(self::BELONGS_TO, 'Modules', 'module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_module_id' => 'Module',
                                   'foreign_oauth' => 'Oauth',
                       
			'id' => 'ID',
			'module_id' => 'Module',
			'offline' => 'Offline',
			'debug' => 'Debug',
			'textoffline' => 'Textoffline',
			'endofflinetime' => 'Endofflinetime',
			'oauth' => 'Oauth',
			'bantime' => 'Bantime',
			'session_timeout' => 'En segundos',
			'show_help' => 'Mostrar Ayuda',
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
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('offline',$this->offline,true);
		$criteria->compare('debug',$this->debug,true);
		$criteria->compare('textoffline',$this->textoffline,true);
		$criteria->compare('endofflinetime',$this->endofflinetime,true);
		$criteria->compare('oauth',$this->oauth,true);
		$criteria->compare('bantime',$this->bantime,true);
		$criteria->compare('session_timeout',$this->session_timeout);
		$criteria->compare('show_help',$this->show_help);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sitesettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
