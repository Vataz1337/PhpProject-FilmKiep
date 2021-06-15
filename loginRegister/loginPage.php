<?php
session_start();
if((isset($_SESSION['loggedin']))&&($_SESSION['loggedin']==true)){
    header('Location: ../HomePage/mainPage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/loginStyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
</head>
<body>
<div class="mainContainer">
    <div class="loginText">
        LOGIN
    </div>
<form action="login.php" method="post">
    <div class="loginBox">
        <div class="login">
            <div class="loginInput">
                <label>
                    <input name="login" type="text" pattern="[a-zA-Z0-9 ]+" placeholder="Username">
                </label>
            </div>
        </div>
        <div class="password">
            <div class="passwordInput">
                <label>
                    <input name="password" type="password" placeholder="Password">
                </label>
            </div>
        </div>
        <div class="buttons">
            <div class="loginButton">
                <input type="submit" value="Login" id="button" name="loginSubmit">
            </div>
            <div class="registerButton">
               <input type="button" onClick="window.location.href='register.php'" id="button" value="Register">
            </div>
        </div>
            <?php
            if(isset($_SESSION['error']))
                echo '<div class=error>' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error'])
            ?>
    </div>
</form>
</div>
</body>
</html>