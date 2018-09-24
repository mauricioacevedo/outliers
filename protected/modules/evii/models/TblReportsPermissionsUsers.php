<?php

/**
 * This is the model class for table "tbl_reports_permissions_users".
 *
 * The followings are the available columns in table 'tbl_reports_permissions_users':
 * @property integer $id
 * @property integer $report_id
 * @property string $username
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
 * @property TblReports $report
 * @property TblUsers $username0
 */
class TblReportsPermissionsUsers extends CActiveRecord
{
    public $foreign_report_id;
    public $foreign_username;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reports_permissions_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('report_id, foreign_report_id, username, foreign_username, view_, insert_, edit, delete_, excel, pdf, word, txt, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('report_id, view_, insert_, edit, delete_, excel, pdf, word, txt', 'numerical', 'integerOnly'=>true),
			array('username, creadopor, modificadopor', 'length', 'max'=>100),
			array('fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, report_id, username, view_, insert_, edit, delete_, excel, pdf, word, txt, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'report' => array(self::BELONGS_TO, 'TblReports', 'report_id'),
			'username0' => array(self::BELONGS_TO, 'TblUsers', 'username'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_report_id' => 'Report',
                                   'foreign_username' => 'Username',
                       
			'id' => 'ID',
			'report_id' => 'Report',
			'username' => 'Username',
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
	public function search($pagination = array( 'pageSize'=>10))
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('report.report_id',$this->report_id,true);
		$criteria->compare('username0.username',$this->username,true);
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
               $criteria->with = array(               			'report'=>array('select'=>'report'),               			'username0'=>array('select'=>'user_id'),                          
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
	 * @return TblReportsPermissionsUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
