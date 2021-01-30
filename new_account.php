<?php
session_start();
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Введите логин и пароль</title>
</head>
<body>
<form action="creator.php" method="post">
    <p>Введите ваш адрес электронной почты</p><input type="email" name="user"><br>
    <p>Введите ваш пароль</p><input type="password" name="pass"><br>
    <input type="submit" value="Создать"><br>
</form>
</body>
</html>