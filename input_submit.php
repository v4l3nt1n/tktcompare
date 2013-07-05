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
$Comp = new Comparer($fuentes);
$missing = $Comp->getMissing();

/*
echo "<pre>";
print_r($missing);
echo "</pre>";
//*/
/*
echo "<table border='1'>";
foreach ($missing['missing_sabre'] as $key => $ticket) {
	echo "<tr>";
		foreach ($ticket as $key => $value) {
			echo "<td>".$value."</td>";
		}
	echo "</tr>";
}
echo "</table>";
//*/