<?php
ini_set('display_errors', 1); 
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 60); //300 seconds = 5 minutes
error_reporting(E_ALL);

include 'Classes/PHPExcel/IOFactory.php';

set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');

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

    $sabre = array();
    $amadeus = array();
    $backoffice = array();
    
    foreach ($files as $key => $file) {
        $name = $file['name'];
        $name = substr($name,0, strpos($name,'.')-1);
        $inputFileName = $file['tmp_name'];

        if ($name === 'sabre') {
            if (($handle = fopen($inputFileName, "r")) !== FALSE) {
                $csvarray = array();
                # Set the parent multidimensional array key to 0.
                $nn = 0;
                //var_dump($handle);
                while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                    # Count the total keys in the row.
                    $c = count($data);
                    # Populate the multidimensional array.
                    for ($x=0;$x<$c;$x++) {
                        $csvarray[$nn][$x] = $data[$x];
                        //var_dump($csvarray);
                    }
                    $nn++;
                }
                array_push($sabre, $csvarray);
                # Close the File.
                fclose($handle);
            }
        }

        if ($name === 'amadeus') {
            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
            array_push($amadeus,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
        }

        if ($name === 'backoffice') {
            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
            array_push($backoffice,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));            
        }        
    }

    echo "<pre>";
    print_r($sabre);
    echo "</pre>";


    /*


    echo "<pre>";
    print_r($files);
    //print_r($_FILES);
    echo "</pre>";
    
    */
}

//echo strpos("sabre1.csv",'.');
//echo substr("sabre1.csv",0, strpos("sabre1.csv",'.'))


?>

<html>
<head>
    <title>Prueba archivos multiples</title>
</head>
<body>
    <form method="post" action="input_submit.php" enctype="multipart/form-data">
        <input name="files[]" id="files" type="file" multiple="" />
        <input type="submit" value="go!!!" >
    </form>
</body>
</html>