<?php
require_once ("../connections/connection.php");
// var_dump($_GET);
if (isset($_GET["id"])) {
    $id_generos = $_GET["id"];

    // We need the function!
    

    // Create a new DB connection
    $link = new_db_connection();

    $stmt = mysqli_stmt_init($link);

    $query = "SELECT id_filmes FROM filmes WHERE ref_generos = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id_generos);

        if (mysqli_stmt_execute($stmt)) {
            
            mysqli_stmt_bind_result($stmt, $id_filmes);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                    // Se houver filmes associados a esse gênero, mostrar uma mensagem de erro
                    header("Location: ../generos.php?error=erro2");
                    mysqli_stmt_close($stmt);

                } else {
                    mysqli_stmt_close($stmt);
                    
                     /* create a prepared statement */
                    $stmt_del = mysqli_stmt_init($link);

                    $query_del = "DELETE FROM generos
                                  WHERE id_generos = ?";

                    if (mysqli_stmt_prepare($stmt_del, $query_del)) {
                        /* Bind paramenters */
                        mysqli_stmt_bind_param($stmt_del, "i", $id_generos);
                        /* execute the prepared statement */
                        if (!mysqli_stmt_execute($stmt_del)) {
                            /* Como prevenir? */
                            echo "Error:" . mysqli_stmt_error($stmt_del);
                        } else {
                            header("Location: ../generos.php");
                        }
                    } else {
                        /* close statement */
                        mysqli_stmt_close($stmt_del);
                    }
                    
                }
                mysqli_close($link);

            }   
        }   
}   



