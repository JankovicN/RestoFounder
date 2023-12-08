<?php

$types[] = 'Fast Food';
$types[] = 'Dinner';
$types[] = 'Cafe';
$types[] = 'Chinese food';
$types[] = 'Indian food';
$types[] = 'Thai food';
$types[] = 'National kitchen';
$types[] = 'Pop-up Restaurant';
$types[] = 'Casual Dinning';
$types[] = 'Pizzeria';
$types[] = 'Cruise Line';
$types[] = 'Food Hall';
$types[] = 'Food Truck';
$types[] = 'Ghost kitchen restaurant';


$query = $_REQUEST['query'];
$suggestion = ""; 

if ($query !== "") {
    $query = strtolower($query);
    $length = strlen($query);

    foreach ($types as $type) {
        if (stristr($query, substr($type, 0, $length))) {
            if ($suggestion == "") {
                $suggestion = $type;
            } else {
                $suggestion .= ", $type";
            }
        }
    }
}
if ($suggestion == "") {
    echo 'No suggestions';
} else {
    echo $suggestion;
}
