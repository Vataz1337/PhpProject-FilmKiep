<?php
function setComment(){
    if(isset($_POST['commentsubmit'])){
        require_once "../loginRegister/connect.php";
        $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $uid =  $_SESSION['user_id'];
        $movieID = $_POST['movieID'];
        $date = $_POST['commDate'];
        $comment = htmlentities($_POST['comment']);

        $sql = "INSERT INTO comment (movie_fk, users_fk, comment, comment_date) VALUES ('$movieID', '$uid', '$comment', '$date')";
        $connect->query($sql);
    }
}

function getComments($id){
    require_once "../loginRegister/connect.php";
    $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "SELECT * FROM comment where movie_fk = '$id'";
    $result = $connect->query($sql) or die($connect->error);
    while($row = $result->fetch_assoc()){
        echo "<div class='commentBox'><p>";
        echo $row['comment_date'] . "</br></br>";
        echo nl2br($row['comment']);
        echo "</p>";
            if($_SESSION['admin']==true){
                ?>
                <form  class="delete-form" method="post" action='deleteComment.php'>
                    <input type='hidden' name='userId' value="<?php echo $row['users_fk'] ?>">
                    <input type='hidden' name='movieId' value="<?php echo $row['movie_fk'] ?>">
                    <input type='hidden' name='commentDate' value="<?php echo $row['comment_date'] ?>">
                    <button name="commentDelete" type="submit">DELETE</button>
                </form>
                <form  class="edit-form" method="post" action="editComment.php">
                <input type='hidden' name='userId' value="<?php echo $row['users_fk'] ?>">
                <input type='hidden' name='movieId' value="<?php echo $row['movie_fk'] ?>">
                <input type='hidden' name='comment' value="<?php echo $row['comment'] ?>">
                <input type='hidden' name='commentDate' value="<?php echo $row['comment_date'] ?>">
                <button>EDIT</button>
                </form>
                <?php
            }
        echo "</div>";
    }
}

function editComments(){
    if(isset($_POST['editSubmit'])){
        require_once "../loginRegister/connect.php";
        $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $uid = $_POST['userId'];
        $movieID = $_POST['movieId'];
        $date = $_POST['commentDate'];
        $comment = htmlentities($_POST['comment']);

        $sql = "UPDATE comment SET comment='$comment' WHERE users_fk='$uid' AND movie_fk='$movieID' AND comment_date='$date'";
        $connect->query($sql);
        header("Location: movieDetails.php?id=$movieID");
    }
}


