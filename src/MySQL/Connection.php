<?php

namespace App\MySQL;

use PDO;

class Connection
{
    /**
     * @var PDO
     */
    protected $connection;

    /**
     * Connection constructor.
     */
    public function __construct()
    {
        $this->connection = new PDO('mysql:host=localhost;dbname=my_database', 'root', 'root');
    }

    /**
     * @param string $table
     * @param array $data
     * 
     * @return bool
     */
    public function insert(string $table, array $data): bool
    {
        $sql = [];

        $sql[] = "INSERT INTO {$table}";

        $sql[] = '(' . implode(', ', array_keys($data)) . ')';

        $sql[] = 'VALUES';

        $sql[] = '(:' . implode(', :', array_keys($data)) . ')';

        $query = implode(' ', $sql);

        $prepared = $this->connection->prepare($query);

        return $prepared->execute($data);
    }

    /**
     * Insert data and return last inserted id
     * 
     * @param string $table
     * @param array $data
     */
    public function insertGetId(string $table, array $data): int
    {
        $this->insert($table, $data);

        return $this->connection->lastInsertId();
    }

    /**
     * @param string $query
     * @return array
     */
    public function select(string $query, array $data): array
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($data);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}