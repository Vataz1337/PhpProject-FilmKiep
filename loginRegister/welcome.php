<?php
session_start();
if((!isset($_SESSION['registered']))) {
    header("Location: loginPage.php");
    exit();
}else{
    unset($_SESSION['registered']);
}
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>Welcome</title>
</head>
<body>
<h1>Dziękujemy za rejestrację na FILMKIEP</h1><br>
<a href="loginPage.php">Zaloguj się</a>
</body>
</html>
