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
        try {
            $this->pdo = new PDO('mysql:dbname=shopdb2;host=127.0.0.1', 'root');
        } catch (PDOException $e) {
            echo 'подключение к базе данных не удалось'.$e->getMessage();
        }
    }

    /**
     * @param $sql
     * @param array $inputParams
     * @return bool|PDOStatement
     */
    public function query($sql, $inputParams = [])
    {
        $this->pdo->beginTransaction();
        try {
            //пока убираем проверку типов для записи
            //$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $sth = $this->pdo->prepare($sql);
            if (isset($inputParams[':startfor'])) {
                $sth->bindValue(':startfor',$inputParams[':startfor'],PDO::PARAM_INT);
                $sth->bindValue(':nextto',$inputParams[':nextto'],PDO::PARAM_INT);
                $sth->execute();
                $this->pdo->commit();
                return $sth;
            }
            $sth->execute($inputParams);
            $this->pdo->commit();
            return $sth;
        } catch (PDOException $e) {
            echo 'неккоректный запрос'.$e->getMessage();
            $this->pdo->rollBack();
        }
    }
}