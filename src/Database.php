<?php

namespace Reneknox\DatabaseConnector;

use PDOException;
use PDOStatement;
use PDO;

class Database
{
    private PDO $connection;

    private PDOStatement $statement;

    private string $error;

    public function __construct(
        private string $dbHost,
        private string $dbName,
        private string $username,
        private string $password
    )
    {
    }

    public function connect(): self
    {
        $this->connection = new PDO(
            dsn: $this->prepare_dsn(),
            username: $this->username,
            password: $this->password
            , options: [
            PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);
        return $this;
    }

    private function prepare_dsn(): string
    {
        return 'mysql:' . http_build_query(
                data: [
                    'host' => $this->dbHost,
                    'dbname' => $this->dbName,
                    'charset' => 'utf8',
                ],
                numeric_prefix: '&',
                arg_separator: ';'
            );
    }

    public function query(string $query, array $params = []): self
    {
        try {
            $this->statement = $this->connection->prepare($query);
            $this->statement->execute($params);
            return $this;
        } catch (PDOException $exception) {
            $this->error = $exception;
            return $this;
        }
    }

    public function get_error(): string
    {
        return $this->error;
    }

    public function find(): array|false
    {
        return $this->statement->fetch();
    }

    public function get(): array|false
    {
        return $this->statement->fetchAll();
    }

}