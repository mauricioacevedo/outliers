<?php

/**
 * This is the model class for table "tecnicos".
 *
 * The followings are the available columns in table 'tecnicos':
 * @property integer $id
 * @property string $identificacion
 * @property string $nombre
 * @property string $creadopor
 * @property string $modificadopor
 * @property string $fechamodificacion
 * @property string $fechacreacion
 * @property integer $contrato
 *
 * The followings are the available model relations:
 * @property Evidencias[] $evidenciases
 * @property Contratos $contrato0
 */
class Tecnicos extends CActiveRecord
{
    public $foreign_contrato;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tecnicos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identificacion, nombre, creadopor, modificadopor, fechamodificacion, fechacreacion, contrato, foreign_contrato', 'filter', 'filter'=>'trim'),
			array('contrato', 'required'),
			array('contrato', 'numerical', 'integerOnly'=>true),
			array('identificacion', 'length', 'max'=>50),
			array('nombre, creadopor, modificadopor', 'length', 'max'=>100),
			array('fechamodificacion, fechacreacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, identificacion, nombre, creadopor, modificadopor, fechamodificacion, fechacreacion, contrato', 'safe', 'on'=>'search'),
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
			'evidenciases' => array(self::HAS_MANY, 'Evidencias', 'tecnico_id'),
			'contrato0' => array(self::BELONGS_TO, 'Contratos', 'contrato'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_contrato' => 'Contrato',
                       
			'id' => 'ID',
			'identificacion' => 'Identificacion',
			'nombre' => 'Nombre',
			'creadopor' => 'Creadopor',
			'modificadopor' => 'Modificadopor',
			'fechamodificacion' => 'Fechamodificacion',
			'fechacreacion' => 'Fechacreacion',
			'contrato' => 'Contrato',
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
		$criteria->compare('identificacion',$this->identificacion,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('contrato0.contrato',$this->contrato,true);
               $criteria->with = array(               			'evidenciases'=>array('select'=>'id'),               			'contrato0'=>array('select'=>'id'),                          
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
	 * @return Tecnicos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
