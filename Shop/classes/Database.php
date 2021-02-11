<?php


class Database
{
    private static $instances = [];

    private $pdo;

    /**
     * @return mixed|static
     */
    static public function getInstance()

    {
        $className = static::class;
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();

        }

        return self::$instances[$className];
    }

    /**
     * Database constructor.
     */
    protected function __construct()
    {
        $xml = simplexml_load_file("http://localhost/Shop/Shop/dataBaseConnect.xml");
        $dsn = "{$xml->dbtype}:dbname={$xml->dbname};host={$xml->host}";
        $username = (string)$xml->username;
        try {
            $this->pdo = new PDO($dsn, $username);
        } catch (PDOException $e) {
            echo 'Can\'t connect to database'.$e->getMessage();
        }
    }

    /**
     * @param $sql
     * @param array $inputParams
     * @return bool|PDOStatement
     */
    public function query($sql, $inputParams)
    {
        $this->pdo->beginTransaction();
        try {
            $sth = $this->pdo->prepare($sql);
            if (isset($inputParams[':startfor'])) {
                $sth->bindValue(':startfor',$inputParams[':startfor'],PDO::PARAM_INT);
                $sth->bindValue(':nextto',$inputParams[':nextto'],PDO::PARAM_INT);
                $sth->execute();
                $this->pdo->commit();
                return $sth;
            }
            /*$i = 1;
            foreach ($inputParams as $item)
            {
                $sth->bindValue($i, $item, PDO::PARAM_STR);
                $i++;
            }*/
            $sth->execute($inputParams);
            $this->pdo->commit();
            return $sth;
        } catch (PDOException $e) {
            echo 'Invalid query'.$e->getMessage();
            $this->pdo->rollBack();
        }
    }
}