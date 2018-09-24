<?php

/**
 * This is the model class for table "tbl_event_log".
 *
 * The followings are the available columns in table 'tbl_event_log':
 * @property integer $id
 * @property string $eventname
 * @property string $user_exe
 * @property string $content
 * @property string $ctr
 * @property string $acc
 * @property string $dateevent
 * @property string $ipaddress
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 */
class TblEventLog extends CActiveRecord
{
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_event_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eventname, user_exe, content, ctr, acc, dateevent, ipaddress, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('eventname, user_exe, ctr, acc, ipaddress', 'length', 'max'=>255),
			array('creadopor, modificadopor', 'length', 'max'=>100),
			array('content, dateevent, fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, eventname, user_exe, content, ctr, acc, dateevent, ipaddress, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'eventname' => 'Eventname',
			'user_exe' => 'User Exe',
			'content' => 'Content',
			'ctr' => 'Ctr',
			'acc' => 'Acc',
			'dateevent' => 'Dateevent',
			'ipaddress' => 'Ipaddress',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('eventname',$this->eventname,true);
		$criteria->compare('user_exe',$this->user_exe,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('ctr',$this->ctr,true);
		$criteria->compare('acc',$this->acc,true);
		$criteria->compare('dateevent',$this->dateevent,true);
		$criteria->compare('ipaddress',$this->ipaddress,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
                          
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
	 * @return TblEventLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
