<?php
    include_once 'classes/Database.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
        include_once 'connector.php';
    }
    $db = Database::getInstance();
    $sth = $db->query('SELECT `id` FROM `orders` WHERE user_id = ?', [$_SESSION['user_id']]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    if ($result == null) {
        $db->query('INSERT INTO `orders` (user_id) VALUES (?)', [$_SESSION['user_id']]);
        $sth = $db->query('SELECT `id` FROM `orders` WHERE user_id = ?', [$_SESSION['user_id']]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    $sth = $db->query('SELECT `name`,`description`,`price` FROM `good` WHERE good.id = ?',[$_GET['id']]);
    $good = $sth->fetchAll(PDO::FETCH_ASSOC);
    $db->query('INSERT INTO `order_items` (current_order_id, name, description, price)
                    VALUES (?,?,?,?)',[$result[0]['id'], $good[0]['name'], $good[0]['description'],$good[0]['price']]);
    header('Location: index.php');
