<?php

class MySQL implements IDB
{
    private $connection;

    public function connect(
        string $host = "",
        string $username = "",
        string $password = "",
        string $database = ""
    ): ?static {
        $this->connection = mysqli_connect($host, $username, $password, $database);
        return $this;
    }

    public function select(string $query): array {
        $result = mysqli_query($this->connection, $query);
        if (!$result) {
            return [];
        }
    }

    public function insert(string $table, array $data): bool {
        $keys = implode(',', array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $query = "INSERT INTO $table ($keys) VALUES ($values)";
        return mysqli_query($this->connection, $query);
    }

    public function update(string $table, int $id, array $data): bool {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key='$value',";
        }
        $query = "UPDATE $table SET $set WHERE id=$id";
        return mysqli_query($this->connection, $query);
    }

    public function delete(string $table, int $id): bool {
        $query = "DELETE FROM $table WHERE id=$id";
        return mysqli_query($this->connection, $query);
    }
}