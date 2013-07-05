<?php
ini_set('memory_limit', '-1');
ini_set('display_errors', 1); 
error_reporting(E_ALL);


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
            'tkt'=>'03935246277',
            'fuente'=>'vstour'
            ),
        1 => array(
            'tkt'=>'03935246278',
            'fuente'=>'vstour'
            ),
        2 => array(
            'tkt'=>'03935246279',
            'fuente'=>'vstour'
            ),
        3 => array(
            'tkt'=>'03935246280',
            'fuente'=>'vstour'
            ),
        4 => array(
            'tkt'=>'03935246281',
            'fuente'=>'vstour'
            ),
        5 => array(
            'tkt'=>'03935246282',
            'fuente'=>'vstour'
            ),
        6 => array(
            'tkt'=>'03935246283',
            'fuente'=>'vstour'
            ),
        7 => array(
            'tkt'=>'03935246284',
            'fuente'=>'vstour'
            ),
        8 => array(
            'tkt'=>'03935246285',
            'fuente'=>'vstour'
            ),
        9 => array(
            'tkt'=>'03935246286',
            'fuente'=>'vstour'
            ),
        10 => array(
            'tkt'=>'03935246287',
            'fuente'=>'vstour'
            ),
        11 => array(
            'tkt'=>'03935246288',
            'fuente'=>'vstour'
            ),
    );

//funcion que corta el string de derecha a izquierda dejando el largo especificado en $length
function rpad($string,$length)
{
    $rpadded = substr($string, strlen($string)-$length,$length);
    return $rpadded;
}

$count = count($vstour);

for ($i=0; $i < $count ; $i++) { 
    $vstour[$i]['tkt'] = rpad($vstour[$i]['tkt'],10);
}

echo "<pre>";
print_r($vstour);
echo "</pre>";