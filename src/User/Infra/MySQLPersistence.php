<?php

namespace App\User\Infra;

use App\MySQL\Connection;
use App\User\UseCases\Contracts\Persistence;

class MySQLPersistence implements Persistence
{
    /**
     * @param Connection $connection
     */
    public function __construct(
        protected Connection $connection
    ) {
    }

    /**
     * perist the user
     * 
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        return $this->connection->insertGetId('users', $data);
    }

    /**
     * @inheritDoc
     */
    public function emailExists(string $email): bool
    {
        $result = $this->connection->select("SELECT * FROM users WHERE email = ?", [$email]);

        return count($result) > 0;
    }
}