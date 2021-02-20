<?php
include_once 'classes/Database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    include_once 'connector.php';
}
$db = Database::getInstance();
$sth = $db->query('SELECT order_items.name, order_items.description, order_items.price FROM `order_items`
                        INNER JOIN `orders` ON order_items.current_order_id = orders.id 
                        WHERE orders.user_id = ?',[$_SESSION['user_id']]);
$orderItems = $sth->fetchAll(PDO::FETCH_ASSOC);
$sth = $db->query('SELECT SUM(order_items.price) as summary FROM `order_items`
                        INNER JOIN `orders` ON order_items.current_order_id = orders.id 
                        WHERE orders.user_id = ?',[$_SESSION['user_id']]);
$summary = $sth->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
<head>
    <meta charset="utf-8">
    <title>Подтверждение заказа</title>
</head>
<body>
<p>Подтвердите ваш заказ</p>
<table border="2px">
    <tr>
        <td>Наименование</td>
        <td>Описание</td>
        <td>Цена</td>
    </tr>
    <?php foreach ($orderItems as $item): ?>
    <tr>
        <td><?= $item['name'] ?></td>
        <td><?= $item['description'] ?></td>
        <td><?= $item['price'] ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td>Итоговая цена: <?= $summary[0]['summary'] ?></td>
    </tr>
</table>
<div><a href="index.php">На главную</a><br></div>
</body>
</html>
