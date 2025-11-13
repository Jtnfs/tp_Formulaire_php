<?php

//function somme($x, $y){
//    echo $x+$y;
//    echo "<br>";
//}

function somme($x, $y, ...$z ){
    $sum= $x+$y;
    for($i=0; $i<count($z); $i++){
        $sum += $z[$i];
    }&

    return $sum;
}

$tab = [2,6, 10, 7, 40];

foreach($tab as $idx => $valeur){
    echo $idx . " ";
}


//if(somme(20,5)>20){
    //echo"la somme est plus grande que 20";

//}

//somme(-15, 17);