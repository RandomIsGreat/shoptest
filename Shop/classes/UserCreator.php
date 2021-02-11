<?php


class UserCreator extends Connector
{
    protected function runQuery($postName, $postPassword, Database $db, $inputParams)
    {
        $firstInput = $inputParams[0];
        $sth = $db->query('SELECT `email` FROM `user` WHERE email = ?', [$firstInput]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result !== []) {
            session_destroy();
            header('Location: new_account.php');
        } else {
            $db->query('INSERT INTO `user` (email, password) VALUES (?, ?)', $inputParams);
            $sth = $db->query('SELECT `id` FROM `user` ORDER BY create_on DESC LIMIT 1',[]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            $this->connectedRedirect($result[0]['id']);
        }
    }
}