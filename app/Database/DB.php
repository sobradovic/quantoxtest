<?php

namespace App\Database;

use PDO;

class DB
{
    protected $pdo;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db   = 'quantoxtest';
        $user = 'root';
        $pass = 'root';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
             $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
             throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function get(string $tableName, array $parameters, string $operator1 = 'AND', string $operator2 = '='): array
    {
        $where = '';

        if (!empty($parameters)) {
            $where .= ' WHERE ';
            $parameters2 = [];

            foreach ($parameters as $field => $value) {
                $parameters2[] = "$field $operator2 ?";
            }

            $where .= implode(" $operator1 ", $parameters2);
        }

        $sql = 'SELECT * FROM ' . $tableName . $where;

        $newParams = array_values($parameters);

        if ($operator2 === 'LIKE') {
            $newParams = array_map(function ($item) {
                return "%$item%";
            }, $newParams);
        }

        $q = $this->pdo->prepare($sql);
        $q->execute($newParams);

        $results = $q->fetch() ?: [];

        return $results;
    }

    public function insert(string $tableName, array $data): bool
    {
        unset($data['id']);
        unset($data['created_at']);

        $keys = array_keys($data);
        $fieldNames = implode(',', array_map(function ($item) {
            return ":$item";
        }, $keys));
        $keys = implode(',', $keys);

        $sql = "INSERT INTO $tableName ($keys) VALUES ($fieldNames)";

        $q = $this->pdo->prepare($sql);
        $q->execute($data);

        return true;
    }
}
