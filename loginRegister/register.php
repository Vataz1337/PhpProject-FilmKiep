<?php
session_start();
if((isset($_SESSION['loggedin']))&&($_SESSION['loggedin']==true)){
    header('Location: ../HomePage/mainPage.php');
    exit();
}
if(isset($_POST['email'])){
    $check=true;
    $login = $_POST['login'];
    $password1=$_POST['password1'];
    $password2=$_POST['password2'];
    $email=$_POST['email'];

    if($password1!=$password2){
        $check=false;
        $_SESSION['errorRegister']="Passwords are not identical!";
    }

    $passwordHash = password_hash($password1, PASSWORD_DEFAULT);

    $secret = "6LduzvwaAAAAAAtxSx5Db5v22kPGXCHdmhKus5Ee";

    $check_secret = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);

    $responce = json_decode($check_secret);

    if($responce->success==false){
        $check=false;
        $_SESSION['errorRegister']="Confirm you are not a bot!";
    }

    if(strlen($login)<=0 || strlen($password1)<=0 || strlen($password2)<=0 || strlen($email)<=0){
        $_SESSION['errorRegister'] ="Don't leave empty fields!";
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try{
        $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if($connect->connect_errno!=0) {
           throw new Exception(mysqli_connect_errno());
        }
        else{
            $result = $connect->query("SELECT user_id FROM users WHERE email='$email'");
            if(!$result) throw new Exception($connect->error);
            $how_many_emails = $result->num_rows;
            if($how_many_emails>0){
                $check=false;
                $_SESSION['errorRegister']="Account associated with this e-mail already exists!";
            }
            $result = $connect->query("SELECT user_id FROM users WHERE login='$login'");
            if(!$result) throw new Exception($connect->error);
            $how_many_logins = $result->num_rows;
            if($how_many_logins>0){
                $check=false;
                $_SESSION['errorRegister']="Account associated with that login already exists!";
            }
            if($check==true){
                $date = date("Y-m-d");
                if($connect->query("INSERT INTO users VALUES (NULL, '$login', '$passwordHash', '$email', '$date')")){
                    $_SESSION['registered'] = true;
                    header('Location: loginPage.php');
                }
                else{
                    throw new Exception($connect->error);
                }
            }
            $connect->close();
        }

    }catch (Exception $e){
        echo "Connection error!";
    }
}
?>
<!DOCTYPE html>
<html lang="Pl">
<head>
    <meta charset="utf-8" />
    <title>Rejestracja</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <link rel="stylesheet" href="../CSS/registerStyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../Images/filmkiep.png">
</head>
<body>
<div class="mainContainer">
<form method="post">
    <div class="registerBox">
        <div class="registerText">
            REGISTER
        </div>
        <div class="loginInput">
            <label><input name="login" placeholder="Username" type="text" minlength="3" maxlength="50"  pattern="[a-zA-Z0-9 ]+"></label>
        </div>
        <div class="password">
            <label><input name="password1" placeholder="Password" type="password" minlength="8" maxlength="20"></label>
        </div>
        <div class="password">
            <label><input name="password2" placeholder="Repeat password" type="password" minlength="8" maxlength="20"></label>
        </div>
        <div class="loginText">
            <label><input name="email" placeholder="Email" type="email"></label>
        </div>
        <div class="robot">
            <div class="g-recaptcha" data-sitekey="6LduzvwaAAAAAGjVjOYSj0Vins1r6CM3VM67zSAZ"></div>
        </div>
        <div class="buttons">
            <div class="registerButton">
                <input type="submit" value="Register" id="button">
            </div>
            <div class="loginLinkButtom">
                <input type="button" onClick="window.location.href='loginPage.php'" id="button" value="Login">
            </div>
        </div>
        <?php
        if(isset($_SESSION['errorRegister'])){
            echo '<div class ="error">' . $_SESSION['errorRegister'] . '</div>';
            unset($_SESSION['errorRegister']);
        }
        ?>
    </div>
</form>
</div>
</body>