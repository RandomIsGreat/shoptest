<?php
include_once 'classes/Database.php';
include_once 'classes/Connector.php';
session_start();
if (!isset($_POST['pass']) && !isset($_POST['user']))
{
    header("Location: inputpassword.php");
    echo 'ниче не передалось';
}
/*if (!isset($_SESSION['password'])) {
    $_SESSION['password'] = $_POST['pass'];
}
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = $_POST['user'];
}*/

$db = Database::getInstance();
/** @var Connector $connection */
$connection = new Connector($_POST['user'], $_POST['pass'], $db, [':email'=> $_POST['user']]);
$connection -> setQuery();

/*$sth = $db->query('SELECT `password` FROM `user` where email = :email', [':email'=> $_SESSION['user']]);
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$resultPass = $result['0'];
if ($_SESSION['password'] != $resultPass['password']) {
    session_destroy();
    header("Location: inputpassword.php");
}
else {
    setcookie('connected', true, time()+3600 );
    header("Location: index.php");
} */
    //echo "ZLUL ".$_SESSION['user'].$_SESSION['password'].$resultPass['password'];
//print_r($result);
