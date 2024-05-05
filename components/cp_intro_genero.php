<?php
require_once "./connections/connection.php";
?>

<?php

            if (isset($_GET["id"])) {
                $id = $_GET["id"];

                $link = new_db_connection();
                $stmt = mysqli_stmt_init($link);

                $query = "SELECT tipo 
                          FROM generos
                          WHERE generos.id_generos = ?";

                if (mysqli_stmt_prepare($stmt, $query)) {

                    mysqli_stmt_bind_param($stmt, 'i', $id);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $tipo);

                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0 ) {

                        while (mysqli_stmt_fetch($stmt)) {

                            echo '<h1 style= "padding-top: 3rem;">' . $tipo . '</h1>';
                        }
                    } else {
                        echo "<h1>Ainda não temos filmes deste género";
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo mysqli_error($link);
                }

                mysqli_close($link);
            } else {
                echo "<h1>Falta o id do género!!!</h1>";
            }
?>


<p class="text-black-60 text-left pb-4">
    Todos os filmes deste género
    <br />
    Escolhe um!
</p>
