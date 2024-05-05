<!-- Head -->
<?php include_once "./components/cp_head.php" ?>

<!-- Navigation-->
<?php include_once "./components/cp_navbar.php" ?>

<!-- Filmes -->

<?php 
if (!isset($_POST['pesquisa']) || empty($_POST['pesquisa'])) {
    include_once "./components/cp_lista_filmes_v3.php";

} else {
    include_once "./components/cp_filmes_resultados.php";
}

// include_once "./components/cp_lista_filmes_v1.php"

// include_once "./components/cp_lista_filmes_v2.php"

// include_once "./components/cp_ultimos_filmes.php"

?>



<!-- Rodapé -->
<?php include_once "./components/cp_footer.php" ?>