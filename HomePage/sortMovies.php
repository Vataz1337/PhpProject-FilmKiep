<?php
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: ../loginRegister/loginPage.php');
    exit();
}
require_once "../loginRegister/connect.php";
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>Categories</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
    <link rel="stylesheet" href="../CSS/categoriesStyle.css">
</head>
<body>
<div class="sorterGenre">
    <form action="sortMovies.php" method="post" class="sorterForm">
        <button type="submit" name="sortingCategory">Sort by Category</button>
        <label for="genre"></label><select name="genre" id="genre">
            <option value="all" id="allGenre" name="allGenre">All</option>
            <?php
            $sqlShowGenres = mysqli_query($connect, "SELECT * FROM genre");
            while($rowGemres = mysqli_fetch_array($sqlShowGenres)){
                ?>
                <option value=<?php echo $rowGemres['genre_id'] ?>><?php echo $rowGemres['nameOfgenre']  ?></option>
                <?php
            }
            ?>
        </select>
        <label for="sorting"></label><select name="sorting" id="sorting">
            <option value=" ORDER BY realise_date DESC" id="date" name="date">Date</option>
            <option value=" ORDER BY title" id="title" name="title">Title</option>
            <option value="" id="nothing" name="nothing">None</option>
        </select>
    </form>
</div>
<div class="logoBrowser">
    <div class="logo">
        <img src="../Images/filmkiep.png" alt="Logo">
    </div>
    <div class="title">
        FILMKIEP
    </div>
    <div class="browserImage_browserInput">
        <form method="post" action="sortMovies.php">
            <div class="browserImage">
                <input type="image" src="../Images/loopka.png" alt="Submit">
            </div>
            <div class="browser">
                <label><input type="text" name="browser"></label>
            </div>
        </form>
    </div>
    <div class="buttons">
        <div class="button">
            <input type="button" onClick="window.location.href=''" id="button" value="MY FILMKIEP">
        </div>
        <div class="button">
            <input type="button" onClick="window.location.href=''" id="button" value="FAVORITE">
        </div>
        <div class="button">
            <input type="button" onClick="window.location.href=''" id="button" value="TV SERIES">
        </div>
        <div class="button">
            <input type="button" onClick="window.location.href=''" id="button" value="ACTOR RANKING">
        </div>
        <div class="button">
            <input type="button" onClick="window.location.href=''" id="button" value="FILM RANKING">
        </div>
    </div>
</div>
<?php
if(isset($_POST['genre'])){
    $genre = $_POST['genre'];
    if($_POST['genre']=="all"){
        $records = "SELECT * FROM movie";
    }else {
        $records = "SELECT * FROM movie WHERE genre_fk='$genre'";
    }
}else {
    $records = "select * from movie";
}
if(isset($_POST['sorting'])){
    $orderBy = $_POST['sorting'];
    $records .= $orderBy;
}
if(isset($_POST['browser'])){
    $browser = $_POST['browser'];
    $records = "SELECT * FROM movie WHERE title='$browser'";
    if (!$records){
        echo "<div class='noMovie'>";
            echo "There is no such movie on this website!";
        echo "</div>";
    }
}
$records = $connect->query($records);
$rowCounter=1;
echo "<div class='list'>";
while($data = mysqli_fetch_array($records))
{
    echo "<div class='wholeMovie'>";
        $movieImage = '../movieImages/' . $data['image'];
        echo "<div class='movieImage'>";
            echo "<img class='Image' src='$movieImage' alt='' >";
        echo "</div>";
            echo "<div class='wholeText'>";
            echo $rowCounter;
            echo "<div class='movieTitle'>";
                echo $data['title'];
            echo "</div>";
            echo "<div class='date'>";
                echo $data['realise_date'];
            echo "</div>"
            ?>
            <div class="link">
                <a href="movieDetails.php?id=<?php echo $data['movie_id']; ?>">Details</a>
            </div>
            <?php
            $rowCounter++;
        echo "</div>";
    echo "</div>";
}
echo "</div>";
?>
</body>
