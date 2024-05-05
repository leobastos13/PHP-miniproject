<?php

if (isset($_GET["id"])) {
    $id_filmes = $_GET["id"];

    require_once ("../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "DELETE FROM filmes
              WHERE id_filmes = ?"; 
              

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "i", $id_filmes);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            /* Como prevenir? */
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            
            header("Location: ../filmes.php");
        }
    } else {
        echo("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
    
}

?>






}    