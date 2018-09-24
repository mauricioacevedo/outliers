<?php
/**
 * El ejemplo es modificando los valores del arreglo y se retorna al modelo
 * @param array $column
 * @return array
 */
 function test($column){
    
     foreach($column as $key =>$value){
         $newData[$key]         = $value.$value;
     }
     
     return $newData;
}

?>