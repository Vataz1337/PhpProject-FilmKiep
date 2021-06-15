<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: ../loginRegister/loginPage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>All Movies</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
</head>
<body>
<?php
require_once "../loginRegister/connect.php";
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$records = mysqli_query($connect,"select * from movie");

while($data = mysqli_fetch_array($records))
{
    ?>
    <table>
    <tr>
        <td><?php echo $data['movie_id']; ?></td>
        <td><?php echo $data['title']; ?></td>
        <td><?php echo $data['realise_date']; ?></td>
        <td><a href="movieDetails.php?id=<?php echo $data['movie_id']; ?>">Details</a></td>
    </tr>
    </table>
    <?php
}
?>
</body>
