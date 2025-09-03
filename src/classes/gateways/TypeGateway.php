<?php

namespace Gateway;

use App\Database;
use Gateway\GatewayInterface;

/**
 * Handled alle PDO queries naar de database
 */
class TypeGateway implements GatewayInterface
{
    private \PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    /**
     * Pakt alle Types uit de database
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM type";

        $stmt = $this->conn->query($sql);

        $data = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Voegt een Type toe aan de Database
     * @param array $data
     * @return string
     * returned string met de opgeslagen id
     */
    public function create(array $data): string
    {
        $sql = "INSERT INTO type (name) VALUES (:name)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':name', $data["name"], \PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    /**
     * zoekt naar een Type met de meegegeven id
     * @param string $id
     * @return array|false
     */
    public function get(string $id): array|false
    {
        $sql = "SELECT * FROM type WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * zoekt naar een Type met de meegegeven name
     * @param string $name
     * @return array|false
     */
    public function getWithName(string $name): array|false
    {
        $sql = "SELECT * FROM type WHERE name = :name";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);

        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Update informatie over één Type in de database
     * @param array $current
     * @param array $new
     * @return int
     * returned int met aantal rijen die gewijzigd zijn
     */
    public function update(array $current, array $new): int
    {
        $sql = "UPDATE type SET name = :name WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new["name"] ?? $current["name"], \PDO::PARAM_STR);

        $stmt->bindValue(":id", $current["id"], \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * verwijderd een Type met de gegeven id
     * @param string $id
     * @return int
     * returned hoeveel rijen er verwijderd zijn
     */
    public function delete(string $id): int
    {
        $sql = "DELETE FROM type WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
