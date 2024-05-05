<?php

function new_db_connection()
{
    $env = "localhost";
    // Variables for the database connection
    if ($env == "localhost") {
        $hostname = 'localhost';
        $username = "root";
        $password = "";
        $dbname = "top_indian_movies";
    } else {
        $hostname = 'labmm.clients.ua.pt';
        $username = "deca_23_BDTSS_p_web";
        $password = "xxxxxxx";
        $dbname = "deca_23_BDTSS_p";
    }

    // Makes the connection
    $local_link = mysqli_connect($hostname, $username, $password, $dbname);

    // If it fails to connect then die and show errors
    if (!$local_link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Define charset to avoid special chars errors
    mysqli_set_charset($local_link, "utf8");

    // Return the link
    return $local_link;
}