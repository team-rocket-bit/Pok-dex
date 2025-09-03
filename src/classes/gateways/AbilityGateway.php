<?php

namespace Gateway;

use App\Database;
use Gateway\GatewayInterface;

/**
 * Handled alle PDO queries naar de database
 */
class AbilityGateway implements GatewayInterface
{
    private \PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    /**
     * Pakt alle Abilities uit de database
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM ability";

        $stmt = $this->conn->query($sql);

        $data = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Voegt een Ability toe aan de Database
     * @param array $data
     * @return string
     * returned string met de opgeslagen id
     */
    public function create(array $data): string
    {
        $sql = "INSERT INTO ability (
        name,
        description) VALUES (:name,
        :description)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':name', $data["name"], \PDO::PARAM_STR);
        $stmt->bindValue(':description', $data["description"], \PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    /**
     * zoekt naar een Ability met de meegegeven id
     * @param string $id
     * @return array|false
     */
    public function get(string $id): array|false
    {
        $sql = "SELECT * FROM ability WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Update informatie over één Ability in de database
     * @param array $current
     * @param array $new
     * @return int
     * returned int met aantal rijen die gewijzigd zijn
     */

    /**
     * zoekt naar een Ability met de meegegeven name
     * @param string $name
     * @return array|false
     */
    public function getWithName(string $name): array|false
    {
        $sql = "SELECT * FROM ability WHERE name = :name";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);

        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function update(array $current, array $new): int
    {
        $sql = "UPDATE ability SET
        name = :name,
        description = :description
        WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new["name"] ?? $current["name"], \PDO::PARAM_STR);
        $stmt->bindValue(":description", $new["description"] ?? $current["description"], \PDO::PARAM_STR);

        $stmt->bindValue(":id", $current["id"], \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * verwijderd een Ability met de gegeven id
     * @param string $id
     * @return int
     * returned hoeveel rijen er verwijderd zijn
     */
    public function delete(string $id): int
    {
        if (is_numeric($id)) {
            $sql = "DELETE FROM ability WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
        } else {
            $sql = "DELETE FROM ability WHERE name = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":id", $id, \PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->rowCount();
    }
}
