<?php
if(isset($_POST['commentDelete'])){
    require_once "../loginRegister/connect.php";
    $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $uid = $_POST['userId'];
    $movieID = $_POST['movieId'];
    $date = $_POST['commentDate'];
    $sql = "DELETE FROM comment WHERE users_fk='$uid' AND movie_fk='$movieID' AND comment_date='$date'";
    $connect->query($sql);
    header("Location: movieDetails.php?id=$movieID");
}
