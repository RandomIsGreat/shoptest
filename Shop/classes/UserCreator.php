<?php


class UserCreator extends Connector
{
    protected function runQuery($postName, $postPassword, Database $db, $inputParams = [])
    {
        $firstInput[':email'] = $inputParams[':email'];
        $sth = $db->query('SELECT `email` FROM `user` WHERE email = :email', $firstInput);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result !== []) {
            session_destroy();
            header('Location: new_account.php');
        } else {
            $db->query('INSERT INTO `user` (email, password) VALUES (:email, :password)', $inputParams);
            $this->connectedRedirect();
        }
    }
}