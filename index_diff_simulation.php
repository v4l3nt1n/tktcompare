<?php
ini_set('memory_limit', '-1');
$sabre_tkts = array(
	'0123456789',
	'0123456780',
	'0123456781',
	'0123456782',
	'0123456783',
	'0123456784',
);

$amadeus_tkts = array(
	'0123456785',
	'0123456786',
	'0123456787',
	'0123456788',
	'0123456789',
	'0123456701',
);

$vstour_tkts = array(
	'0123456785',
	'0123456786',
	'0123456787',
	'0123456788',
	'0123456789',
	'0123456701',
	'0123456789',
	'0123456780',
	'0123456781',
	'0123456782',
	'0123456783',
	'0123456784',	
);

$sabre = array(
		0 => array(
			'tkt'=>'0123456789',
			'fuente'=>'sabre'
			),
		1 => array(
			'tkt'=>'0123456780',
			'fuente'=>'sabre'
			),
		2 => array(
			'tkt'=>'0123456781',
			'fuente'=>'sabre'
			),
		3 => array(
			'tkt'=>'0123456782',
			'fuente'=>'sabre'
			),
		4 => array(
			'tkt'=>'0123456783',
			'fuente'=>'sabre'
			),
		5 => array(
			'tkt'=>'0123456784',
			'fuente'=>'sabre'
			),
	);

$amadeus = array(
		0 => array(
			'tkt'=>'0123456785',
			'fuente'=>'amadeus'
			),
		1 => array(
			'tkt'=>'0123456786',
			'fuente'=>'amadeus'
			),
		2 => array(
			'tkt'=>'0123456787',
			'fuente'=>'amadeus'
			),
		3 => array(
			'tkt'=>'0123456788',
			'fuente'=>'amadeus'
			),
		4 => array(
			'tkt'=>'0123456789',
			'fuente'=>'amadeus'
			),
		5 => array(
			'tkt'=>'0123456701',
			'fuente'=>'amadeus'
			),
	);

$vstour = array(
		0 => array(
			'tkt'=>'0123456785',
			'fuente'=>'vstour'
			),
		1 => array(
			'tkt'=>'0123456786',
			'fuente'=>'vstour'
			),
		2 => array(
			'tkt'=>'0123456787',
			'fuente'=>'vstour'
			),
		3 => array(
			'tkt'=>'0123456788',
			'fuente'=>'vstour'
			),
		4 => array(
			'tkt'=>'0123456789',
			'fuente'=>'vstour'
			),
		5 => array(
			'tkt'=>'0123456701',
			'fuente'=>'vstour'
			),
		6 => array(
			'tkt'=>'0123456789',
			'fuente'=>'vstour'
			),
		7 => array(
			'tkt'=>'0123456780',
			'fuente'=>'vstour'
			),
		8 => array(
			'tkt'=>'0123456781',
			'fuente'=>'vstour'
			),
		9 => array(
			'tkt'=>'0123456782',
			'fuente'=>'vstour'
			),
		10 => array(
			'tkt'=>'0123456783',
			'fuente'=>'vstour'
			),
		11 => array(
			'tkt'=>'0123456784',
			'fuente'=>'vstour'
			),
	);


function arrayDiffEmulation($arrayFrom, $arrayAgainst)
{
	$arrayAgainst = array_flip($arrayAgainst);
	
	foreach ($arrayFrom as $key => $value) {
		if(isset($arrayAgainst[$value])) {
			unset($arrayFrom[$key]);
		}
	}
	
	return $arrayFrom;
}

//$t = microtime(true);
$diff = arrayDiffEmulation($vstour_tkts,$sabre_tkts);
$diff2 = arrayDiffEmulation($diff,$amadeus_tkts);
echo "<pre>";
var_dump($diff2);
echo "</pre>";