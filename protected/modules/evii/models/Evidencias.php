<?php

/**
 * This is the model class for table "evidencias".
 *
 * The followings are the available columns in table 'evidencias':
 * @property integer $id
 * @property string $pedido
 * @property string $documento_cliente
 * @property integer $producto
 * @property string $fecha_cerrado
 * @property integer $tecnico_id
 * @property integer $revisor
 * @property integer $plaza
 * @property integer $diagnostico_tecnico
 * @property integer $hallazgos
 * @property integer $acciondemejora
 * @property integer $motivo_outlier
 * @property integer $solucion
 * @property string $observaciones
 * @property integer $responsable_dano
 * @property string $descuento
 * @property string $rere
 * @property integer $lider_de_plaza
 * @property string $historico_pedido
 * @property string $creadopor
 * @property string $modificadopor
 * @property string $fechamodificacion
 * @property string $fechacreacion
 *
 * The followings are the available model relations:
 * @property Solucion $solucion0
 * @property Diagnosticotecnico $diagnosticoTecnico
 * @property Hallazgos $hallazgos0
 * @property Lideresdeplaza $liderDePlaza
 * @property Plazas $plaza0
 * @property Productos $producto0
 * @property Responsabledano $responsableDano
 * @property Revisores $revisor0
 * @property Tecnicos $tecnico
 * @property Motivo $motivoOutlier
 * @property Evidenciasxdiagnosticotecnico[] $evidenciasxdiagnosticotecnicos
 * @property Evidenciasxhallazgos[] $evidenciasxhallazgoses
 * @property Evidenciasxmotivo[] $evidenciasxmotivos
 * @property Evidenciasxsolucion[] $evidenciasxsolucions
 * @property ImagenesAntes[] $imagenesAntes
 * @property ImagenesDespues[] $imagenesDespues
 */
