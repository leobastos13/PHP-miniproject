<?php


if (isset($_POST["genero"]) && ($_POST["genero"] != "")) {
    $genero = $_POST["genero"];

    // Verificação dos caracteres
    if (strlen($genero) < 3) {
        header("Location: ../generos.php?error=erro");
        return;
    }

    // We need the function!
    require_once ("../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "INSERT INTO generos (tipo) VALUES (?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "s", $genero);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Insert done */
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