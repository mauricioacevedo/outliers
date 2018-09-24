<?php
/**
 * Description of EraseRecord
 *
 * @author jnavarrm
 */
class EraseRecord extends CFormModel {
     
     public $processErasable;
     public $startRecord;
     public $finishRecord;
     public $field;
    
    public function rules()
    {
        return array(          
            array('processErasable,field,startRecord,finishRecord', 'required','message'=>'Este campo es obligatorio'),           
        );
    }
    
         /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'processErasable' => 'Seleccione Proceso',
			'startRecord' => 'Ingrese rango inicio',
			'finishRecord' => 'Ingrese rango fin',
			'field' => 'Seleccione Campo',
		);
	}
}
