<?php

class Database
{
    private string $host = 'localhost';
    private string $dbname = 'forum';
    private string $username = 'root';
    private string $password = '';

    private PDO $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function connect(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        $this->connection = new PDO($dsn, $this->username, $this->password);

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $this->connection;
    }
}