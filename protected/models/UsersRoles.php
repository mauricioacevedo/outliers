<?php

/**
 * This is the model class for table "tbl_users_roles".
 *
 * The followings are the available columns in table 'tbl_users_roles':
 * @property integer $id
 * @property string $rol
 * @property string $username
 * @property string $creado_por
 * @property string $fecha_creacion
 * @property string $modificado_por
 * @property string $fecha_modificacion
 */
class UsersRoles extends CActiveRecord
{
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rol, username, creado_por, fecha_creacion, modificado_por, fecha_modificacion', 'filter', 'filter'=>'trim'),
			array('rol, username', 'required'),
			array('rol, username, creado_por, modificado_por', 'length', 'max'=>100),
			array('fecha_creacion, fecha_modificacion', 'safe'),
			array('fecha_creacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fecha_modificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fecha_modificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creado_por','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificado_por','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificado_por','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rol, username, creado_por, fecha_creacion, modificado_por, fecha_modificacion', 'safe', 'on'=>'search'),
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
			'rol' => 'Rol',
			'username' => 'Username',
			'creado_por' => 'Creado por',
			'fecha_creacion' => 'Fecha Creación',
			'modificado_por' => 'Modificado Por',
			'fecha_modificacion' => 'Fecha ModificaciÃ³n',
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
		$criteria->compare('rol',$this->rol,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('creado_por',$this->creado_por,true);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('modificado_por',$this->modificado_por,true);
		$criteria->compare('fecha_modificacion',$this->fecha_modificacion,true);
                          
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
	 * @return UsersRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
