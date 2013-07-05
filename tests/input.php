<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

//funcion que corta el string de derecha a izquierda dejando el largo especificado en $length
function rpad($string,$length)
{
    $rpadded = substr($string, strlen($string)-$length,$length);
    return $rpadded;
}

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

//echo strpos("sabre1.csv",'.');
echo substr("sabre1.csv",0, strpos("sabre1.csv",'.'))


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