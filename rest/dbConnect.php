<?php
     /*
        EVALUAR SI METER OTRA TABLA
     */
     function connectToDB()
     {   
        $link = @mysqli_connect( 
            'mysql-5602.dinaserver.com',   // El servidor 
            'antonio',    // El usuario 
            '1a2b3c',          // La contraseña 
            'metapress'); // La base de datos 

        if(!$link) 
        { 
            echo '<p>Error al conectar con la base de datos: ' . mysqli_connect_error(); 
            echo '</p>'; 
            exit; 
        }
        
        return $link;
    } 

    function closeDBcon($link)
    {
        mysqli_close($link);
    }
?>