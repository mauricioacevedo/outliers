<div>
    <?php
    // Render them all with single `TbAlert`
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true,
        'fade' => true,
        'closeText' => false,//'&times;', // false equals no close link
        'events' => array(),
        'htmlOptions' => array(),
        'userComponentId' => 'user',
        'alerts' => array(// configurations per alert type
            // success, info, warning, error or danger
            'warning' => array('block' => false),
            'notice' => array('block' => false),
            'success' => array('block' => false),
            'info' => array('block' => false),
            'error' => array('block' => false),
        ),
    ));
    ?>
</div>
