<?php             
      if(isset(Yii::app()->session['arrayLoadData'])){
       
        #se crean los dataprovides a partir de los vectores retornados del modelo
        $dataProvider             = new CArrayDataProvider(Yii::app()->session['arrayLoadData']);                                                                                  
        #paginacion
        //$dataProvider->pagination = false;   
        $dataProvider->pagination->pageSize = 10;
          $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
              'id' => 'preview',
              // additional javascript options for the dialog plugin
              'options' => array(
                  'title' => 'Contenido del archivo plano',
                  'autoOpen' => true,
                  'width' => '800',
                  'height' => '400',
                  'modal' => true,
                  'closeOnEscape'=> false,
                  'open'=>'js:function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog || ui).hide(); }'
              ),
          ));          
          echo "<span style='color:red;'><cite>Validar columnas y separador...</cite></span>";
                   
          echo "<div id='content'>";
          
          $this->widget('bootstrap.widgets.TbExtendedGridView', array(
                  'type' => 'striped bordered condensed',
                 // 'fixedHeader' => true,
                  'headerOffset' => 40,
                  'responsiveTable' => true,
                  'dataProvider' => $dataProvider,
                   'pager' => array('class' => 'CLinkPager',
                               'cssFile' => false,
                               'header' => false,
                               'firstPageLabel' => 'Primero',
                               'lastPageLabel' => 'Ultimo',
                           ),
              ));
          echo "</div>";
          $form = $this->beginWidget(
                        'bootstrap.widgets.TbActiveForm',
                        array(
                            'id' => 'dataimportfrm',
                            'htmlOptions' => array('class' => 'span4'), // for inset effect
                            'enableClientValidation' => true,
                            'clientOptions' => array('validateOnSubmit' => true)
                        )
                    );          
          echo "<center>";         
            $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'htmlOptions'=>array('name'=>'import'),'label'=>'Importar','type' => 'small', 'size' => 'normal')); 
           echo "&nbsp;&nbsp;";
            $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'htmlOptions'=>array('name'=>'cancel'),'label'=>'Cancelar','type' => 'inverse', 'size' => 'normal'));         
          echo "</center>";
          $this->endWidget();
                    unset($form);
          $this->endWidget('zii.widgets.jui.CJuiDialog');
      }      
?>