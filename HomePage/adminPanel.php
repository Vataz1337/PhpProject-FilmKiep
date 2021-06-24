<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../loginRegister/loginPage.php');
    exit();
}
if($_SESSION['admin']==false){
    header('Location: ../loginRegister/loginPage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>FilmKiep</title>
    <link rel="stylesheet" href="../CSS/adminPanelStyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
</head>
<body>
<div>
    <div class="buttons">
        <div class="button">
            <input type="button" onClick="window.location.href='addMovie.php'" id="button" value="Add movie">
        </div>
        <div class="button">
            <input type="button" onClick="window.location.href='addActor.php'" id="button" value="Add actor">
        </div>
        <div class="button">
            <input type="button" onClick="window.location.href='addDirector.php'" id="button" value="Add director">
        </div>
        <div class="button">
            <input type="button" onClick="window.location.href='mainPage.php'" id="button" value="Main Page">
        </div>
    </div>
</div>
</body>
