<?php
/**
 * Description of targetToUpload
 *
 * @author jnavarrm
 */
class UploadFile extends CFormModel {
    
     public $filename;
     public $extList        = array('jpg','gif','png');
     public $allowedSize    = 5;
     public $process;     
     public $separator;
     public $deleteHeader;
 
    public function rules()
    {
        return array(          
            array('filename, process,deleteHeader,separator', 'required','message'=>'Este campo es obligatorio'),
            array('filename', 
                    'file', 
                    'types'=>$this->extList,
                    'allowEmpty'=>false,
                    'maxSize' =>((1024*1024)*$this->allowedSize),
                    'tooLarge'=>'El archivo es mas pesado de lo permitido. El peso permitido es ['.$this->allowedSize.' MB]'
                  ),
        );
    }
    
         /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'filename' => 'Seleccione Archivo',
		);
	}
}
