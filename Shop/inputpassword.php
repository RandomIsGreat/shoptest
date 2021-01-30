<?php
if(isset($_SESSION['connected'])) {
    unset($_SESSION['connected']);
}
if(isset($_COOKIE['connected'])) {
    unset($_COOKIE['connected']);
}
session_start();
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Введите логин и пароль</title>
</head>
<body>
    <form action="connector.php" method="post">
        <p>Логин</p><input type="email" name="user"><br>
        <p>Пароль</p><input type="password" name="pass"><br>
        <input type="submit" value="Войти"><br>
    </form>
<a href="new_account.php">Создать новый аккаунт</a>
</body>
</html>
