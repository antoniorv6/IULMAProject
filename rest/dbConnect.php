<?php
     
     function connectToDB()
     {   
        $link = @mysqli_connect( 
            'localhost',   // El servidor 
            'root',    // El usuario 
            '',          // La contraseña 
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