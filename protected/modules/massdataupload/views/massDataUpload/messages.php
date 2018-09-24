<?php

// Render them all with single `TbAlert`
$this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array('style' => 'text-align:center;'),
    'userComponentId' => 'user',
    'alerts' => array(// configurations per alert type
        // success, info, warning, error or danger
        'info' => array('block' => false,),
        'warning' => array('block' => false,),
        'success' => array('block' => false,),
        'error' => array('block' => false,),
        'danger' => array('block' => false,),
    ),
));
?>

