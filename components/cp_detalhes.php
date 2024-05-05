<?php

// Verify the query string requirements
if (isset($_GET["id"])) {
    // Store values
    $id_filmes = (int) $_GET["id"];

    // We need the function!
    require_once("./connections/connection.php");

    // código para ligar à BD e mostrar informação dinâmica
    $link = new_db_connection();

    // Create a prepared statement
    $stmt = mysqli_stmt_init($link);

    $Admin = 0;
    // var_dump($_SESSION);
    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1) {
        $Admin = 1;
    }
    
        // Define the query
        $query = "SELECT filmes.id_filmes, filmes.titulo, filmes.capa, filmes.ano, generos.tipo, filmes.sinopse, filmes.url_trailer, filmes.url_imdb 
                      FROM filmes INNER JOIN generos ON generos.id_generos = filmes.ref_generos
                      WHERE filmes.id_filmes = ?";

        // Prepare the statement
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, 'i', $id_filmes);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id_filmes, $titulo, $capa, $ano, $tipo, $sinopse, $trailer, $imdb);
                mysqli_stmt_store_result($stmt);

                // Fetch values
                while (mysqli_stmt_fetch($stmt)) {

                    if (isset($_SESSION['login']) && ($_SESSION['login'] !== '')) {

                        $id_user = $_SESSION["id"];
                    
                        echo 
                        '<section style="margin-top: 90px;" class="sec-filmes pb-5" id="detalhe-filme">
                            <div class="container px-lg-5 pt-3">
                                <a class="btn btn-info" href="filmes.php">Voltar</a>
                                <h1 class="pt-5 pb-3">'.  $titulo .' </h1>
                                <div class="row d-flex flex-row justify-content-between">
                                    <div class="col detalhes">
                                        <img class="img-fluid mb-3" src="' . "imgs/capas/" . $capa .'" />
                                    </div>
                                    <div class="col detalhes">
                                        <h4 class="text-primary"><span class="text-black-50">' . $ano . ' </span> | ' . $tipo . '  | </h4>';
                                        

                                        // query para verificar se o filme está nos favoritos
                                        $stmt_fav = mysqli_stmt_init($link);

                                        $query_fav = "SELECT ref_utilizadores, ref_filmes 
                                                      FROM filmes_favoritos
                                                      WHERE ref_utilizadores = ?
                                                      AND ref_filmes = ?";



                                        if (mysqli_stmt_prepare($stmt_fav, $query_fav)) {
                                            mysqli_stmt_bind_param($stmt_fav, "ii", $id_user, $id_filmes);
                                            mysqli_stmt_execute($stmt_fav);

                                            // para me deixar usar duas queries 
                                            mysqli_stmt_store_result($stmt_fav);

                                            // verificar se o filme existe nos favoritos
                                            if (mysqli_stmt_num_rows($stmt_fav) == 0) {

                                                //adicionar
                                                echo '<div>
                                                        <a style="border-radius:2rem; margin-left: 18rem; position:absolute; top:15.5rem;" class="d-block btn btn-outline-primary mt-4" href="scripts/sc_add_favorito.php?id=' . $id_filmes . '"
                                                        >Adicionar aos Favoritos</a>
                                                      </div>';
                                            } else {
                                                //remover
                                                echo '<div>
                                                        <a style="border-radius:2rem; margin-left: 18rem; position:absolute; top:15.5rem;" class="d-block btn btn-primary mt-4" href="scripts/sc_delete_favorito.php?id=' . $id_filmes . '"
                                                        >Remover dos Favoritos</a>
                                                      </div>';
                                            }
                                        } else {
                                            echo "Erro" . mysqli_stmt_error($stmt);
                                        }
                                            mysqli_stmt_close($stmt_fav);
                                            
                                        

                                        
                                        echo
                                            '<div class="card pb-2 mt-4 shadow rounded">
                                                <div class="card-body">
                                                    <h4 class="text-uppercase text-primary m-0 mt-2">Sinopse</h4>
                                                    <hr class="my-3 mx-auto" />
                                                    <p class="tipo-filme mb-0">'. $sinopse .'</p>
                                                </div>
                                            </div>';
                                            

                                            if ($Admin == 1) {
                                                echo '<a style="border-radius:2rem;" class="d-block btn btn-primary mt-4" href="./scripts/sc_delete_filme.php?id=' . $id_filmes . '"
                                                        >Apagar</a>';

                                                echo '<a style="border-radius:2rem;" class="d-block btn btn-primary mt-4" href="update_filme.php?id=' . $id_filmes . '"
                                                        >Editar</a>';
                                            }            
                                            echo
                                            '<a style="border-radius:2rem;" class="d-block btn btn-outline-primary mt-4" href=" ' . $trailer . '" target="_blank">Trailer</a>
                                            <a style="border-radius:2rem;" class="d-block btn btn-outline-primary mt-4" href="' .  $imdb . ' ?>" target="_blank">IMDb</a>
                                    </div>
                                </div>
                            </div>
                        </section>';
                    


                    } else {
                    echo
                    '<section style="margin-top: 90px;" class="sec-filmes pb-5" id="detalhe-filme">
                        <div class="container px-lg-5 pt-3">
                            <a class="btn btn-info" href="filmes.php">Voltar</a>
                            <h1 class="pt-5 pb-3">' . $titulo .'</h1>
                            <div class="row d-flex flex-row justify-content-between">
                                <div class="col detalhes">
                                    <img class="img-fluid mb-3" src="' . "imgs/capas/" . $capa .'" />
                                </div>
                                <div class="col detalhes">
                                    <h4 class="text-primary"><span class="text-black-50">' . $ano .'</span> |  ' . $tipo . '</h4>
                                    <div class="card pb-2 mt-4 shadow rounded">
                                        <div class="card-body">
                                            <h4 class="text-uppercase text-primary m-0 mt-2">Sinopse</h4>
                                            <hr class="my-3 mx-auto" />
                                            <p class="tipo-filme mb-0"> ' . $sinopse .' </p>
                                        </div>
                                    </div>
                                    <a style="border-radius:2rem;" class="d-block btn btn-outline-primary mt-4" href=" ' . $trailer . '" target="_blank">Trailer</a>
                                    <a style="border-radius:2rem;" class="d-block btn btn-outline-primary mt-4" href="' .  $imdb . ' " target="_blank">IMDb</a>
                                </div>
                            </div>
                        </div>
                    </section>';


                    }   
                }                
            } else {
                // Execute error
                echo "Error: " . mysqli_stmt_error($stmt);
            }
        } else {
            echo ("Error description: " . mysqli_error($link));
        }
        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
} else {
    header('Location: filmes.php');
}
                    
                
                                
?>
