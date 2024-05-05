<?php
session_start();

if (isset($_GET["id"]) && isset($_POST["titulo"]) && ($_POST["titulo"] != "") && isset($_POST["sinopse"]) && ($_POST["sinopse"] != "") && isset($_POST["ano"]) && ($_POST["ano"] != "") && isset($_POST["genero"]) && ($_POST["genero"] != "") && isset($_POST["url_imdb"]) && isset($_POST["url_trailer"])) {
    $imdb = "";
    if ($_POST["url_imdb"] == "") {
        $imdb = null;
    } else {
        $imdb = $_POST["url_imdb"];
    }

    $trailer = "";
    if ($_POST["url_trailer"] == "") {
        $trailer = null;
    } else {
        $trailer = $_POST["url_trailer"];
    }

    $id_filmes = $_GET["id"];
    $titulo = $_POST["titulo"];

    $sinopse = $_POST["sinopse"];
    $ano = $_POST["ano"];
    $genero = $_POST["genero"];
    $imdb = $imdb;
    $trailer = $trailer;
    // var_dump($_GET);
    // var_dump($_POST);

    // We need the function!
    require_once("../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "UPDATE filmes
              SET titulo = ?, sinopse = ?, ano = ?, ref_generos = ?, url_imdb = ?, url_trailer = ? 
              WHERE id_filmes = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "ssiissi", $titulo, $sinopse, $ano, $genero, $imdb, $trailer, $id_filmes);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Update done */
            header("Location: ../filmes.php");
        }
    } else {
        echo ("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
}
