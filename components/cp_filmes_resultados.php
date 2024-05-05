<?php
include_once "connections/connection.php" 
?>

<section style="margin-top: 90px;" class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
    
    <a class="btn btn-info" href="filmes.php">Voltar</a>
        <!-- Intro -->
        

        <?php
        if (isset($_POST['pesquisa'])) {
            $pesquisa = $_POST['pesquisa'];
        
        
            ?>
            <!-- Listar filmes -->
            <div style="margin-top:2rem;" class="row">
                <?php
                // código para ligar à BD e mostrar informação dinâmica
             
             $link = new_db_connection();

             // Create a prepared statement
             $stmt = mysqli_stmt_init($link);
             
             // Define the query
             $query = "SELECT filmes.id_filmes, filmes.capa, filmes.titulo, generos.tipo 
                       FROM filmes INNER JOIN generos
                       ON generos.id_generos = filmes.ref_generos  
                       WHERE filmes.titulo LIKE CONCAT('%', ?, '%')
                       OR filmes.ano LIKE CONCAT('%', ?, '%')
                       OR generos.tipo LIKE CONCAT('%', ?, '%')";
             
             // Prepare the statement
             if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, 'sss', $pesquisa, $pesquisa, $pesquisa);
             
                 // Execute the prepared statement
                 if (mysqli_stmt_execute($stmt)) {
                     // Bind result variables
                     mysqli_stmt_bind_result($stmt, $id, $capa, $titulo, $tipo);
             
                     // Fetch values
                    if (mysqli_stmt_fetch($stmt)) {
                        while (mysqli_stmt_fetch($stmt)) {
                            ?> 
                                <div class="col-md-4 mb-md-0 pb-5">
                                    <div class="card pb-2 h-100 shadow rounded">
                                        <div class="capas-preview" style="background-image: url(<?php echo "imgs/capas/" . $capa; ?>)"></div>
                                            <div class="card-body text-center">
                                            <h4 class="text-uppercase m-0 mt-2"><?php echo "<h2>$titulo</h2>"; ?></h4>
                                            <hr class="my-3 mx-auto" />
                                            <div class="tipo-filme mb-0 small text-black-50"><?php echo "<p>$tipo</p>"; ?></div>
                                            <a href="filme_detail.php?id=<?=$id?>" class="mt-2 btn btn-outline-primary"><b><i class="fas fa-plus text-primary"></i></b></a>
                                        </div>
                                    </div>
                                </div> 
                            <?php      
                        }
                    } else {
                        echo '<div class="alert-warning p-4">Nenhum filme corresponde à sua pesquisa.</div>';
                        
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
            
        } else {
            header('Location: filmes.php');
        }
        ?>    
           

        </div>
    </div>
</section>