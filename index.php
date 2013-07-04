<?php
ini_set('memory_limit', -1);
ini_set('display_errors', 1); 
error_reporting(E_ALL);


include 'data.php';

function cleaner($elem) {
	global $cleaner_key;
    return $elem[$cleaner_key];
}

function filter($elem) {
	global $filter_key;
    global $backoffice_clean_data;
    return !in_array($elem[$filter_key], $backoffice_clean_data);
}

function classLoader ($pClassName) {
    include(__DIR__ . "/" . $pClassName . ".php");
}
spl_autoload_register("classLoader");

$start = microtime(true);


// ------------------------ OOP STYLAH BEGIN ------------------------------------------------
//*
$tickets = array(
		'sabre' => $sabre,
		'amadeus' => $amadeus,
		'backoffice' => $backoffice,
	);



$Comp = new Comparer($tickets);
$missing = $Comp->getMissing();

echo "<pre>";
print_r($missing);
echo "</pre>";

//*/
// ------------------------ OOP STYLAH END ------------------------------------------------

/*

//========================== PROCEDURAL STYLAH BEGIN ========================================0
// Se limpian datos del backoffice, ya que solo necesitamos los campos de sabre y amadeus
$cleaner_key = 'tkt';
$backoffice_clean_data = array_map('cleaner', $backoffice);
// fin clean data

$filter_key = 'ticket';
// obtener faltantes amadeus
$backoffice_faltantes_amadeus = array_filter($amadeus, 'filter');

$filter_key = 'boleto';
// obtener faltantes sabre
$backoffice_faltantes_sabre = array_filter($sabre, 'filter');

//========================== PROCEDURAL STYLAH END ========================================0
//*/

$end = microtime(true);

echo ($end - $start) . ' seconds<hr />';




//var_dump($backoffice_faltantes_amadeus);
//var_dump($backoffice_faltantes_sabre);