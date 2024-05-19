<?php

class Database
{
    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=portofolio', 'root', '');
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function query($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function fetch($query, $params = [])
    {
        return $this->query($query, $params)->fetch();
    }

    public function fetchAll($query, $params = [])
    {
        return $this->query($query, $params)->fetchAll();
    }

    public function execute($query, $params = [])
    {
        $this->query($query, $params);

        return $this->pdo->lastInsertId();
    }
}

$db = new Database();
