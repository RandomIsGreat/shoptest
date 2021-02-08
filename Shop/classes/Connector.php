<?php

//include_once 'iAdapter.php';

class Connector
{
    private $name;

    private $password;

    private $params = [];

    public $db;

    public function setQuery()
    {
        // TODO: Implement setQuery() method.
        $this->runQuery($this->name, $this->password, $this->db, $this->params);

    }

    protected function runQuery($postName, $postPassword, Database $db, $inputParams = [])
    {
        $sth = $db->query('SELECT `password`,`id` FROM `user` where email = :email', $inputParams);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $resultPass = $result['0'];
        if ($postPassword != $resultPass['password']) {
            session_destroy();
            header("Location: inputpassword.php");
        }
        else {
            $this->connectedRedirect($resultPass['id']);
        }
    }

    protected function connectedRedirect($id)
    {
        $tmp = md5($this->name.time().rand(0,999));
        //md5($this->name.time().rand(0,999));
        unset($_COOKIE['connected']);
        setcookie('connected', $tmp , time()+3600 );
        $_SESSION['connected'] = $tmp;
        $_SESSION['user_id'] = $id;
        $_SESSION['user'] = $this->name;
        $_SESSION['password'] = $this->password;
        header("Location: index.php");
    }

    public function __construct($postName, $postPassword, $db, $inputParams = [])
    {
            $this->name = $postName;
            $this->password = $postPassword;
            $this->params = $inputParams;
            $this->db = $db;
    }

}