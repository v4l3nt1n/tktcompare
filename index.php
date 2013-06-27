<?php
ini_set('memory_limit', -1);

include 'data.php';

function sabre_cleaner($elem) {
    return cleaner($elem, 'boleto', 'sabre');
}

function amadeus_cleaner($elem) {
    return cleaner($elem, 'ticket', 'amadeus');
}

function backoffice_cleaner($elem) {
    return cleaner($elem, 'tkt', 'backoffice');
}

function cleaner($elem, $key, $fuente) {
    return $elem[$key];
}

function filtrito_amadeus($elem) {
    global $backoffice_clean_data;
    return !in_array($elem['ticket'], $backoffice_clean_data);
}

function filtrito_sabre($elem) {
    global $backoffice_clean_data;
    return !in_array($elem['boleto'], $backoffice_clean_data);
}

$start = microtime(true);
// Se limpian datos de amadeus, sabre y bo

$backoffice_clean_data = array_map('backoffice_cleaner', $backoffice);
// fin clean data

// obtener faltantes amadeus
$backoffice_faltantes_amadeus = array_filter($amadeus, 'filtrito_amadeus');

// obtener faltantes sabre
$backoffice_faltantes_sabre = array_filter($sabre, 'filtrito_sabre');

$end = microtime(true);

echo ($end - $start) . ' seconds<hr />';

//var_dump($backoffice_faltantes_amadeus);
//var_dump($backoffice_faltantes_sabre);