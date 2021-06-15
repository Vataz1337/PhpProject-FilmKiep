<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../loginRegister/loginPage.php');
    exit();
}
include 'movieComment.php';
date_default_timezone_set('Europe/Warsaw');
require_once "../loginRegister/connect.php";
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$id = $_GET['id'];
$uid =  $_SESSION['user_id'];
$show = mysqli_query($connect,"select * from movie where movie_id = '$id'");
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>Details</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
    <link rel="stylesheet" href="../CSS/movieDetailsStyle.css">
</head>
<body>
<?php

while($data = mysqli_fetch_array($show))
{
    $photolotation = '../movieImages/' . $data['image'];
    $trailerLink = $data['trailer'];
    ?>
        <div class="mainContainer">
            <div class="movieImage">
                <img src="<?php echo $photolotation ?>" alt="">
            </div>
            <div class="movieTitle">
                <?php echo $data['title']; ?>
            </div>
            <div class="movieDescription">
                <?php echo $data['description']; ?>
            </div>
            <div class="movieDate">
                Realise date: <?php echo $data['realise_date']; ?>
            </div>
            <div class="rating">
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="10" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="9" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="8" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="7" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="6" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="5" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="4" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="3" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="2" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
                <form action="rating.php" method="post">
                    <div class="stars">
                        <input type="hidden" value="1" name="rating">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <input type="image" name="submit" src="../Images/star.png" alt="Submit">
                    </div>
                </form>
            </div>
            <div class="avgScore">
                <?php
                    $sqlScore = "SELECT * FROM score WHERE movie_fk='$id'";
                    $scoreResult = mysqli_query($connect,$sqlScore);
                    $numOfScores = mysqli_num_rows($scoreResult);
                    $total = $connect->query("SELECT SUM(score) AS total FROM score WHERE movie_fk='$id'");
                    $resultTotal = $total->fetch_array();
                    $rowTotal = $resultTotal['total'];
                    $avg = $rowTotal/$numOfScores;
                ?>
                Avarage score: <?php echo $avg ?> from <?php echo $numOfScores ?> scores
            </div>
            <div class="movieTrailer">
                <iframe src="<?php echo $trailerLink ?>">
                </iframe>
            </div>
            <div class="director">
                <div class="directorText">
                    Director:
                </div>
                <?php
                if($_SESSION['admin']==true){
                    ?>
                    <form action="addDirectorMovie.php" method="post" class="addDirector">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <label for="director"></label><select name="director" id="director">
                            <?php
                            $sqlDirectorAdd = mysqli_query($connect, "SELECT * FROM director");
                            while($rowOfDirectors = mysqli_fetch_array($sqlDirectorAdd)){
                                ?>
                                <option value=<?php echo $rowOfDirectors['director_id'] ?>><?php echo $rowOfDirectors['name'] . " " . $rowOfDirectors['surname']  ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <button type="submit" name="addDirector">Add director</button>
                    </form>
                <?php
                }
                $sqlDirector = mysqli_query($connect,"SELECT * FROM movie_director WHERE movie_fk='$id'");
                if((mysqli_num_rows($sqlDirector))<=0){
                    echo "This movie doesn't have any directors added yet :/";
                }else{
                    while($dataDirector=mysqli_fetch_array($sqlDirector)){
                        $directorId = $dataDirector['director_fk'];
                        $directorDetails = mysqli_query($connect,"SELECT * FROM director WHERE director_id='$directorId'");
                        while($directorDetailsRow = mysqli_fetch_array($directorDetails)){
                            echo "<div class='directorDetails'>";
                            $directorImage = '../directorImages/' . $directorDetailsRow['image'];
                            echo "<div class='directorPhoto'>";
                            echo "<img class='directorPhotoImg' src='$directorImage' alt='' >";
                            echo "</div>";
                            echo $directorDetailsRow['name'] . " ";
                            echo $directorDetailsRow['surname'];
                            echo "</div>";
                        }
                    }
                }
                ?>
            </div>
            <div class="actors">
                <div class="actorsText">
                    Cast of actors:
                </div>
                <?php
                if($_SESSION['admin']==true){
                    ?>
                    <form action="addActorMovie.php" method="post" class="addActor">
                        <input type="hidden" value="<?php echo $id ?>" name="movieId">
                        <label for="actors"></label><select name="actors" id="actors">
                            <?php
                            $sqlAcctors = mysqli_query($connect, "SELECT * FROM actor");
                            while($rowOfActors = mysqli_fetch_array($sqlAcctors)){
                                ?>
                                <option value=<?php echo $rowOfActors['actor_id'] ?>><?php echo $rowOfActors['name'] . " " . $rowOfActors['surname']  ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <button type="submit" name="addActor">Add actor</button>
                    </form>
                <?php
                }
                $selectActors = mysqli_query($connect,"SELECT * FROM movie_actor WHERE movie_fk='$id'");
                if((mysqli_num_rows($selectActors))==0){
                    echo "This movie doesn't have any actors added yet :/";
                }else {
                    while ($dataActor = mysqli_fetch_array($selectActors)) {
                        $actorId = $dataActor['actor_fk'];
                        $actorDetails = mysqli_query($connect, "SELECT * FROM actor WHERE actor_id='$actorId'");
                        while ($actorDetailsRows = mysqli_fetch_array($actorDetails)) {
                            echo "<div class='actorDetails'>";
                            $actorImage = '../actorImages/' . $actorDetailsRows['image'];
                            echo "<div class='actorPhoto'>";
                            echo "<img class='actorPhotoImg' src='$actorImage' alt='' >";
                            echo "</div>";
                            echo $actorDetailsRows['name'] . " ";
                            echo $actorDetailsRows['surname'];
                            echo "</div>";
                        }
                    }
                }
                ?>
            </div>
            <div class="movieLink">
                <a href="<?php echo $data['link'] ?>">Link to worse website</a>
            </div>
            <div class="movieComments">
                <form method="post" action='<?php setComment() ?>'>
                    <input type="hidden" value="<?php echo $id ?>" name="movieID">
                    <input type="hidden" name="uid">
                    <input type="hidden" name="commDate" value="<?php echo date('Y-m-d H:i:s') ?>">
                    <label>
                        <textarea name="comment"></textarea>
                    </label>
                    <div class="commentButton">
                        <button type="submit" name="commentsubmit">Comment</button>
                    </div>
                </form>
                <?php getComments($id); ?>
            </div>
        </div>
    <?php
}
?>
</body>
</html>
