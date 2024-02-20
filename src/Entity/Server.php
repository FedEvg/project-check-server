<?php

namespace Jekamars\CheckServer\Entity;

use Jekamars\CheckServers\Database;

class Server
{
    public const STATUS_FALSE = 0;
    public const STATUS_TRUE = 1;

    public Database $database;

    public function __construct(Database $database, private string $tableName)
    {
        $this->database = $database;
        $this->tableName = $tableName;
    }

    /**
     * @throws \Exception
     */
    public function servers(): array
    {
        $sql = 'SELECT * FROM ' . $this->tableName;

        return $this->database->fetchAll($sql);
    }

    /**
     * @throws \Exception
     */
    public function getServerById(int $id): array
    {
        $sql = 'SELECT * FROM ' . $this->tableName . ' WHERE id = ' . $id . ';';

        return $this->database->fetch($sql);
    }
    /**
     * @throws \Exception
     */
    public function create(string $name, string $description): string
    {
        try {
            $sql = 'INSERT INTO ' . $this->tableName . ' (`name`, `description`, `status`, `created`, `updated`) VALUES (?, ?, ?, ?, ?)';
            $params = [$name, $description, self::STATUS_FALSE, date('Y-m-d H:i:s'), null];

            $this->database->query($sql, $params);

            return true;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function update(array $server): string
    {
        $data = $this->getServerById($server['id']);

        $sql = 'UPDATE ' . $this->tableName . ' SET
            name = :name,
            description = :description,
            status = :status,
            updated = :updated
        WHERE id = :id';

        $name = !empty($server['name']) ? $server['name'] : $data['name'];

        $params = [
            ':name' => $name,
            ':description' => !empty($server['description']) ? $server['description'] : $data['description'],
            ':status' => $server["status"] ?? $data["status"],
            ':updated' => date('Y-m-d H:i:s'),
            ':id' => $server['id'],
        ];

        $this->database->query($sql, $params);

        return 'Success updated ' . $server['id'];
    }

    /**
     * @throws \Exception
     */
    public function delete(int $id): string
    {
        $sql = 'DELETE FROM ' . $this->tableName . ' WHERE id = ' . $id . ';';

        $this->database->query($sql);

        return 'Success deleted ' . $id;
    }
}