<?php
require_once "./connections/connection.php";
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <!-- Intro -->
        <?php include_once "./components/cp_intro_generos.php"; ?>

        <!-- Listar filmes -->
        <div class="row">

            <?php
            $link = new_db_connection();
            $stmt = mysqli_stmt_init($link);
            
            $Admin = 0;
            // var_dump($_SESSION);
            if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1) {
                $Admin = 1;
            }

            $query = "SELECT id_generos, tipo FROM generos
                      ORDER BY tipo";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id_generos, $tipo);

                while (mysqli_stmt_fetch($stmt)) {
                    echo '<h3><a href="genero_filmes.php?id=' . $id_generos . '">' . $tipo . '</a>';
                    
                    if ($Admin == 1) {
            
                        echo ' <a style= "color: blue; font-size: 65%; text-decoration: none;" href="update_genero.php?id=' . $id_generos . '">(editar) </a>';
                        echo ' <a style= "color: blue; font-size: 65%; text-decoration: none;" href="./scripts/sc_delete_genero.php?id=' . $id_generos . '">(x)</a>';
                        
                    }

                    echo '</h3>';
                }

                mysqli_stmt_close($stmt);
            } else {
                echo mysqli_error($link);
            }

            mysqli_close($link);

            ?>
           

        </div>

        <?php
        if ($Admin == 1) {
            include_once "./components/cp_add_genero.php";
        } 
        ?>

        <?php
        if ($Admin == 1) {
            if (isset($_GET['error']) && $_GET['error'] != "") {

                if ($_GET['error'] == "erro") {
                    echo '<div style="margin_top:1rem;" class="alert-warning p-4">
                            <p style="padding-top:1rem;">Tem que ter mais que 3 caracteres</p>
                          </div>';
                }
    
                if ($_GET['error'] == "erro2") {
                    echo '<div style="margin_top:1rem;" class="alert-warning p-4">
                    <p style="padding-top:1rem;">Não é possível apagar um género que já tenha filmes associados</p>
                  </div>';
                }
            }
        }
    
        ?>
        


    </div>
</section>