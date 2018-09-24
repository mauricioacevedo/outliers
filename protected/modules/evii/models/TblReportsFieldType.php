<?php

/**
 * This is the model class for table "tbl_reports_field_type".
 *
 * The followings are the available columns in table 'tbl_reports_field_type':
 * @property integer $field_type_id
 * @property string $field_type
 * @property string $searchtype
 * @property string $expreg
 * @property string $msg_expreg
 * @property string $comparisons
 *
 * The followings are the available model relations:
 * @property TblReportsFields[] $tblReportsFields
 */
class TblReportsFieldType extends CActiveRecord
{
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reports_field_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('field_type, searchtype, expreg, msg_expreg, comparisons', 'filter', 'filter'=>'trim'),
			array('field_type, msg_expreg', 'length', 'max'=>255),
			array('searchtype', 'length', 'max'=>100),
			array('expreg', 'length', 'max'=>50),
			array('comparisons', 'length', 'max'=>500),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('field_type_id, field_type, searchtype, expreg, msg_expreg, comparisons', 'safe', 'on'=>'search'),
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
			'tblReportsFields' => array(self::HAS_MANY, 'TblReportsFields', 'field_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                       
			'field_type_id' => 'Field Type',
			'field_type' => 'Field Type',
			'searchtype' => 'Searchtype',
			'expreg' => 'Expreg',
			'msg_expreg' => 'Msg Expreg',
			'comparisons' => 'Comparisons',
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

		$criteria->compare('field_type_id',$this->field_type_id);
		$criteria->compare('field_type',$this->field_type,true);
		$criteria->compare('searchtype',$this->searchtype,true);
		$criteria->compare('expreg',$this->expreg,true);
		$criteria->compare('msg_expreg',$this->msg_expreg,true);
		$criteria->compare('comparisons',$this->comparisons,true);
               $criteria->with = array(               			'tblReportsFields'=>array('select'=>'field_type'),                          
               );           
                $sort = new CSort();
                $sort->attributes = array('field_type_id');
                $sort->defaultOrder = array('field_type_id' => 'DESC');

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
	 * @return TblReportsFieldType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
