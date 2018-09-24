<?php

/**
 * This is the model class for table "evidenciasxsolucion".
 *
 * The followings are the available columns in table 'evidenciasxsolucion':
 * @property integer $evidencia_id
 * @property integer $solucion_id
 * @property string $creadopor
 * @property string $modificadopor
 * @property string $fechamodificacion
 * @property string $fechacreacion
 *
 * The followings are the available model relations:
 * @property Solucion $solucion
 * @property Evidencias $evidencia
 */
class Evidenciasxsolucion extends CActiveRecord
{
    public $foreign_evidencia_id;
    public $foreign_solucion_id;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'evidenciasxsolucion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evidencia_id, foreign_evidencia_id, solucion_id, foreign_solucion_id, creadopor, modificadopor, fechamodificacion, fechacreacion', 'filter', 'filter'=>'trim'),
			array('evidencia_id, solucion_id', 'required'),
			array('evidencia_id, solucion_id', 'numerical', 'integerOnly'=>true),
			array('creadopor, modificadopor', 'length', 'max'=>100),
			array('fechamodificacion, fechacreacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('evidencia_id, solucion_id, creadopor, modificadopor, fechamodificacion, fechacreacion', 'safe', 'on'=>'search'),
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
			'solucion' => array(self::BELONGS_TO, 'Solucion', 'solucion_id'),
			'evidencia' => array(self::BELONGS_TO, 'Evidencias', 'evidencia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_evidencia_id' => 'Evidencia',
                                   'foreign_solucion_id' => 'Solucion',
                       
			'evidencia_id' => 'Evidencia',
			'solucion_id' => 'Solucion',
			'creadopor' => 'Creadopor',
			'modificadopor' => 'Modificadopor',
			'fechamodificacion' => 'Fechamodificacion',
			'fechacreacion' => 'Fechacreacion',
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

		$criteria->compare('evidencia.evidencia_id',$this->evidencia_id,true);
		$criteria->compare('solucion.solucion_id',$this->solucion_id,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
               $criteria->with = array(               			'solucion'=>array('select'=>'id'),               			'evidencia'=>array('select'=>'id'),                          
               );           
                $sort = new CSort();
                $sort->attributes = array('evidencia_id');
                $sort->defaultOrder = array('evidencia_id' => 'DESC');

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
	 * @return Evidenciasxsolucion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
