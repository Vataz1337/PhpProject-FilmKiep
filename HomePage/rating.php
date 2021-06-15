<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: ../loginRegister/loginPage.php');
    exit();
}
require_once "../loginRegister/connect.php";
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$movieID = $_POST['movieId'];
$uid = $_SESSION['user_id'];
$score = $_POST['rating'];
$check = "SELECT * FROM score WHERE movie_fk='$movieID' AND user_fk='$uid'";
$result = mysqli_query($connect,$check);
if((mysqli_num_rows($result))>0){
    $sqlUpdate = "UPDATE score SET score='$score' WHERE user_fk='$uid' AND movie_fk='$movieID'";
    $connect->query($sqlUpdate);
    header("Location: movieDetails.php?id=$movieID");
    exit();
}else {
    $sql = "INSERT INTO score (movie_fk, user_fk, score) VALUES ('$movieID', '$uid', '$score')";
    $connect->query($sql);
    header("Location: movieDetails.php?id=$movieID");
    exit();
}

