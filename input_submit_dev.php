<?php
/*
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 60); //300 seconds = 5 minutes
//*/
error_reporting(E_ALL);

include 'Classes/SourceHandler.php';
include 'Classes/Comparer.php';
include 'Classes/PHPExcel/IOFactory.php';

set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');

$source_handler = new SourceHandler($_FILES);
$fuentes = $source_handler->getSources();
$Comp = new Comparer($fuentes);
$missing = $Comp->getMissing();

unset($source_handler);
unset($Comp);
//unset($source_handler);