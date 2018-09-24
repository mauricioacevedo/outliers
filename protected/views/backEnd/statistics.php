<div class="well_content">
<?php 
$this->widget(
    'bootstrap.widgets.TbHighCharts',
    array(
        'options' => array(
            'title' => array(
                'text' => 'Eventos '.date('Y').' (Transacciones)',
                'x' => -20 //center
            ),
            'subtitle' => array(
                'text' => 'Fuente: UNE TELCO',
                'x' -20
            ),
            'xAxis' => array(
                'categories' => array('Enero', 'Febreo', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre')
            ),
            'yAxis' => array(
                'title' => array(
                    'text' =>  'Transacciones',
                ),
                'plotLines' => array(
                    array(
                        'value' => 0,
                        'width' => 1,
                        'color' => '#808080'
                    )
                ),
            ),
            'tooltip' => array(
                'valueSuffix' => 'Trans'
            ),
            'legend' => array(
                'layout' => 'vertical',
                'align' => 'right',
                'verticalAlign' => 'middle',
                'borderWidth' => 0
            ),
            'series' => array(
                array(
                    'name' => 'Edición Datos',
                    'data' => array((int)$eventDate['modifyUserEntries'][1]['count'],
                                    (int)$eventDate['modifyUserEntries'][2]['count'], 
                                    (int)$eventDate['modifyUserEntries'][3]['count'],
                                    (int)$eventDate['modifyUserEntries'][4]['count'],
                                    (int)$eventDate['modifyUserEntries'][5]['count'],
                                    (int)$eventDate['modifyUserEntries'][6]['count'],
                                    (int)$eventDate['modifyUserEntries'][7]['count'],
                                    (int)$eventDate['modifyUserEntries'][8]['count'],
                                    (int)$eventDate['modifyUserEntries'][9]['count'],
                                    (int)$eventDate['modifyUserEntries'][10]['count'],
                                    (int)$eventDate['modifyUserEntries'][11]['count'],
                                    (int)$eventDate['modifyUserEntries'][12]['count'],
                               )
                ),
            )
        ),
        'htmlOptions' => array(
            'style' => 'min-width: 310px; height: 400px; margin: 0 auto'
        )
    )
);
?>
</div>