

<html lang="en">

<body class="container">
 
    <h1 class="text-center">calcul</h1>
 
    <form action="" method="post">
       
            <label for="">valeur 1</label>
            <input type="number" name="val1">

            <label for="">valeur 2</label>
            <input type="number" name="val2">
        
            <label for="">Operateur</label>
            <input type="text" name="op" >

            
            
            
            <input type="radio" id="add" name=op value="+">
            <label for="add">addition</label>

            <input type="radio" id="soust" name="op" value="-">
            <label for="mult">multiplication</label>
            
            <input type="radio" id="mult" name=op value="*">
            <label for="mult">multiplication</label>

            <input type="radio" id="mult" name=op value="^">
            <label for="mult">puissance</label>
 
        <input type="submit" >
    </form>
   
</body>
</html>
<?php 
if( isset ($_POST["val1"])){
    $a = $_POST["val1"];
    $b = $_POST["val2"];
    $op = $_POST["op"];

    if( $op == "+"){
        echo $a + $b;
    }

    else if( $op == "*" || strlower($op)== "addition"){
        echo $a * $b;
    }

    else if( $op == "/"){
        echo $a / $b;
    }


}







