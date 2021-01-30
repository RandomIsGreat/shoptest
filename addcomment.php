<?php
include_once 'classes/Database.php';
session_start();
if (!isset($_COOKIE['connected'])) {
    include_once 'connector.php';
} else if ($_SESSION['connected'] != $_COOKIE['connected']) {
    include_once 'connector.php';
}
//через POST передается содержание комментария, через гет - номер товара
$db = Database::getInstance();
$sth = $db->query('SELECT id from `user` where email = :name',[':name'=>$_SESSION['user']]);
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$id[':user_id'] = $result[0]['id'];
$db->query('INSERT INTO `comment` (comment, rating) VALUES (:comment, :rating)',[':comment'=>$_POST['comment'], ':rating'=>$_POST['rating']]);
$sth = $db->query('SELECT `id` FROM `comment` ORDER BY create_on DESC LIMIT 1',[]);
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$id[':comment_id'] = $result[0]['id'];
$db->query('INSERT INTO `user_comment` (user_id, comment_id) VALUES (:user_id,:comment_id)',$id);
$nid = [
    ':comment_id'=>$id[':comment_id'],
    ':good_id'=>$_GET['id']
];
$db->query('INSERT INTO `user_comments` (comment_id. good_id) VALUES (:comment_id, :good_id)',$nid);
