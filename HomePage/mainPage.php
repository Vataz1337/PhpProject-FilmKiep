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
    <title>FilmKiep</title>
    <link rel="stylesheet" href="../CSS/mainPageStyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="../glide/dist/css/glide.core.css">
    <link rel="stylesheet" href="../glide/dist/css/glide.theme.css">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
</head>
    <body>
    <div class="mainContainer">
    <div class="logoBrowser">
        <div class="logo">
            <img src="../Images/filmkiep.png" alt="Logo">
        </div>
        <div class="title">
            FILMKIEP
        </div>
        <div class="browserImage_browserInput">
            <div class="browserImage">
                <img src="../Images/loopka.png" alt="loopka">
            </div>
            <div class="browser">
                <label><input type="text" name="browser"></label>
            </div>
        </div>
        <div class="welcome">
        <?php
        echo "<p> Welcome " . $_SESSION['login'] . " [<a href='../loginRegister/logout.php'>Logout</a>]</p>";
        ?>
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
    <div class="categories">
        <div class="slider">
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <li class="glide__slide"><img src="../Images/drama.jpg" alt="submit" ></li>
                        <li class="glide__slide"><img src="../Images/anime2.gif" alt="submit" ></li>
                        <li class="glide__slide"><img src="../Images/action.jpg" alt="submit" ></li>
                        <li class="glide__slide"><img src="../Images/horror.jpg" alt="submit"></li>
                    </ul>
                </div>
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">prev</button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">next</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
    <script>
        const config = {
            type: 'carousel',
            startAt: 0,
            perView: 3,
            focusAt: 'center',
            gap: 40
        }
        new Glide('.glide', config).mount()
    </script>
    </body>
</html>
