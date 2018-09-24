<?php
$folderPath     = array('DIRPATH'=>array(DIRPATH.'/index.php',
                                         DIRPATH.'/assets/',
                                         DIRPATH.'/protected/runtime/',),
                         'BASEPATH'=>array('/index.php',
                                           '/assets',
                                           '/protected/runtime/')
                        );

$folderPermission = array(fileperms($folderPath['DIRPATH'][0]),
                          fileperms($folderPath['DIRPATH'][1]),
                          fileperms($folderPath['DIRPATH'][2]),
                            );

$data           = array();
for($i=0;$i<count($folderPermission);$i++){
if (($folderPermission & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
} elseif (($folderPermission[$i] & 0xA000) == 0xA000) {
    // Enlace Simbólico
    $info = 'l';
} elseif (($folderPermission[$i] & 0x8000) == 0x8000) {
    // Regular
    $info = '-';
} elseif (($folderPermission[$i] & 0x6000) == 0x6000) {
    // Especial Bloque
    $info = 'b';
} elseif (($folderPermission[$i] & 0x4000) == 0x4000) {
    // Directorio
    $info = 'd';
} elseif (($folderPermission[$i] & 0x2000) == 0x2000) {
    // Especial Carácter
    $info = 'c';
} elseif (($folderPermission[$i] & 0x1000) == 0x1000) {
    // Tubería FIFO
    $info = 'p';
} else {
    // Desconocido
    $info = 'u';
}

// Propietario
$info .= (($folderPermission[$i] & 0x0100) ? 'r' : '-');
$info .= (($folderPermission[$i] & 0x0080) ? 'w' : '-');
$info .= (($folderPermission[$i] & 0x0040) ?
            (($folderPermission[$i] & 0x0800) ? 's' : 'x' ) :
            (($folderPermission[$i] & 0x0800) ? 'S' : '-'));



// Grupo
$info .= (($folderPermission[$i] & 0x0020) ? 'r' : '-');
$info .= (($folderPermission[$i] & 0x0010) ? 'w' : '-');
$info .= (($folderPermission[$i] & 0x0008) ?
            (($folderPermission[$i] & 0x0400) ? 's' : 'x' ) :
            (($folderPermission[$i] & 0x0400) ? 'S' : '-'));

// Mundo
$info .= (($folderPermission[$i] & 0x0004) ? 'r' : '-');
$info .= (($folderPermission[$i] & 0x0002) ? 'w' : '-');
$info .= (($folderPermission[$i] & 0x0001) ?
            (($folderPermission[$i] & 0x0200) ? 't' : 'x' ) :
            (($folderPermission[$i] & 0x0200) ? 'T' : '-'));

$data[] = array_merge($data,array("PERMISSION"=>$info,"DIRPATH"=>$folderPath['BASEPATH'][$i]));
$info = "";
}

echo "<h5>PERMISOS NECESARIOS PARA EL FUNCIONAMIENTO DEL SITIO</h5>"
    ."<br><small>Verifique que tiene permisos de escritura en las rutas que se "
    . "listan mas abajo. Si no cumple, no puede hacer uso correcto de las "
    . "otras pestañas de instalación.</small>"
    . "<hr>";
echo " d => es directorio<br>"
    . " s => es un socket<br>"
    . " l => es un enlace simb&oacute;lico<br>"
    . " - => es regular<br>"
    . " u => es desconocido<br>"
    . " r => lectura<br>"
    . " w => escritura<br>"
    . " x => ejecuci&oacute;n";

$dataProvider   = new CArrayDataProvider($data);
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type'=>'striped bordered condensed',
    'responsiveTable' => true,
    'dataProvider'=>$dataProvider,    
    'pager' => array('class' => 'CLinkPager',
                       'cssFile' => false,
                       'header' => false,
                       'firstPageLabel' => 'Primero',
                       'lastPageLabel' => 'Ultimo',
                   ),
    'columns'=>array(      
        array('name'=>'DIRPATH', 'header'=>'Ruta'),
        array('name'=>'PERMISSION', 'header'=>'Permisos'),
        array('header'=>'PASA PRUEBA','value'=>'(strpos(substr($data[\'PERMISSION\'], 0, 4), \'w\')!=false '
               . '&& strpos(substr($data[\'PERMISSION\'], 4, 7), \'w\')!=false)? ("<span class=\'icon-ok\'></span>") : ("<span class=\'icon-remove\'></span>")',
              'type'=>'raw',
              'htmlOptions'=>array('style'=>'width:20px;')
        ),
    ),
));