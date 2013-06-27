<?php
/*

* Los tickets provenientes de amadeus y sabre son coincidentes con lo proveniente del backoffice
* Los tickets provenientes de amadeus y sabre NO son coincidentes con lo proveniente del backoffice
	* Los tickets provenientes de amadeus NO son coincidentes con lo proveniente del backoffice y los de sabre SI
	* Los tickets provenientes de amadeus SI son coincidentes con lo proveniente del backoffice y los de sabre NO
	* Ningún ticket proveniente de amadeus y/o sabre es coincidente con lo proveniente del backoffice

*/

$sabre = array();
$amadeus = array();
for ($i=0; $i < 1000; $i++) { 
	$sabre[$i] = array(
		'boleto' => '253344000' . $i,
		'fuente' => 'sabre'
	);

	$amadeus[$i] = array(
		'ticket' => '999844000' . $i,
		'fuente' => 'amadeus'
	);
}

/*
$i = 0;
$backoffice = array(
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	)
);
*/


$i = -1;
$backoffice = array(
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . $i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . $i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . $i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . $i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . $i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . $i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . $i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '253344000' . ++$i,
		'fuente' => 'backoffice'
	),
	array(
		'tkt' => '999844000' . $i,
		'fuente' => 'backoffice'
	)
);