<?php

$cities[] = 'Belgrade';
$cities[] = 'Novi Sad';
$cities[] = 'Valjevo';
$cities[] = 'Kragujevac';
$cities[] = 'Krusevac';
$cities[] = 'Kraljevo';
$cities[] = 'Subotica';
$cities[] = 'Sombor';
$cities[] = 'Nis';


$query = $_REQUEST['query'];
$suggestion = "";

if ($query !== "") {
    $query = strtolower($query);
    $length = strlen($query);

    foreach ($cities as $city) {
        if (stristr($query, substr($city, 0, $length))) {
            if ($suggestion == "") {
                $suggestion = $city;
            } else {
                $suggestion .= ", $city";
            }
        }
    }
}
if ($suggestion == "") {
    echo 'No suggestions';
} else {
    echo $suggestion;
}
