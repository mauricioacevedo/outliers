<?php

/**
 * This is the model class for table "tbl_menu".
 *
 * The followings are the available columns in table 'tbl_menu':
 * @property integer $id
 * @property integer $module_id
 * @property integer $parent_id
 * @property string $menu_name
 * @property string $menu_type
 * @property string $order_menu
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $icon_height
 * @property string $icon_width
 * @property string $idbtn
 * @property string $param
 * @property string $class
 * @property string $style
 * @property string $title
 * @property string $langCode
 * @property string $dir
 * @property string $href
 * @property string $hrefLang
 * @property string $type
 * @property string $rel
 * @property string $rev
 * @property string $shape
 * @property string $coords
 * @property string $target
 * @property string $tabIndex
 * @property string $accessKey
 * @property string $events
 * @property string $publish
 * @property string $access
 * @property string $link
 * @property string $action
 * @property string $controller
 * @property string $creadopor
 * @property string $fechacreacion
 * @property string $modificadopor
 * @property string $fechamodificacion
 *
 * The followings are the available model relations:
 * @property TblModules $module
 */
class TblMenu extends CActiveRecord
{
    public $foreign_module_id;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module_id, foreign_module_id, parent_id, menu_name, menu_type, order_menu, name, description, icon, icon_height, icon_width, idbtn, param, class, style, title, langCode, dir, href, hrefLang, type, rel, rev, shape, coords, target, tabIndex, accessKey, events, publish, access, link, action, controller, creadopor, fechacreacion, modificadopor, fechamodificacion', 'filter', 'filter'=>'trim'),
			array('module_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('menu_name, menu_type, order_menu, name, description, icon, icon_height, icon_width, idbtn, param, class, style, title, langCode, dir, href, hrefLang, type, rel, rev, shape, coords, target, tabIndex, accessKey, events, publish, access, link, action, controller', 'length', 'max'=>255),
			array('creadopor, modificadopor', 'length', 'max'=>100),
			array('fechacreacion, fechamodificacion', 'safe'),
			array('fechacreacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('fechamodificacion','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false, 'on'=>'update'),
			array('creadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>null, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('modificadopor','default', 'value'=>Yii::app()->user->name, 'setOnEmpty'=>false, 'on'=>'update'),// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module_id, parent_id, menu_name, menu_type, order_menu, name, description, icon, icon_height, icon_width, idbtn, param, class, style, title, langCode, dir, href, hrefLang, type, rel, rev, shape, coords, target, tabIndex, accessKey, events, publish, access, link, action, controller, creadopor, fechacreacion, modificadopor, fechamodificacion', 'safe', 'on'=>'search'),
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
			'module' => array(self::BELONGS_TO, 'TblModules', 'module_id'),
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
			'parent_id' => 'Parent',
			'menu_name' => 'Menu Name',
			'menu_type' => 'Menu Type',
			'order_menu' => 'Order Menu',
			'name' => 'Nombre del Menu',
			'description' => 'Alias del Menu',
			'icon' => 'Nom y ext de la Img que se cargo',
			'icon_height' => 'Altura (numero)',
			'icon_width' => 'Ancho (numero)',
			'idbtn' => 'Idbtn',
			'param' => 'Param',
			'class' => 'por defecto pagina',
			'style' => 'por defecto ',
			'title' => 'Link por defecto null',
			'langCode' => 'Lang Code',
			'dir' => 'Dir',
			'href' => 'Href',
			'hrefLang' => 'Href Lang',
			'type' => 'Type',
			'rel' => 'Rel',
			'rev' => 'Rev',
			'shape' => 'Shape',
			'coords' => 'Coords',
			'target' => 'Target',
			'tabIndex' => 'Tab Index',
			'accessKey' => 'Access Key',
			'events' => 'Events',
			'publish' => 'Por defecto falso',
			'access' => 'Por defecto falso',
			'link' => 'Link',
			'action' => 'Action',
			'controller' => 'Controller',
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
		$criteria->compare('module.module_id',$this->module_id,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('menu_type',$this->menu_type,true);
		$criteria->compare('order_menu',$this->order_menu,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('icon_height',$this->icon_height,true);
		$criteria->compare('icon_width',$this->icon_width,true);
		$criteria->compare('idbtn',$this->idbtn,true);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('style',$this->style,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('langCode',$this->langCode,true);
		$criteria->compare('dir',$this->dir,true);
		$criteria->compare('href',$this->href,true);
		$criteria->compare('hrefLang',$this->hrefLang,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('rel',$this->rel,true);
		$criteria->compare('rev',$this->rev,true);
		$criteria->compare('shape',$this->shape,true);
		$criteria->compare('coords',$this->coords,true);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('tabIndex',$this->tabIndex,true);
		$criteria->compare('accessKey',$this->accessKey,true);
		$criteria->compare('events',$this->events,true);
		$criteria->compare('publish',$this->publish,true);
		$criteria->compare('access',$this->access,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
               $criteria->with = array(               			'module'=>array('select'=>'title'),                          
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
	 * @return TblMenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