class Evidencias extends CActiveRecord
{
    public $foreign_producto;
    public $foreign_tecnico_id;
    public $foreign_revisor;
    public $foreign_plaza;
    public $foreign_diagnostico_tecnico;
    public $foreign_hallazgos;
    public $foreign_motivo_outlier;
    public $foreign_solucion;
    public $foreign_responsable_dano;
    public $foreign_lider_de_plaza;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'evidencias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pedido, documento_cliente, producto, foreign_producto, fecha_cerrado, tecnico_id, foreign_tecnico_id, revisor, foreign_revisor, plaza, foreign_plaza, diagnostico_tecnico, foreign_diagnostico_tecnico, hallazgos, foreign_hallazgos, motivo_outlier, foreign_motivo_outlier, solucion, foreign_solucion, acciondemejora, observaciones, responsable_dano, foreign_responsable_dano, descuento, rere, lider_de_plaza, foreign_lider_de_plaza, historico_pedido, creadopor, modificadopor, fechamodificacion, fechacreacion', 'filter', 'filter'=>'trim'),
			array('producto, tecnico_id, revisor, plaza, diagnostico_tecnico, hallazgos, motivo_outlier, solucion, responsable_dano, lider_de_plaza', 'numerical', 'integerOnly'=>true),
			array('pedido, creadopor, modificadopor', 'length', 'max'=>100),

			//array('date', 'type', 'type'=>'date', 'dateFormat'=>'dd-MM-yy'),
			array('documento_cliente', 'length', 'max'=>255),
			array('descuento, rere', 'length', 'max'=>45),
			array('historico_pedido', 'length', 'max'=>3000),
			array('fecha_cerrado, observaciones, fechamodificacion, fechacreacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pedido, documento_cliente, producto, fecha_cerrado, tecnico_id, revisor, plaza, diagnostico_tecnico, hallazgos, motivo_outlier, solucion, acciondemejora, observaciones, responsable_dano, descuento, rere, lider_de_plaza, historico_pedido, creadopor, modificadopor, fechamodificacion, fechacreacion', 'safe', 'on'=>'search'),
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
			'solucion0' => array(self::BELONGS_TO, 'Solucion', 'solucion'),
			'diagnosticoTecnico' => array(self::BELONGS_TO, 'Diagnosticotecnico', 'diagnostico_tecnico'),
			'hallazgos0' => array(self::BELONGS_TO, 'Hallazgos', 'hallazgos'),
			'liderDePlaza' => array(self::BELONGS_TO, 'Lideresdeplaza', 'lider_de_plaza'),
			'plaza0' => array(self::BELONGS_TO, 'Plazas', 'plaza'),
			'producto0' => array(self::BELONGS_TO, 'Productos', 'producto'),
			'responsableDano' => array(self::BELONGS_TO, 'Responsabledano', 'responsable_dano'),
			'revisor0' => array(self::BELONGS_TO, 'Revisores', 'revisor'),
			'tecnico' => array(self::BELONGS_TO, 'Tecnicos', 'tecnico_id'),
			'motivoOutlier' => array(self::BELONGS_TO, 'Motivo', 'motivo_outlier'),
			'evidenciasxdiagnosticotecnicos' => array(self::HAS_MANY, 'Evidenciasxdiagnosticotecnico', 'evidencia_id'),
			'evidenciasxhallazgoses' => array(self::HAS_MANY, 'Evidenciasxhallazgos', 'evidencia_id'),
			'evidenciasxmotivos' => array(self::HAS_MANY, 'Evidenciasxmotivo', 'evidencia_id'),
			'evidenciasxsolucions' => array(self::HAS_MANY, 'Evidenciasxsolucion', 'evidencia_id'),
			'imagenesAntes' => array(self::HAS_MANY, 'ImagenesAntes', 'evidencia_id'),
			'imagenesDespues' => array(self::HAS_MANY, 'ImagenesDespues', 'evidencia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_producto' => 'Producto',
                                   'foreign_tecnico_id' => 'Tecnico',
                                   'foreign_revisor' => 'Revisor',
                                   'foreign_plaza' => 'Plaza',
                                   'foreign_diagnostico_tecnico' => 'Diagnostico Tecnico',
                                   'foreign_hallazgos' => 'Hallazgos',
                                   'foreign_motivo_outlier' => 'Motivo Outlier',
                                   'foreign_solucion' => 'Solucion',
                                   'foreign_responsable_dano' => 'Responsable Dano',
                                   'foreign_lider_de_plaza' => 'Lider De Plaza',
                       
			'id' => 'ID',
			'pedido' => 'Pedido',
			'documento_cliente' => 'Documento Cliente',
			'producto' => 'Producto',
			'fecha_cerrado' => 'Fecha Cerrado',
			'tecnico_id' => 'Tecnico',
			'revisor' => 'Revisor',
			'plaza' => 'Plaza',
			'diagnostico_tecnico' => 'Diagnostico Tecnico',
			'hallazgos' => 'Hallazgos',
			'motivo_outlier' => 'Motivo Outlier',
			'solucion' => 'Solucion',
			'acciondemejora' => 'Accion De Mejora',
			'observaciones' => 'Observaciones',
			'responsable_dano' => 'Responsable Dano',
			'descuento' => 'Descuento',
			'rere' => 'Rere',
			'lider_de_plaza' => 'Lider De Plaza',
			'historico_pedido' => 'Historico Pedido',
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
		$criteria->compare('pedido',$this->pedido,true);
		$criteria->compare('documento_cliente',$this->documento_cliente,true);
		$criteria->compare('producto0.producto',$this->producto,true);
		$criteria->compare('fecha_cerrado',$this->fecha_cerrado,true);
		$criteria->compare('tecnico.tecnico_id',$this->tecnico_id,true);
		$criteria->compare('revisor0.revisor',$this->revisor,true);
		$criteria->compare('plaza0.plaza',$this->plaza,true);
		$criteria->compare('diagnosticoTecnico.diagnostico_tecnico',$this->diagnostico_tecnico,true);
		$criteria->compare('hallazgos0.hallazgos',$this->hallazgos,true);
		$criteria->compare('motivoOutlier.motivo_outlier',$this->motivo_outlier,true);
		$criteria->compare('solucion0.solucion',$this->solucion,true);
		$criteria->compare('acciondemejora',$this->acciondemejora,true);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('responsableDano.responsable_dano',$this->responsable_dano,true);
		$criteria->compare('descuento',$this->descuento,true);
		$criteria->compare('rere',$this->rere,true);
		$criteria->compare('liderDePlaza.lider_de_plaza',$this->lider_de_plaza,true);
		$criteria->compare('historico_pedido',$this->historico_pedido,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
               /*$criteria->with = array(               			'solucion0'=>array('select'=>'id'),               			'diagnosticoTecnico'=>array('select'=>'id'),               			'hallazgos0'=>array('select'=>'id'),               			'liderDePlaza'=>array('select'=>'id'),               			'plaza0'=>array('select'=>'id'),               			'producto0'=>array('select'=>'id'),               			'responsableDano'=>array('select'=>'id'),               			'revisor0'=>array('select'=>'id'),               			'tecnico'=>array('select'=>'id'),               			'motivoOutlier'=>array('select'=>'id'),               			'evidenciasxdiagnosticotecnicos'=>array('select'=>'id'),               			'evidenciasxhallazgoses'=>array('select'=>'id'),               			'evidenciasxmotivos'=>array('select'=>'id'),               			'evidenciasxsolucions'=>array('select'=>'id'),               			'imagenesAntes'=>array('select'=>'id'),               			'imagenesDespues'=>array('select'=>'id'),                          
               );*/
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
	 * @return Evidencias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function getTecnicoName($tecnico_id) {
                $tec = Tecnicos::model()->findByPk($tecnico_id);
                if ($tec) {
                        return ucwords($tec->nombre);
                }
                return null;
        }

        public function getProducto($producto_id) {
                $prod = Productos::model()->findByPk($producto_id);
                if ($prod) {
                        return ucwords($prod->producto);
                }
                return null;
        }

	public function beforeSave() {
    		$this->fecha_cerrado = date('Y-m-d', strtotime( $this->fecha_cerrado));
    		return parent::beforeSave();
	}
}
