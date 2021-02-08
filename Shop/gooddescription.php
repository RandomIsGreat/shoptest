<?php
include_once 'classes/Database.php';
session_start();
if (!isset($_COOKIE['connected'])) {
    include_once 'connector.php';
} else if ($_SESSION['connected'] != $_COOKIE['connected']) {
    include_once 'connector.php';
}
//по гету передается номер товара, который выводится
$db = Database::getInstance();
$sth = $db->query('SELECT good.name, category.name As category_name, good.description, good.price FROM `good` 
                       INNER JOIN `category` ON good.category_id = category.id 
                       WHERE good.id = :id', [':id'=>$_GET['id']]);
$good = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $db->query('SELECT user.email, comment.id, comment.comment, comment.rating FROM comment INNER JOIN `user` ON comment.user_id = user.id WHERE comment.good_id = :id',[':id'=>$_GET['id']]);
$comments = $sth->fetchAll(PDO::FETCH_ASSOC);

/*$i = 0;
foreach ($comments as $item) {

    $id[$i] = $item['id'];
    $i++;
}
$c = 0;
foreach ($id as $item) {
    $sth = $db->query('SELECT user.email FROM `user` INNER JOIN `user_comment` ON user.id = user_comment.user.id WHERE comment_id = :id', [':id'=>$item]);
    $temp = $sth->fetchAll(PDO::FETCH_ASSOC);
    $comments[$c]['email'] = $temp[$c]['email'];
    $c++;
}*/
?>

<html>
<head>
    <meta charset="utf-8">
    <title><?= $good[0]['name'] ?></title>
</head>
<body>
<table border="2px">
    <tr>
        <td>Имя</td>
        <td>Категория</td>
        <td>Описание</td>
        <td>Цена</td>
        <td>Добавить в корзину</td>
    </tr>
    <tr>
        <td><?= $good[0]['name'] ?></td>
        <td><?= $good[0]['category_name'] ?></td>
        <td><?= $good[0]['description'] ?></td>
        <td><?= $good[0]['price'] ?></td>
        <td><a href="addtoorder.php?id=<?= $_GET['id'] ?>">Добавить в корзину</a></td>
    </tr>
</table>
<br>
<p>Комментарии</p>
<table border="2px">
    <tr>
        <td>Email отправителя</td>
        <td>Комментарий</td>
        <td>Рейтинг</td>
    </tr>

    <?php foreach ($comments as $item): ?>
    <tr>

        <td><?= $item['email'] ?></td>
        <td><?= $item['comment'] ?></td>
        <td><?= $item['rating'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
