<?php
/**
@author Joan Harriman Navarro COMPRIMIR CARGA DE ARCHIVOS
*/
require_once('pclzip/pclzip.lib.php');
$success			 		= '';	
try
 { 
	$rutaNas		 		= "/datos/www/outliers/archivos/";
	/** Asi se llamara el archivo que se va a comprimir */
	$comprimido				= "demopclzip.zip";
	/** Se crea el archivo comprimido vacio en la ruta de la nas elegida*/
 	$archivo 				= new PclZip($rutaNas.$comprimido);
	if(isset($_POST['eliminarTodo']))
	{
		unlink($rutaNas.$comprimido);
	}
	if(isset($_POST['eliminar']))
	{
	  $eliminar = $archivo->delete( PCLZIP_OPT_BY_NAME ,$_POST['eliminar']);

		/* Gestionar error ocurrido (si $archivo->delete() retorna cero a $eliminar) */
		if ( !$eliminar ) {
			echo 'Error al eliminar el archivo....';
		} 
		else 
		{
			echo "Archivo eliminado exitosamente!";
		}
	}
	else
	{
	if(isset($_FILES['demoupload']))
	 {
		$rutaArchivo 		= $rutaNas.basename($_FILES['demoupload']['name']);
		
		if(!file_exists($rutaNas.$comprimido))
		{
			 if(move_uploaded_file($_FILES['demoupload']['tmp_name'], $rutaArchivo)===TRUE)
				{				
					$creacion = $archivo->create($rutaArchivo,
												PCLZIP_OPT_COMMENT, 'PRUEBA DE CARGA DE ARCHIVOS CON PCLZIP',
												PCLZIP_OPT_REMOVE_ALL_PATH);
					if (!$creacion) 
						{
							echo "ERROR al comprimir el archivo...";
							unlink($rutaArchivo);							
						} 
					else 
						{
							echo  "Archivo Creado Exitosamente!";
							 unlink($rutaArchivo);
						}
				}
				else
				{
						 $error	 = "Error al subir el archivo <br>";
					echo $error	.= "Razon: Permisos insuficientes en el directorio";
				}
		}
		else
		{
			 if(move_uploaded_file($_FILES['demoupload']['tmp_name'], $rutaArchivo)===TRUE)
				{				
					$agregar = $archivo->add($rutaArchivo);
					if (!$agregar) 
						{
							echo "ERROR al adicionar el archivo...";		
							unlink($rutaArchivo);													
						} 
					else 
						{
							echo "Archivo agregado con exito!";
							 unlink($rutaArchivo);
						}
				}
				else
				{
						 $error	 = "Error al subir el archivo <br>";
					echo $error	.= "Razon: Permisos insuficientes en el directorio";
				}
		}
	 }
	}
 }
 catch (Exception $e)
 {
	echo $e->getMessage();
 }
?>
<script>
 function forzarDescarga(file,path)
 {
 	window.location.href="?file="+file+"&dir="+path;
 }
</script>
<form enctype="multipart/form-data" method="post" action="?">
<fieldset><legend><h2>EJEMPLO CARGA DE ARCHIVOS COMPRIMIDOS CON PCLZIP</h2></legend>
  <label>Crear o agregar mas archivos: </label>
  <input name="demoupload" type="file" />  
  <input type ="submit" value="Cargar"> 	
 </fieldset> 
 </form>
 <?php
$listado = $archivo->listContent();
/* Gestionar error ocurrido (si $archivo->listContent() retorna cero a $listado) */
	if ( !$listado ) 
	{
		die("<br>NO se pueden listar los archivos, porque no existe la carpeta comprimida en el repositorio");		
	} 
	else 
	{
		 echo "Archivo listado:<br /><br />";
	}
echo '<form method="post" action="?">';	
	echo "<table border='1'>";
	
	/* Recorremos en un bucle 'for' el array de archivos que nos dio $archivo->listContent() */
for ($i=0 ; $i<sizeof($listado) ; $i++) {	
    /* Recorremos el array de las propiedades del archivo que se analiza en cada ciclo */
    for ( reset( $listado[$i] ) ; $key = key( $listado[$i] ) ; next( $listado[$i] ) ) 
	{
	 echo "<th>".$key."</th>";
    }
	echo "<tr>";
	for ( reset( $listado[$i] ) ; $key = key( $listado[$i] ) ; next( $listado[$i] ) ) 
	{
	  echo "<td>".$listado[$i][$key]."</td>";	
    }
	echo "<td><input type='submit' value='eliminar'>
		  <input type='hidden' name='eliminar' value='".$listado[$i]['filename']."'></td></tr>";
}
echo "</table></form>";

echo '<form name="frmtodo" method="post" action="?">';
echo '<input type="submit" value="Eliminar Todo">';
echo '<input type="hidden" name="eliminarTodo" value="eliminarTodo">';
echo '</form>';
echo "DESCARGAR: <a href ='#' onclick=\"forzarDescarga('".$comprimido."','".$rutaNas."');\">
	   <img alt='Adjunto' src='Attach.png'></a>";

/**
 * Forzar la descarga de archivos
 */
$file 		= isset($_GET['file'])? $_GET['file']: NULL;
$dir 		= isset($_GET['dir'])?$_GET['dir']:NULL;

if(!empty($file) && !empty($dir))
{
	fileDownload($file, $dir);
}

if(!empty($file))
{
	header("Content-type: application/force-download");
	header('Content-Disposition: inline; filename="' . $dir.$file . '"');
	header("Content-Transfer-Encoding: Binary");
	header("Content-length: ".filesize($dir.$file));
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . $file . '"');
	readfile("$dir$file");
}
 ?>