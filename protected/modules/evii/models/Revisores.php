<?php

/**
 * This is the model class for table "revisores".
 *
 * The followings are the available columns in table 'revisores':
 * @property integer $id
 * @property string $nombre
 * @property string $cedula
 * @property integer $ciudad
 * @property integer $contrato
 * @property string $creadopor
 * @property string $modificadopor
 * @property string $fechamodificacion
 * @property string $fechacreacion
 *
 * The followings are the available model relations:
 * @property Evidencias[] $evidenciases
 * @property Contratos $contrato0
 * @property Ciudades $ciudad0
 */
class Revisores extends CActiveRecord
{
    public $foreign_ciudad;
    public $foreign_contrato;
        
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'revisores';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, cedula, ciudad, foreign_ciudad, contrato, foreign_contrato, creadopor, modificadopor, fechamodificacion, fechacreacion', 'filter', 'filter'=>'trim'),
            array('nombre, cedula, ciudad', 'required'),
            array('ciudad, contrato', 'numerical', 'integerOnly'=>true),
            array('nombre, cedula, creadopor, modificadopor', 'length', 'max'=>100),
            array('fechamodificacion, fechacreacion', 'safe'),
            array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'), 
            array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'), 
            array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'), 
            array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'), 
            array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'), 
            array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, cedula, ciudad, contrato, creadopor, modificadopor, fechamodificacion, fechacreacion', 'safe', 'on'=>'search'),
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
            'evidenciases' => array(self::HAS_MANY, 'Evidencias', 'revisor'),
            'contrato0' => array(self::BELONGS_TO, 'Contratos', 'contrato'),
            'ciudad0' => array(self::BELONGS_TO, 'Ciudades', 'ciudad'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'foreign_ciudad' => 'Ciudad',
            'foreign_contrato' => 'Contrato',
            'id' => 'ID',
            'nombre' => 'Nombre',
            'cedula' => 'Cedula',
            'ciudad' => 'Ciudad',
            'contrato' => 'Contrato',
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

        $criteria->compare('id',$this->id);
        $criteria->compare('nombre',$this->nombre,true);
        $criteria->compare('cedula',$this->cedula,true);
        $criteria->compare('ciudad0.ciudad',$this->ciudad,true);
        $criteria->compare('contrato0.contrato',$this->contrato,true);
        $criteria->compare('creadopor',$this->creadopor,true);
        $criteria->compare('modificadopor',$this->modificadopor,true);
        $criteria->compare('fechamodificacion',$this->fechamodificacion,true);
        $criteria->compare('fechacreacion',$this->fechacreacion,true);
               $criteria->with = array(                           'evidenciases'=>array('select'=>'id'),                           'contrato0'=>array('select'=>'id'),                           'ciudad0'=>array('select'=>'id'),                          
               );           
                $sort = new CSort();
                $sort->attributes = array('id','nombre','cedula');
                $sort->defaultOrder = array('nombre' => 'ASC');

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
     * @return Revisores the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getContratoName($contrato_id) {
        $tec = Contratos::model()->findByPk($contrato_id);
        if ($tec) {
            return ucwords($tec->contrato);
        }
        return null;
    }

    public function getCiudadName($ciudad_id) {
        $tec = Ciudades::model()->findByPk($ciudad_id);
        if ($tec) {
            return ucwords($tec->ciudad);
        }
        return null;
    }
}