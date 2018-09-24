<?php

/**
 * This is the model class for table "tbl_help".
 *
 * The followings are the available columns in table 'tbl_help':
 * @property integer $help_id
 * @property string $controller
 * @property string $action
 * @property string $title
 * @property string $content
 * @property string $create_by
 * @property string $create_date
 * @property string $modified_by
 * @property string $modified_date
 */
class Help extends CActiveRecord
{
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_help';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('controller, action, title, content, create_by, create_date, modified_by, modified_date', 'filter', 'filter'=>'trim'),
			array('controller, action', 'required'),
			array('controller, action, create_by, modified_by', 'length', 'max'=>100),
			array('title', 'length', 'max'=>300),
			array('content, create_date, modified_date', 'safe'),
			array('create_date','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modified_date','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modified_date','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('create_by','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modified_by','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modified_by','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('help_id, controller, action, title, content, create_by, create_date, modified_by, modified_date', 'safe', 'on'=>'search'),
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
                       
			'help_id' => 'Ayuda ID',
			'controller' => 'Controller',
			'action' => 'Acción',
			'title' => 'Titulo',
			'content' => 'Contenido',
			'create_by' => 'Create By',
			'create_date' => 'Create Date',
			'modified_by' => 'Modified By',
			'modified_date' => 'Modified Date',
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

		$criteria->compare('help_id',$this->help_id);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('modified_date',$this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Help the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
