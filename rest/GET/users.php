<?php 
    include '../dbConnect.php';
    include '../responseSender.php';

    $dbConnection = connectToDB();
    $query = 'SELECT * FROM editor'; 

    if(!($resultado = @mysqli_query($dbConnection, $query))) 
    { 
        print json_encode("<p>Error al ejecutar la sentencia <b>$query</b>: " . mysqli_error($dbConnection));
        exit; 
    }
    
    $counter = 0;
    $response = array();
    while($row = mysqli_fetch_assoc($resultado))
    {
        $response[$counter] = $row;
        $counter ++;
    }

    SendResponse(1, $response);
?>