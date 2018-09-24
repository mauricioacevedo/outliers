<?php

/**
 * This is the model class for table "tbl_attachment".
 *
 * The followings are the available columns in table 'tbl_attachment':
 * @property integer $id
 * @property integer $module_id
 * @property string $filename
 * @property integer $filesize
 * @property string $filepath
 * @property string $zipfile
 * @property string $attachedby
 * @property string $attacheddate
 *
 * The followings are the available model relations:
 * @property Modules $module
 */
class Attachment extends CActiveRecord
{
    public $foreign_module_id;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_attachment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module_id, foreign_module_id, filename, filesize, filepath, zipfile, attachedby, attacheddate', 'filter', 'filter'=>'trim'),
			array('module_id, filesize', 'numerical', 'integerOnly'=>true),
			array('filename, filepath, zipfile, attachedby', 'length', 'max'=>255),
			array('attacheddate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module_id, filename, filesize, filepath, zipfile, attachedby, attacheddate', 'safe', 'on'=>'search'),
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
			'module' => array(self::BELONGS_TO, 'Modules', 'module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                                   'foreign_module_id' => 'Module',
                       
			'id' => 'ID',
			'module_id' => 'Module',
			'filename' => 'Filename',
			'filesize' => 'Filesize',
			'filepath' => 'Filepath',
			'zipfile' => 'Zipfile',
			'attachedby' => 'Attachedby',
			'attacheddate' => 'Attacheddate',
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
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('filesize',$this->filesize);
		$criteria->compare('filepath',$this->filepath,true);
		$criteria->compare('zipfile',$this->zipfile,true);
		$criteria->compare('attachedby',$this->attachedby,true);
		$criteria->compare('attacheddate',$this->attacheddate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attachment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
