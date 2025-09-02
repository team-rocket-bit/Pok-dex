<?php

namespace Database;

class Database
{
    private string $host;
    private string $name;
    private string $user;
    private string $pass;

    public function __construct(string $host, string $name, string $user, string $pass)
    {
        $this->host = $host;
        $this->name = $name;
        $this->user = $user;
        $this->pass = $pass;
    }

    public function getConnection(): \PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->name}";

        return new \PDO($dsn, $this->user, $this->pass);
    }
}
