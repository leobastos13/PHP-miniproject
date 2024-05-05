<section class="sec-filmes pb-5 mt-5" id="filmes">
    <div class="container px-lg-5 pt-3">
        <!-- Intro -->
        <?php include_once "./components/cp_intro_index.php"; ?>
        <?php include_once "connections/connection.php" ?>

        <!-- Listar três filmes mais recentes -->

        <div class="row">
            <?php
            // código para ligar à BD e mostrar informação dinâmica
            $link = new_db_connection();

            // Create a prepared statement
            $stmt = mysqli_stmt_init($link);
            
            // Define the query
            $query = "SELECT filmes.titulo, filmes.capa, generos.tipo FROM filmes INNER JOIN generos ON generos.id_generos = filmes.ref_generos ORDER BY filmes.ano DESC LIMIT 3";
            
            // Prepare the statement
            if (mysqli_stmt_prepare($stmt, $query)) {
            
                // Execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $titulo, $capa, $tipo);
            
                    // Fetch values
                    while (mysqli_stmt_fetch($stmt)) {
                       ?> 
                           <div class="col-md-4 mb-md-0 pb-5">
                               <div class="card pb-2 h-100 shadow rounded">
                                   <div class="capas-preview" style="background-image: url(<?php echo "imgs/capas/" . $capa; ?>)"></div>
                                       <div class="card-body text-center">
                                       <h4 class="text-uppercase m-0 mt-2"><?php echo "<h2>$titulo</h2>"; ?></h4>
                                       <hr class="my-3 mx-auto" />
                                       <div class="tipo-filme mb-0 small text-black-50"><?php echo "<p>$tipo</p>"; ?></div>
                                       <a href="filme_detail.php" class="mt-2 btn btn-outline-primary"><b><i class="fas fa-plus text-primary"></i></b></a>
                                   </div>
                               </div>
                           </div> 
                       <?php      
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
            
            <div class="col text-center my-5">
                <a href="filmes.php" class="btn btn-primary">Ver todos</a>
            </div>

        </div>
</section>