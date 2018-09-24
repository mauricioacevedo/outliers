<?php

/**
 * This is the model class for table "tbl_notification".
 *
 * The followings are the available columns in table 'tbl_notification':
 * @property string $id
 * @property string $user
 * @property string $name
 * @property string $mail
 * @property string $estado
 * @property integer $modulo_id
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 *
 * The followings are the available model relations:
 * @property TblModules $modulo
 */
class TblNotification extends CActiveRecord
{
    public $foreign_modulo_id;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user, name, mail, estado, modulo_id, foreign_modulo_id, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('user', 'required'),
			array('modulo_id', 'numerical', 'integerOnly'=>true),
			array('user, name, mail', 'length', 'max'=>255),
			array('estado', 'length', 'max'=>10),
			array('creadopor, modificadopor', 'length', 'max'=>100),
			array('fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user, name, mail, estado, modulo_id, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'modulo' => array(self::BELONGS_TO, 'TblModules', 'modulo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_modulo_id' => 'Modulo',
                       
			'id' => 'ID',
			'user' => 'User',
			'name' => 'Name',
			'mail' => 'Mail',
			'estado' => 'Estado',
			'modulo_id' => 'Modulo',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('modulo.modulo_id',$this->modulo_id,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
               $criteria->with = array(               			'modulo'=>array('select'=>'module_id'),                          
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
	 * @return TblNotification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
