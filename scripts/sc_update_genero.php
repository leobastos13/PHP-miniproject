<?php
session_start();
if (isset($_POST["tipo"]) && ($_POST["tipo"] != "") && (isset($_GET["id"]))) {
    $genero = $_POST["tipo"];
    $id_generos = $_GET["id"];
    

    // We need the function!
    require_once ("../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "UPDATE generos
              SET tipo = ?
              WHERE id_generos = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "si", $genero, $id_generos);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Update done */
            header("Location: ../generos.php");
        }
    } else {
        echo("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
}