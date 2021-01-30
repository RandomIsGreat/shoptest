<?php
    include_once 'classes/Database.php';
    session_start();
    if (!isset($_COOKIE['connected']) && ($_SESSION['connected']) !== $_COOKIE['connected']) {
        include_once 'connector.php';
    }
    $db = Database::getInstance();
    $sth = $db->query('SELECT id from `user` where email = :name',[':name'=>$_SESSION['user']]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    $id[':user_id'] = $result[0]['id'];
    $sth = $db->query('SELECT order_id FROM `user_order` WHERE user_id = :user_id ORDER BY order_id DESC LIMIT 1',$id);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    if (!isset($result[0]['order_id'])) {
        $tmp = $db->query('SELECT current_order_id FROM `orders` ORDER BY create_on DESC LIMIT 1',[]);
        $res = $tmp->fetchAll(PDO::FETCH_ASSOC);
        if (!isset($res[0]['current_order_id'])){
            $db->query('INSERT INTO `orders` (current_order_id) VALUES (1)',[]);
            $id[':order_id'] = 1;
            $db->query('INSERT INTO `user_order` (user_id, order_id) VALUES (:user_id, order_id)',$id);
            $_SESSION['current_order'] = $id[':order_id'];
            $_SESSION['order'] = $id[':order_id'];
            //далее добавлять непосредственно заказ передачей гета айдишника
            //добавить куки для связи клиента с сервером шоб не проводить такую дичь несколько раз
        } else {
            $tmpp[':current_order_id'] = $res[0]['current_order_id'] + 1;
            //$tmpp[':current_order_id'] = $id[':id_order'];
            $db->query('INSERT INTO `orders` (current_order_id) VALUES (:current_order_id)',$tmpp);
            $sth = $db->query('SELECT `id` FROM `orders` ORDER BY create_on DESC LIMIT 1',[]);
            $re = $sth->fetchAll();
            $id[':order_id'] = $re['0']['id'];
            $db->query('INSERT INTO `user_order` (user_id, order_id) VALUES (:user_id, :order_id)',$id);
            $_SESSION['current_order'] = $tmpp[':current_order_id'];
            $_SESSION['order_id'] = $id[':order_id'];
            setcookie('current_order', $_SESSION['current_order'], time()+3600);
            setcookie('order_id', $_SESSION['order_id'], time()+3600);
            //далее добавлять непосредственно заказ передачей гета айдишника
            //добавить куки для связи клиента с сервером шоб не проводить такую дичь несколько раз
        }
    } else {
        $id[':order_id'] = $result[0]['order_id'];
        $tmp[':order_id'] = $result[0]['order_id'];
        $sth = $db->query('SELECT current_order_id FROM `orders` WHERE id = :order_id', $tmp);
        $re = $sth->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['current_order'] = $re[0]['current_order_id'];
        $_SESSION['order_id'] = $id[':order_id'];
        setcookie('current_order', $_SESSION['current_order'], time()+3600);
        setcookie('order_id', $_SESSION['order_id'], time()+3600);
        //далее добавлять непосредственно заказ передачей гета айдишника
        //добавить куки для связи клиента с сервером шоб не проводить такую дичь несколько раз
    }
    $sth = $db->query('SELECT name, description, price FROM `good` WHERE id = :id',[':id'=>$_GET['id']]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    $addToOrder = [
        ':current_order_id'=>$_SESSION['current_order'],
        ':name'=>$result[0]['name'],
        ':description'=>$result[0]['description'],
        ':price'=>$result[0]['price']
    ];
    $db->query('INSERT INTO `current_order` (current_order_id, name, description, price) 
                                VALUES (:current_order_id, :name, :description, :price)', $addToOrder);
    header('Location: index.php');
    //по идее тут нужн описать класс, который бы добавил через значение нужный айтем в ордер что-то типа
    // SELECT name, description, price FROM `good` WHERE id = :id, [':id'=>$_GET['id']];
    // бахнуть это в асс массив и потом заинсертить с известным значением куррент_ордера
    // INSERT INTO `current_order` (current_order_id, name, description, price) VALUES (:current_order_id, :name, :description, :price)
