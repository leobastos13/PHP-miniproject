<?php
require_once "../connections/connection.php";

if (isset($_POST["login"]) && isset($_POST["password"])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $link = new_db_connection();

    $stmt = mysqli_stmt_init($link);

    $query = "SELECT id_utilizadores, id_perfis, password_hash FROM utilizadores
    INNER JOIN perfis ON id_perfis = ref_perfis
    WHERE login LIKE ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $login);

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_bind_result($stmt, $id_user, $perfil, $password_hash);

            if (mysqli_stmt_fetch($stmt)) {
                if (password_verify($password, $password_hash)) {
                    // Guardar sessão de utilizador
                    session_start();
                    $_SESSION["id"] = $id_user;
                    $_SESSION["login"] = $login;
                    $_SESSION["perfil"] = $perfil;
                    

                    // Feedback de sucesso
                    header("Location: ../index.php");
                } else {
                    // Password está errada
                    echo "Incorrect credentials!";
                    echo "<a href='../login.php'>Try again</a>";
                }
            } else {
                // Username não existe
                echo "Incorrect credentials!";
                echo "<a href='../login.php'>Try again</a>";
            }
        } else {
            // Acção de erro
            echo "Error:" . mysqli_stmt_error($stmt);
        }
    } else {
        // Acção de erro
        echo "Error:" . mysqli_error($link);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    echo "Campos do formulário por preencher";
}