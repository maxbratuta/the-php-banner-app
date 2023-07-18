<?php

namespace App\Infrastructure;

use PDO;
use PDOStatement;
use RuntimeException;

class Database
{
    private PDO $connection;

    public function __construct(
        private string $dsn,
        private string $username,
        private string $password
    ) {
        //
    }

    public static function createFromConfigFile(string $filename): self
    {
        $config = json_decode(file_get_contents($filename), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(json_last_error_msg());
        }

        return new self(
            $config['dsn'],
            $config['username'],
            $config['password']
        );
    }

    public function prepare(string $query): PDOStatement|false
    {
        return $this->getConnection()->prepare($query);
    }

    public function startTransaction(): void
    {
        $this->getConnection()->beginTransaction();
    }

    public function commit(): void
    {
        $this->getConnection()->commit();
    }

    public function rollback(): void
    {
        $this->getConnection()->rollBack();
    }

    private function getConnection(): PDO
    {
        if (!isset($this->connection)) {
            $this->connection = new PDO(
                $this->dsn,
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }

        return $this->connection;
    }
}
