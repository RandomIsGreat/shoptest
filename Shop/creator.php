<?php
include_once 'classes/Database.php';
include_once 'classes/Connector.php';
include_once 'classes/UserCreator.php';
session_start();
$db = Database::getInstance();
$userName = strtolower($_POST['user']);
$user = new UserCreator($userName, $_POST['pass'], $db, [':email'=>$userName, ':password'=>$_POST['pass']]);
$user->setQuery();
/*$sth = $db->query('SELECT `email` FROM `user` WHERE email = :email', [':email'=>$userName]);
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
if ($result !== []) {
    session_destroy();
    header('Location: new_account.php');
} else {
    $db->query('INSERT INTO `user` (email, password) VALUES (:email, :password)', [':email'=>$userName,':password'=>$_POST['pass']]);
}
$_SESSION['user'] = $_POST['user'];
$_SESSION['password'] = $_POST['pass'];*/
//$resultPass = $result['0'];
//print_r($result);
