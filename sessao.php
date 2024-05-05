<?php
session_start(); //Antes de escrever HTML! <htlm>
if (!isset($_SESSION['count'])){
    $_SESSION['count']=0;
}else{
    $_SESSION['count']++;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php

echo "<h1>" . $_SESSION["count"] . "</h1>"
?>
</body>
</html>