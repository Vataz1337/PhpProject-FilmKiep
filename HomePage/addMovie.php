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
if(isset($_POST['upload'])) {
    require_once "../loginRegister/connect.php";

    $imgname = ($_FILES['image']['name']);
    $tempname = $_FILES['image']['tmp_name'];
    $description = $_POST['description'];
    $title = $_POST['title'];
    $realise_date = $_POST['release'];
    $trailer = $_POST['trailer'];
    $link = $_POST['link'];

    try {
        $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($connect->connect_errno != 0) {
            $_SESSION['upload'] = "Connection error!";
            throw new Exception(mysqli_connect_errno());
        } else {
            move_uploaded_file($tempname, "../movieImages/$imgname");
            if($connect->query("INSERT INTO movie (description, title, image, realise_date, link, trailer) VALUES ('$description', '$title', '$imgname', '$realise_date', '$link', '$trailer')")) {
                $_SESSION['upload'] = "Movie added successfully!";
            }else {
                throw new Exception($connect->error);
            }
            $connect->close();
        }
    }catch (Exception $e){
        $_SESSION['upload'] = "Something went wrong!";
    }
}
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>Adding</title>
    <link rel="stylesheet" href="../CSS/addMovieStyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
</head>
<body>
<div class="mainContainer">
    <form action="addMovie.php" method="post" enctype="multipart/form-data">
        <div class="titleText">
            Add movie
        </div>
        <div class="inputs">
            <div class="title">
                <label>
                    <input type="text" placeholder="Title" name="title">
                </label>
            </div>
            <div class="release">
                <label>
                    <input type="date" placeholder="Realise date" name="release">
                </label>
            </div>
            <div class="trailer">
                <label>
                    <input type="text" placeholder="Link to trailer" name="trailer">
                </label>
            </div>
            <div class="link">
                <label>
                    <input type="text" placeholder="Link to movieDB" name="link">
                </label>
            </div>
            <div class="image">
                <label>
                    Platak filmu:<input type="file" placeholder="image" name="image">
                </label>
            </div>
            <div class="opis">
                <label>
                <textarea type="text" placeholder="Movie description" name="description">
                </textarea>
                </label>
            </div>
            <div class="submit">
                <input type="submit" value="Add movie" name="upload">
            </div>
            <?php
            if(isset($_SESSION['upload'])){
                echo '<div class ="messege">' . $_SESSION['upload'] . '</div>';
                unset($_SESSION['upload']);
            }
            ?>
    </form>
</div>
</body>
</html>