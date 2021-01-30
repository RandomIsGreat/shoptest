<?php
    include_once 'classes/Database.php';
    include_once 'classes/Connector.php';
    include_once 'classes/AdressCreator.php';
    session_start();
    if (!isset($_COOKIE['connected'])) {
        include_once 'connector.php';
    }
    if (isset($_POST['city'])) {
        $params = [
            ':city'=>$_POST['city'],
            ':country'=>$_POST['country'],
            ':street'=>$_POST['street'],
            ':house_number'=>$_POST['house_number'],
            ':apartment_number'=>$_POST['apartment_number']
        ];
        $db = Database::getInstance();
        $adress = new AdressCreator($_SESSION['user'], $_SESSION['password'], $db, $params);
        $adress->setQuery();
    }

    ?>

<html>
<head>
    <meta charset="utf-8">
    <title>Введите адрес</title>
</head>
<body>
    <form action="addadress.php" method="post">
        <p>Город</p><input type="text" name="city"><br>
        <p>Страна</p><input type="text" name="country"><br>
        <p>Улица</p><input type="text" name="street"><br>
        <p>Номер дома</p><input type="text" name="house_number"><br>
        <p>Номер квартиры</p><input type="text" name="apartment_number"><br>
        <input type="submit" value="Добавить адрес"><br>
    </form>
</body>
</html>