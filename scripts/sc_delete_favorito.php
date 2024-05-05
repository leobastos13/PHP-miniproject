<?php
session_start();
require_once ("../connections/connection.php");
// var_dump($_GET);
if (isset($_GET["id"])) {
    $id_filmes = $_GET["id"];

    if (isset($_SESSION['login']) && ($_SESSION['login'] !== '')) {

        // atribuir login do user a uma variável
        $id_user = $_SESSION["id"];


    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "DELETE FROM filmes_favoritos 
              WHERE ref_utilizadores = ? 
              AND ref_filmes = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_filmes);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            /* Como prevenir? */
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            
            header("Location: ../filme_detail.php?id= $id_filmes");
        }
    } else {
        echo("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
    }
}

?>

