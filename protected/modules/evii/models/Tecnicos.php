<?php

/**
 * This is the model class for table "tecnicos".
 *
 * The followings are the available columns in table 'tecnicos':
 * @property integer $id
 * @property string $nombre
 * @property string $identificacion
 * @property integer $contrato
 * @property integer $ciudad
 * @property string $celular
 * @property string $creadopor
 * @property string $modificadopor
 * @property string $fechamodificacion
 * @property string $fechacreacion
 *
 * The followings are the available model relations:
 * @property Evidencias[] $evidenciases
 * @property Ciudades $ciudad0
 * @property Contratos $contrato0
 */
class Tecnicos extends CActiveRecord
{
    public $foreign_contrato;
    public $foreign_ciudad;
        
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
            array('nombre, identificacion, contrato, foreign_contrato, ciudad, foreign_ciudad, celular, creadopor, modificadopor, fechamodificacion, fechacreacion', 'filter', 'filter'=>'trim'),
            array('contrato, ciudad, celular', 'required'),
            array('contrato, ciudad', 'numerical', 'integerOnly'=>true),
            array('nombre, creadopor, modificadopor', 'length', 'max'=>100),
            array('identificacion, celular', 'length', 'max'=>50),
            array('fechamodificacion, fechacreacion', 'safe'),
            array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'), 
            array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'), 
            array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'), 
            array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'), 
            array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'), 
            array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, identificacion, contrato, ciudad, celular, creadopor, modificadopor, fechamodificacion, fechacreacion', 'safe', 'on'=>'search'),
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
            'ciudad0' => array(self::BELONGS_TO, 'Ciudades', 'ciudad'),
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
           'foreign_ciudad' => 'Ciudad',
            'id' => 'ID',
            'nombre' => 'Nombre',
            'identificacion' => 'Identificacion',
            'contrato' => 'Contrato',
            'ciudad' => 'Ciudad',
            'celular' => 'Celular',
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
    public function search($pagination = array( 'pageSize'=>100))
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('nombre',$this->nombre,true);
        $criteria->compare('identificacion',$this->identificacion,true);
        $criteria->compare('contrato0.contrato',$this->contrato,true);
        $criteria->compare('ciudad0.ciudad',$this->ciudad,true);
        $criteria->compare('celular',$this->celular,true);
        //$criteria->compare('creadopor',$this->creadopor,true);
        //$criteria->compare('modificadopor',$this->modificadopor,true);
        //$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
        //$criteria->compare('fechacreacion',$this->fechacreacion,true);
               $criteria->with = array('evidenciases'=>array('select'=>'id'),'ciudad0'=>array('select'=>'id'),                           'contrato0'=>array('select'=>'id'),                          
               );
                $sort = new CSort();
                $sort->attributes = array('nombre','identificacion');
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
     * @return Tecnicos the static model class
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