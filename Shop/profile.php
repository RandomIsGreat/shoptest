<?php
include_once 'classes/Database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    include_once 'connector.php';
}
$db = Database::getInstance();
if (isset($_FILES['pic']))
{
    if ($_FILES['pic']['error'] == 0) {
        $tmpName = $_FILES['pic']['tmp_name'];
        $savePathToBd = "photo/".microtime().'.'.pathinfo($_FILES['pic']['name'])['extension'];
        $savePathToBd = str_replace(' ','', $savePathToBd);
        $directory = "D:/OpenServer/OSPanel/domains/sessiontest/Shop/Shop/".$savePathToBd;
        if (move_uploaded_file($tmpName, $directory)) {
            echo "saved";
            $db->query("INSERT INTO `user_photo` (user_id, photo_url) 
                         VALUES (?, ?)", [$_SESSION['user_id'], $savePathToBd]);
            $sth = $db->query("SELECT photo_url FROM `user_photo` WHERE user_id = ?", [$_SESSION['user_id']]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            $urlOfPhoto = $result[0]['photo_url'];
        } else {
            echo "notSaved";
        }
    } else {
        echo "Upload error:{$_FILES['pic']['error']}";
        $sth = $db->query("SELECT photo_url FROM `user_photo` WHERE user_id = ?", [$_SESSION['user_id']]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if (isset($result[0]['photo_url'])){
            $urlOfPhoto = $result[0]['photo_url'];
        } else {
            $urlOfPhoto = "photo/default.png";
        }
    }
} else {
    $sth = $db->query("SELECT photo_url FROM `user_photo` WHERE user_id = ?", [$_SESSION['user_id']]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    if (isset($result[0]['photo_url'])){
        $urlOfPhoto = $result[0]['photo_url'];
    } else {
        $urlOfPhoto = "photo/default.png";
    }
}


?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Профиль</title>
    </head>
    <body>
    <img src="<?= $urlOfPhoto ?>" width="120px">
    <form method="POST" ENCTYPE="multipart/form-data">
        <input type="file" name="pic">
        <button>Upload</button>
    </form>
    </body>
</html>
