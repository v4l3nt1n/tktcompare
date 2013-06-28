<?php

/*
$slider_pic=(!empty($_FILES['slider_pic']['name'])) ? time() . "_" .$_FILES['slider_pic']['name']: "";
$slider_pic_tmp=$_FILES['slider_pic']['tmp_name'];


	//valido el mime type del archivo subido
	if(($_FILES['slider_pic']['type']=="image/gif" || 
		$_FILES['slider_pic']['type']=="image/jpg" || 
		$_FILES['slider_pic']['type']=="image/jpeg") &&
		$_FILES['slider_pic']['size']<700000){
			//valido que no haya errores en la carga del archivo
			if($_FILES['slider_pic']['error']>0){
				$error.="Error al subir imagen: ".$_FILES['slider_pic']['error']." -*-*- ";
				$img_count.="1";
			}else{
				//si no hubo ningun tipo de error guardo el file en el directorio de productos
				move_uploaded_file($slider_pic_tmp,"slider".$slider."/slider".$slider."_".$i.".jpg");
			}
	}else{
		$error.="El archivo no es v&aacute;lido"." -*-*- ";;
	}
*/

ini_set('display_errors', 1); 
error_reporting(E_ALL);

function orderFilesArray(&$file_array) {
    $ordered_files = array();
    $file_count = count($file_array['files']['name']);
    $file_keys = array_keys($file_array['files']);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $ordered_files[$i][$key] = $file_array['files'][$key][$i];
        }
    }

    return $ordered_files;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$files = orderFilesArray($_FILES); 

	echo "<pre>";
	print_r($files);
	print_r($_FILES);
	echo "</pre>";
}
?>

<html>
<head>
	<title>Prueba archivos multiples</title>
</head>
<body>
	<form method="post" action="" enctype="multipart/form-data">
		<input name="files[]" id="files" type="file" multiple="" />
		<input type="submit" value="go!!!" >
	</form>
</body>
</html>