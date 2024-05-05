<?php
require_once "./connections/connection.php";
?>

<section class="sec-filmes pb-5" id="lista-generos">
    <div class="container px-lg-5 pt-3">
    <a class="btn btn-info" style= "margin-top: 6rem;" href="generos.php">Voltar</a>
        <!-- Intro -->
        <?php include_once "./components/cp_intro_genero.php"; ?>

        <!-- Listar filmes -->
        <div class="row">

            <?php
            if (isset($_GET["id"])) {
                $id = $_GET["id"];

                $link = new_db_connection();
                $stmt = mysqli_stmt_init($link);

                $query = "SELECT id_filmes, titulo, tipo, capa
                  FROM filmes
                  INNER JOIN generos
                  ON filmes.ref_generos = generos.id_generos
                  WHERE generos.id_generos = ?
                  ORDER BY ano DESC";

                if (mysqli_stmt_prepare($stmt, $query)) {

                    mysqli_stmt_bind_param($stmt, 'i', $id);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id_filme, $titulo, $tipo, $capa);

                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0 ) {

                        while (mysqli_stmt_fetch($stmt)) {
                            $caminho = "./imgs/capas/" . $capa;

                            echo '<div class="col-md-4 mb-md-0 pb-5">' .
                                '<div class="card pb-2 h-100 shadow rounded">' .
                                '<div class="capas-preview" style="background-image: url(' . $caminho . ');"></div>' .
                                '<div class="card-body text-center">' .
                                '<h4 class="text-uppercase m-0 mt-2">' . $titulo . '</h4>' .
                                '<hr class="my-3 mx-auto" />' .
                                '<div class="tipo-filme mb-0 small text-black-50">' . $tipo . '</div>' .
                                '<a href="filme_detail.php?id=' . $id_filme . '&source=genero&id_genero=' . $id . '" class="mt-2 btn btn-outline-primary">' .
                                '<b><i class="fas fa-plus text-primary"></i></b>' .
                                '</a>' .
                                '</div>' .
                                '</div>' .
                                '</div>';
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

            
            <!-- <div class="col-md-4 mb-md-0 pb-5">
                    <div class="card pb-2 h-100 shadow rounded">
                        <div class="capas-preview" style="background-image: url({Capa})"></div>
                            <div class="card-body text-center">
                            <h4 class="text-uppercase m-0 mt-2">{Título}</h4>
                            <hr class="my-3 mx-auto" />
                            <div class="tipo-filme mb-0 small text-black-50">{Tipo}</div>
                            <a href="filme_detail.php" class="mt-2 btn btn-outline-primary"><b><i class="fas fa-plus text-primary"></i></b></a>
                        </div>
                    </div>
                </div> -->

        </div>
    </div>
</section>