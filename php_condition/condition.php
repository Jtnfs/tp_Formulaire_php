<?php

$age = 21;

if($age >= 18){

    echo "majeur";

} else if ($age >= 1 && $age < 18) {
    echo "mineur";
}
else{
    echo "age pas correct";
}

