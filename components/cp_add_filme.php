<?php
require_once "./connections/connection.php";
?>

<section style= "margin-top: 90px;" class="sec-filmes pb-5" id="lista-filmes">
    <div class= "container px-lg-5 pt-3">
    <a class="btn btn-info" href="index.php">Voltar</a>

<?php include_once "components/cp_intro_add_filme.php" ?>

<div class="row">
            <?php
                // código para ligar à BD e mostrar informação dinâmica
             
             $link = new_db_connection();

             // Create a prepared statement
             $stmt = mysqli_stmt_init($link);
             
             // Define the query
             $query = "SELECT id_generos, tipo FROM generos";
             ?>
             
<form class="col-6" action="./scripts/sc_add_filme.php" 
method="post" class="was-validated">
 <div class="mb-3 mt-3">
 <label for="uname" class="form-label">Título:*</label>
 <input type="text" class="form-control" id="titulo" value="" 
name="titulo" required>
 <div class="valid-feedback">Valid.</div>
 <div class="invalid-feedback">Please fill out this field.</div>
 </div>
 <div class="mb-3 mt-3">
 <label for="uname" class="form-label">Sinopse:*</label>
 <textarea class="form-control" id="sinopse" value="" 
name="sinopse" rows="5" required></textarea>
 <div class="valid-feedback">Valid.</div>
 <div class="invalid-feedback">Please fill out this field.</div>
 </div>
 <div class="mb-3 mt-3">
 <label for="uname" class="form-label">Ano:*</label>
 <input type="number" class="form-control" id="ano" value="" 
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
             
            // Prepare the statement
            if (mysqli_stmt_prepare($stmt, $query)) {
                // Execute the prepared statement
                mysqli_stmt_execute($stmt);
                     // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $tipo);
                // Fetch values
                while (mysqli_stmt_fetch($stmt)) {
                    echo "<option value=' $id '> $tipo </option>";       
                }
                mysqli_stmt_close($stmt);
            
            } else {
                // Errors related with the query
                echo mysqli_error($link);
            }  
            // Close connection
            mysqli_close($link);   
            ?>

 </select>
 <div class="valid-feedback">Valid.</div>
 <div class="invalid-feedback">Please fill out this field.</div>
 </div>
 <div class="mb-3 mt-3">
 <label for="uname" class="form-label">URL IMDB:</label>
 <input type="url" class="form-control" id="url_imdb" value="" 
name="url_imdb">
 <div class="valid-feedback">Valid.</div>
 <div class="invalid-feedback">Please fill out this field.</div>
 </div>
 <div class="mb-3 mt-3">
 <label for="uname" class="form-label">URL Trailer:</label>
 <input type="url" class="form-control" id="url_trailer" value="" 
name="url_trailer">
 <div class="valid-feedback">Valid.</div>
 <div class="invalid-feedback">Please fill out this field.</div>
 </div>
 <button type="submit" class="btn btn-primary">Adicionar</button>
</form>
</div>
</div>
</section>
