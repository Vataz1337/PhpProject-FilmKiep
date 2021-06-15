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
if(isset($_POST['addActor'])){
    require_once "../loginRegister/connect.php";
    $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $actorId = $_POST['actors'];
    $movieId = $_POST['movieId'];
    $sqlCheck = "SELECT * FROM movie_actor WHERE movie_fk='$movieId' AND actor_fk='$actorId'";
    $result = mysqli_query($connect,$sqlCheck);
    if((mysqli_num_rows($result))>0){
        header("Location: movieDetails.php?id=$movieId");
        exit();
    }
    $sql = "INSERT INTO movie_actor (movie_fk, actor_fk) VALUES ('$movieId', '$actorId')";
    $connect->query($sql);
    header("Location: movieDetails.php?id=$movieId");
}
