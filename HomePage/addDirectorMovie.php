<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: ../loginRegister/loginPage.php');
    exit();
}
if (($_SESSION['admin'])==false) {
    header('Location: mainPage.php');
    exit();
}
if(isset($_POST['addDirector'])){
    require_once "../loginRegister/connect.php";
    $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $directorId = $_POST['director'];
    $movieId = $_POST['movieId'];
    $sqlCheck = "SELECT * FROM movie_director WHERE movie_fk='$movieId' AND director_fk='$directorId'";
    $result = mysqli_query($connect,$sqlCheck);
    if((mysqli_num_rows($result))>0){
        header("Location: movieDetails.php?id=$movieId");
        exit();
    }
    $sql = "INSERT INTO movie_director (movie_fk, director_fk) VALUES ('$movieId', '$directorId')";
    $connect->query($sql);
    header("Location: movieDetails.php?id=$movieId");
}
