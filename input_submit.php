<?php
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 60); //300 seconds = 5 minutes
error_reporting(E_ALL);

/*
function classLoader ($pClassName) {
    include(__DIR__ . '\Classes\\' . $pClassName . ".php");
}
spl_autoload_register("classLoader");
*/

include 'Classes/SourceHandler.php';
include 'Classes/Comparer.php';
include 'Classes/PHPExcel/IOFactory.php';

set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');

$source_handler = new SourceHandler($_FILES);
$fuentes = $source_handler->getSources();
/*
echo "<pre>";
print_r($fuentes);
echo "</pre>";

die();
*/

$Comp = new Comparer($fuentes);
$missing = $Comp->getMissing();
$voids = $Comp->getVoids();

//echo "<pre>";
//print_r($missing);
//echo "</pre>";


unset($source_handler);
unset($Comp);