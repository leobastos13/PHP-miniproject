

<section style= "margin-top: 90px;" class="sec-filmes pb-5" id="lista-generos">
    <div class="container px-lg-5 pt-3">
    <a class="btn btn-info" href="generos.php">Voltar</a>
    
<?php include_once "components/cp_intro_update_genero.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
    // código para ligar à BD e mostrar informação dinâmica
    require_once ("./connections/connection.php");
$link = new_db_connection();

// Create a prepared statement
$stmt = mysqli_stmt_init($link);
 
// Define the query
$query = "SELECT tipo 
           FROM generos
           WHERE id_generos = ?";
 
// Prepare the statement
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
         // Bind result variables
        mysqli_stmt_bind_result($stmt, $genero);
        // para me deixar usar duas queries 
        mysqli_stmt_store_result($stmt);

        while (mysqli_stmt_fetch($stmt)) {
?> 
        <div class="row">
            <form class="col-6" action="./scripts/sc_update_genero.php?id= <?php echo $id ?>" method="post">
                <div class="mb-3 mt-3">
                    <label for="uname" class="form-label">Género:</label>
                    <input type="text" class="form-control" id="tipo" value=" <?php echo  $genero ?> "name="tipo" required="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        </div>
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
       
