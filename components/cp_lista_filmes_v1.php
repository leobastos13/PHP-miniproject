<?php
include_once "connections/connection.php" 
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <!-- Intro -->

        <?php
        include_once "./components/cp_intro_filmes.php";
        ?>
        <!-- Listar filmes -->

        <div class="row">
            <?php
                // Create a new DB connection
            $link = new_db_connection();

            // Create a prepared statement
            $stmt = mysqli_stmt_init($link);

            // Define the query
            $query = "SELECT filmes.titulo, filmes.ano, filmes.sinopse FROM filmes";

            // Prepare the statement
            if (mysqli_stmt_prepare($stmt, $query)) {

                // Execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $titulo, $ano, $sinopse);

                    // Fetch values
                    while (mysqli_stmt_fetch($stmt)) {
                        echo "<h2>$titulo</h2>";
                        echo "<h3>$ano</h3>";
                        echo "<p>$sinopse</p>";
                    }

                } else {
                    // Execute error
                    echo "Error: " . mysqli_stmt_error($stmt);
                }

            } else {
                // Errors related with the query
                echo "Error: " . mysqli_error($link);
            }
            // Close statement
            mysqli_stmt_close($stmt);

            // Close connection
            mysqli_close($link);
                
            ?>
        </div>
    </div>
</section>