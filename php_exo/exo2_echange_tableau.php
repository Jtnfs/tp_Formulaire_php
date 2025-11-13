<?php

$indice1 = 2;
$indice2 = 0;


$tableau = [7, 8, 10, 4, 5];

var_dump($tableau);

if($indice1>=0 && $indice1 < count($tableau)){
    $tp = $tableau[$indice1];
    $tableau [$indice1] = $tableau [$indice2];
    $tableau [$indice2]= $tp;


    var_dump($tableau);
}


