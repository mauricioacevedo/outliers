<?php             
      if(count($logData)){    
        #se crean los dataprovides a partir de los vectores retornados del modelo
        $dataProvider             = new CArrayDataProvider($logData);                                                                                  
        #paginacion
        //$dataProvider->pagination = false;   
        $dataProvider->pagination->pageSize = 10;
        $dataProvider->sort->attributes     = array('Proceso','Fecha','Usuario','Contenido');
          
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
      }      
?>