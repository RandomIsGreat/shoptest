<?php


class AdressCreator extends Connector
{
    protected function runQuery($postName, $postPassword, Database $db, $inputParams = [])
    {
        /*$sth = $db->query('SELECT `id` FROM `user` where email = :email', [':email'=>$postName]);
        $result = $sth->fetchAll();
        $tmp = $result['0'];*/
        $id[':user'] = $_SESSION['user_id'];
        $db->query('INSERT INTO `adress` (city, country, street, house_number, apartment_number, user_id)
                         VALUES (?, ?, ?, ?, ?, ?)', $inputParams);
        /*$sth = $db->query('SELECT `id` FROM `adress` ORDER BY create_on DESC LIMIT 1',[]);
        $result =$sth->fetchAll();
        $tmp = $result['0'];
        $id[':adress'] = $tmp['id'];
        $db->query('INSERT INTO `user_adres` (user_id, adress_id) VALUES (:user, :adress)',$id);*/
        $this->connectedRedirect(1);
    }
    protected function connectedRedirect($id)
    {
        header("Location: index.php");
    }
}