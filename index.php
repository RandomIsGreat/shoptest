<?php
include_once 'classes/Database.php';
session_start();
if (!isset($_COOKIE['connected'])) {
    include_once 'connector.php';
} else if ($_SESSION['connected'] != $_COOKIE['connected']) {
    include_once 'connector.php';
}
echo $_SESSION['connected'].' '.$_COOKIE['connected'];
$db = Database::getInstance();
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

$goods = $db->query('SELECT good.id, good.name, category.name As category_name, good.description, good.price FROM `good` INNER JOIN `category` ON good.category_id = category.id ORDER BY good.price LIMIT :startfor, :nextto', $goodOnPage);
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
    <tr>
        <td><?= $result[0]['name'] ?></td>
        <td><?= $result[0]['category_name'] ?></td>
        <td><?= $result[0]['description']?></td>
        <td><?= $result[0]['price']?></td>
        <td><a href="addtoorder.php?id=<?= $result[0]['id'] ?>">Добавить в корзину</a></td>
        <td>
            <FORM action="addcomment.php?id=<?= $result[0]['id']?>" method="post">
                <p>Комментарий</p><input type="text" name="comment"><br>
                <p>Оценка</p><select name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option selected value="5">5</option>
                </select>
                <input type="submit" value="Оставить комментарий">
            </FORM>
        </td>
    </tr>
    <tr>
        <td><?= $result[1]['name'] ?></td>
        <td><?= $result[1]['category_name']?></td>
        <td><?= $result[1]['description']?></td>
        <td><?= $result[1]['price']?></td>
        <td><a href="addtoorder.php?id=<?= $result[1]['id'] ?>">Добавить в корзину</a></td>
        <td>
            <FORM action="addcomment.php?id=<?= $result[1]['id']?>" method="post">
                <p>Комментарий</p><input type="text" name="comment"><br>
                <p>Оценка</p><select name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option selected value="5">5</option>
                </select>
                <input type="submit" value="Оставить комментарий">
            </FORM>
        </td>
    </tr>
    <tr>
        <td><?= $result[2]['name'] ?></td>
        <td><?= $result[2]['category_name']?></td>
        <td><?= $result[2]['description']?></td>
        <td><?= $result[2]['price']?></td>
        <td><a href="addtoorder.php?id=<?= $result[2]['id'] ?>">Добавить в корзину</a></td>
        <td>
            <FORM action="addcomment.php?id=<?= $result[2]['id']?>" method="post">
                <p>Комментарий</p><input type="text" name="comment"><br>
                <p>Оценка</p><select name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option selected value="5">5</option>
                </select>
                <input type="submit" value="Оставить комментарий">
            </FORM>
        </td>
    </tr>
    <tr>
        <td><?= $result[3]['name'] ?></td>
        <td><?= $result[3]['category_name']?></td>
        <td><?= $result[3]['description']?></td>
        <td><?= $result[3]['price']?></td>
        <td><a href="addtoorder.php?id=<?= $result[3]['id'] ?>">Добавить в корзину</a></td>
        <td>
            <FORM action="addcomment.php?id=<?= $result[3]['id']?>" method="post">
                <p>Комментарий</p><input type="text" name="comment"><br>
                <p>Оценка</p><select name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option selected value="5">5</option>
                </select>
                <input type="submit" value="Оставить комментарий">
            </FORM>
        </td>
    </tr>
    <tr>
        <td><?= $result[4]['name'] ?></td>
        <td><?= $result[4]['category_name']?></td>
        <td><?= $result[4]['description']?></td>
        <td><?= $result[4]['price']?></td>
        <td><a href="addtoorder.php?id=<?= $result[4]['id'] ?>">Добавить в корзину</a></td>
        <td>
            <FORM action="addcomment.php?id=<?= $result[4]['id']?>" method="post">
                <p>Комментарий</p><input type="text" name="comment"><br>
                <p>Оценка</p><select name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option selected value="5">5</option>
                </select>
                <input type="submit" value="Оставить комментарий">
            </FORM>
        </td>
    </tr>
</table>
<div><a href="index.php?to=<?=$goodOnPage[':startfor']+5 ?>">Следующие 5 товаров</a><br></div>
<div><a href="addadress.php">Добавить адрес для доставки</a><br></div>
<div><a href="conformorder.php">Перейти в корзину</a></div>
</body>
</html>