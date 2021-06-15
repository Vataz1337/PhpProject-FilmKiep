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
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birth = $_POST['date'];
    $orgin = $_POST['orgin'];

    try {
        $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($connect->connect_errno != 0) {
            $_SESSION['upload'] = "Connection error!";
            throw new Exception(mysqli_connect_errno());
        } else {
            move_uploaded_file($tempname, "../directorImages/$imgname");
            if($connect->query("INSERT INTO director (name, surname, orgin, birth, image) VALUES ('$name', '$surname', '$orgin', '$birth', '$imgname')")) {
                $_SESSION['upload'] = "Diretor added!";
            }else {
                throw new Exception($connect->error);
            }
            $connect->close();
        }
    }catch (Exception $e){
        $_SESSION['upload'] = "Connection error!";
    }
}
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>Adding</title>
    <link rel="stylesheet" href="../CSS/addActorStyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
</head>
<body>
<div class="mainContainer">
    <form action="addDirector.php" method="post" enctype="multipart/form-data">
        <div class="titleText">
            Add director
        </div>
        <div class="inputs">
            <div class="name">
                <label>
                    <input type="text" placeholder="First name" name="name" required>
                </label>
            </div>
            <div class="surname">
                <label>
                    <input type="text" placeholder="Second name" name="surname" required>
                </label>
            </div>
            <div class="orgin">
                <label>
                    <input type="text" placeholder="Orgin of the director" name="orgin" required>
                </label>
            </div>
            <div class="date">
                <label>
                    Birth date: <input type="date" placeholder="Year of birth" name="date" required>
                </label>
            </div>
            <div class="image">
                <label>
                    Photo: <input type="file" placeholder="image" name="image" required>
                </label>
            </div>
            <div class="submit">
                <input type="submit" value="Add director" name="upload">
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