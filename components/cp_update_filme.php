<section style= "margin-top: 90px;" class="sec-filmes pb-5" id="lista-generos">
    <div class="container px-lg-5 pt-3">
    <a class="btn btn-info" href="filmes.php">Voltar</a>
    
<?php include_once "components/cp_intro_update_filme.php";

if (isset($_GET["id"])) {
    $id_filmes = $_GET["id"];
}
?>
<div class="row">
            <?php
            // We need the function!
            require_once ("./connections/connection.php");

            // código para ligar à BD e mostrar informação dinâmica
            $link = new_db_connection();

            // Create a prepared statement
            $stmt = mysqli_stmt_init($link);
             
            // Define the query
            $query = "SELECT titulo, sinopse, ano, url_imdb, url_trailer
                       FROM filmes
                       WHERE id_filmes = ?";
             
            // Prepare the statement
            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, "i", $id_filmes);

                // Execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                     // Bind result variables
                    mysqli_stmt_bind_result($stmt, $titulo, $sinopse, $ano, $imdb, $trailer);
                    // para me deixar usar duas queries 
                    mysqli_stmt_store_result($stmt);

                    while (mysqli_stmt_fetch($stmt)) {
                        ?>
                        <?php echo '<form class="col-6" action="./scripts/sc_update_filme.php?id=' . $id_filmes . '" 
                            method="post" class="was-validated">' ?>
                            <div class="mb-3 mt-3">
                            <label for="uname" class="form-label">Título:*</label>
                            <input type="text" class="form-control" id="titulo" value=" <?= $titulo ?> " 
                            name="titulo" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="mb-3 mt-3">
                            <label for="uname" class="form-label">Sinopse:*</label>
                            <textarea class="form-control" id="sinopse" value="<?= $sinopse ?>" 
                            name="sinopse" rows="5" required><?= $sinopse ?></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="mb-3 mt-3">
                            <label for="uname" class="form-label">Ano:*</label>
                            <input type="number" class="form-control" id="ano" value="<?= $ano ?>" 
                            name="ano" min="1900" max="2099"
                            step="1" value="2023" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="mb-3 mt-3">
                            <label for="uname" class="form-label">Género:</label>
                            <select class="form-select" id="genero" name="genero" required>
                            <option value="">Escolha um género</option>
                        <?php 

                            //query para selecionar o genero
                            $stmt_gen = mysqli_stmt_init($link);

                            $query_gen = "SELECT id_generos, tipo FROM generos";

                            // Prepare the statement
                            if (mysqli_stmt_prepare($stmt_gen, $query_gen)) {
                                // Execute the prepared statement
                                mysqli_stmt_execute($stmt_gen);
                                // Bind result variables
                                mysqli_stmt_bind_result($stmt_gen, $id, $tipo);
                                // para me deixar usar duas queries 
                                mysqli_stmt_store_result($stmt_gen);
                                // Fetch values
                                while (mysqli_stmt_fetch($stmt_gen)) {
                                    echo "<option value=' $id '> $tipo </option>";       
                                }
                                mysqli_stmt_close($stmt_gen);
            
                            } else {
                                // Errors related with the query
                                echo mysqli_error($link);
                            }    
            
                        ?>    
                            </select>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="mb-3 mt-3">
                            <label for="uname" class="form-label">URL IMDB:</label>
                            <input type="url" class="form-control" id="url_imdb" value="<?= $imdb ?>" 
                            name="url_imdb">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="mb-3 mt-3">
                            <label for="uname" class="form-label">URL Trailer:</label>
                            <input type="url" class="form-control" id="url_trailer" value="<?= $trailer ?>" 
                            name="url_trailer">
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </form>
                        <?php    
                    }
                } else {
                    echo "Error:" . mysqli_stmt_error($stmt);
                }

            } else {
                echo("Error description: " . mysqli_error($link));
            }
            /* close statement */
            mysqli_stmt_close($stmt);
            /* close connection */
            mysqli_close($link);    

            ?>
</div>
</section>


