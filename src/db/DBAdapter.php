<?php

namespace App\db;

use PDO;
use PDOStatement;
class DBAdapter
{
    /**
     * @var PDO
     */
    private $connection;
    /**
     * @var PDOStatement
     */
    private $stmt;

    public function __construct(DB $db)
    {
        $this->connection = $db->connection;
    }

    public function prepareAndExecute(string $statement, array $parameters) : bool
    {
        $this->stmt = $this->connection->prepare($statement);
        return $this->stmt->execute($parameters);
    }

    public function setFetchInto(object $object)
    {
        $this->stmt->setFetchMode(PDO::FETCH_INTO, $object);
    }

    public function setFetchAssoc()
    {
        $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
    }

    public function fetch()
    {
        return $this->stmt->fetch();
    }

    public function fetchAll()
    {
        return $this->stmt->fetchAll();
    }
}