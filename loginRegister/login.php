<?php
session_start();

if((!isset($_POST['login']))&&(!isset($_POST['password']))){
    header('Location: loginPage.php');
    exit();
}
require_once 'connect.php';

$connect = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(isset($_POST['loginSubmit'])) {
    if ($connect === false) {
        die("ERROR: Lost connection. " . mysqli_connect_error());
    } else {
        $login = $_POST['login'];
        $password = $_POST['password'];
        if(strlen($login)<=0||strlen($password)<=0){
            $_SESSION['error'] = "Wrong login or password!";
            header('Location: loginPage.php');
        }
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        if ($result = @$connect->query(sprintf("SELECT * FROM users WHERE login='%s'", mysqli_real_escape_string($connect, $login)))) {
            $users_number = $result->num_rows;
            if ($users_number > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {

                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $row['user_id'];
                    if($row['user_id']==1){
                        $_SESSION['admin']=true;
                    }else{
                        $_SESSION['admin']=false;
                    }
                    $_SESSION['login'] = $row['login'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['create_date'] = $row['create_date'];
                    unset($_SESSION['error']);
                    $result->free_result();
                    header('Location: ../HomePage/mainPage.php');
                } else {
                    $_SESSION['error'] = "Wrong login or password!";
                    header('Location: loginPage.php');
                }
            } else {
                $_SESSION['error'] = "Wrong login or password!";
                header('Location: loginPage.php');
            }
        }
        $connect->close();
    }
}