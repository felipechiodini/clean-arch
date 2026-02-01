<?php

namespace App\CircuitBreaker;

use App\MySQL\Connection;
use FelipeChiodini\CircuitBreaker\Contracts\Repository as ContractsRepository;
use PDO;

class Repository implements ContractsRepository
{
    private $pdo;
    public function __construct(
        protected Connection $connection,
    ) {
        $this->pdo = new PDO('mysql:host=localhost;dbname=my_database', 'root', 'root');
    }

    public function tries(string $key): int
    {
        $result = $this->connection->select(
            'SELECT tries FROM circuit_breaker WHERE `key` = ?',
            [$key]
        );

        return $result[0]['tries'] ?? 0;
    }

    public function incrementTry(string $key): void
    {
        $this->pdo->prepare('INSERT INTO circuit_breaker (`key`, tries) VALUES (?, 1) ON DUPLICATE KEY UPDATE tries = tries + 1')
            ->execute([$key]);
    }

    public function reset(string $key): void
    {
        $this->pdo->prepare('INSERT INTO circuit_breaker (`key`, tries) VALUES (?, 0) ON DUPLICATE KEY UPDATE tries = 0, last_failure_at = null')
            ->execute([$key]);
    }

    public function timeout(string $key): int
    {
        $result = $this->connection->select(
            'SELECT TIMESTAMPDIFF(SECOND, last_failure_at, now()) AS `timeout` FROM circuit_breaker WHERE `key` = ?',
            [$key]
        );

        return $result[0]['timeout'] ?? 0;
    }
}