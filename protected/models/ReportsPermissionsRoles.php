<?php

/**
 * This is the model class for table "tbl_reports_permissions_roles".
 *
 * The followings are the available columns in table 'tbl_reports_permissions_roles':
 * @property integer $id
 * @property integer $report_id
 * @property integer $rol_id
 * @property integer $view_
 * @property integer $insert_
 * @property integer $edit
 * @property integer $delete_
 * @property integer $excel
 * @property integer $pdf
 * @property integer $word
 * @property integer $txt
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 *
 * The followings are the available model relations:
 * @property Reports $report
 * @property Rol $rol
 * @property Users $creadopor0
 * @property Users $modificadopor0
 */
class ReportsPermissionsRoles extends CActiveRecord
{
    public $foreign_report_id;
    public $foreign_rol_id;
    public $foreign_creadopor;
    public $foreign_modificadopor;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reports_permissions_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('report_id, foreign_report_id, rol_id, foreign_rol_id, view_, insert_, edit, delete_, excel, pdf, word, txt, creadopor, foreign_creadopor, fechacreacion, modificadopor, foreign_modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('report_id, rol_id, view_, insert_, edit, delete_, excel, pdf, word, txt', 'numerical', 'integerOnly'=>true),
			array('creadopor, modificadopor', 'length', 'max'=>100),
			array('fechacreacion, fechamodificacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, report_id, rol_id, view_, insert_, edit, delete_, excel, pdf, word, txt, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'report' => array(self::BELONGS_TO, 'Reports', 'report_id'),
			'rol' => array(self::BELONGS_TO, 'Rol', 'rol_id'),
			'creadopor0' => array(self::BELONGS_TO, 'Users', 'creadopor'),
			'modificadopor0' => array(self::BELONGS_TO, 'Users', 'modificadopor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_report_id' => 'Report',
                                   'foreign_rol_id' => 'Rol',
                                   'foreign_creadopor' => 'Creadopor',
                                   'foreign_modificadopor' => 'Modificadopor',
                       
			'id' => 'ID',
			'report_id' => 'Report',
			'rol_id' => 'Rol',
			'view_' => 'View',
			'insert_' => 'Insert',
			'edit' => 'Edit',
			'delete_' => 'Delete',
			'excel' => 'Excel',
			'pdf' => 'Pdf',
			'word' => 'Word',
			'txt' => 'Txt',
			'creadopor' => 'Creadopor',
			'fechacreacion' => 'Fechacreacion',
			'modificadopor' => 'Modificadopor',
			'fechamodificacion' => 'Fechamodificacion',
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
		$criteria->compare('report_id',$this->report_id);
		$criteria->compare('rol_id',$this->rol_id);
		$criteria->compare('view_',$this->view_);
		$criteria->compare('insert_',$this->insert_);
		$criteria->compare('edit',$this->edit);
		$criteria->compare('delete_',$this->delete_);
		$criteria->compare('excel',$this->excel);
		$criteria->compare('pdf',$this->pdf);
		$criteria->compare('word',$this->word);
		$criteria->compare('txt',$this->txt);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReportsPermissionsRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
