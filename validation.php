<?php
$name = 'user';
$password = '123';
if ($_POST['login']==$name && $_POST['password']==$password) {
    session_start();
    $_SESSION['name']=$name;
    header('Location: /mainpage.php');
} else {
    echo "<a href='login.html'>Try again</a>";
}