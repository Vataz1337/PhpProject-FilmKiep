<?php
session_start();
if (($_SESSION['admin'])==false) {
    header('Location: movieDetails.php');
    exit();
}
include 'movieComment.php';
require_once "../loginRegister/connect.php";
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>EditComment</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
    <link rel="stylesheet" href="../CSS/movieDetailsStyle.css">
</head>
<body>
<?php
$movieID = $_POST['movieId'];
?>
<form method="post" action='<?php editComments() ?>'>
    <input type='hidden' name='userId' value="<?php echo $_POST['userId']; ?>">
    <input type='hidden' name='movieId' value="<?php echo $_POST['movieId']; ?>">
    <input type='hidden' name='commentDate' value="<?php echo $_POST['commentDate']; ?>">
    <label>
        <textarea name="comment"><?php echo $_POST['comment']; ?></textarea><br>
    </label>
    <button type="submit" name="editSubmit">Edit</button>
</form>
</body>
</html>

