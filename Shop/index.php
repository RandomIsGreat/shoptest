<?php
include_once 'classes/Database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    include_once 'connector.php';
} /*else if ($_SESSION['connected'] != $_COOKIE['connected']) {
    include_once 'connector.php';
}
echo $_SESSION['connected'].' '.$_COOKIE['connected'];
*/$db = Database::getInstance();
if (!isset($_GET['to'])) {
    $goodOnPage=[
            ':startfor'=>0,
            ':nextto'=>5
    ] ;

} else {
    $goodOnPage=[
        ':startfor'=>$_GET['to'],
        ':nextto'=>5
    ] ;
}

$goods = $db->query('SELECT good.id, good.name, category.name As category_name, good.description, good.price 
                        FROM `good` INNER JOIN `category` ON good.category_id = category.id 
                        ORDER BY good.price LIMIT :startfor, :nextto', $goodOnPage);
$result = $goods->fetchAll(PDO::FETCH_ASSOC);

?>


<html>
<head>
    <meta charset="utf-8">
    <title>Товары</title>
</head>
<body>
<table border="2px">
    <tr>
        <td>Наименование</td>
        <td>Категория</td>
        <td>Описание</td>
        <td>Цена</td>
        <td>Добавить в корзину</td>
        <td>Оставить комментарий</td>
    </tr>
    <?php foreach ($result as $item): ?>
    <tr>
        <td><?= $item['name'] ?></td>
        <td><?= $item['category_name'] ?></td>
        <td><?= $item['description'] ?></td>
        <td><?= $item['price'] ?></td>
        <td><a href="addtoorder.php?id=<?= $item['id'] ?>">Добавить в корзину</a></td>
        <td><a href="gooddescription.php?id=<?= $item['id']?>">Описание товара</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<div><a href="index.php?to=<?=$goodOnPage[':startfor']+5 ?>">Следующие 5 товаров</a><br></div>
<div><a href="addadress.php">Добавить адрес для доставки</a><br></div>
<div><a href="conformorder.php">Перейти в корзину</a></div>
<div><a href="profile.php">Профиль</a></div>
</body>
</html>