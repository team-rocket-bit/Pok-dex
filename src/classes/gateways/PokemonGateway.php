<?php

namespace Gateway;

use App\Database;
use Gateway\GatewayInterface;

/**
 * Handled alle PDO queries naar de database
 */
class PokemonGateway implements GatewayInterface
{
    private \PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    /**
     * Pakt alle Pokemon uit de database
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM pokemon";

        $stmt = $this->conn->query($sql);

        $data = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Voegt een Pokemon toe aan de Database
     * @param array $data
     * @return string
     * returned string met de opgeslagen id
     */
    public function create(array $data): string
    {
        $sql = "INSERT INTO pokemon (
        name,
        height,
        weight,
        primary_ability_id,
        hidden_ability_id,
        primary_type_id,
        secondary_type_id,
        habitat_id) VALUES (:name,
        :height,
        :weight,
        :primary_ability_id,
        :hidden_ability_id,
        :primary_type_id,
        :secondary_type_id,
        :habitat_id)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':name', $data["name"], \PDO::PARAM_STR);
        $stmt->bindValue(':height', $data["height"], \PDO::PARAM_INT);
        $stmt->bindValue(':weight', $data["weight"], \PDO::PARAM_INT);
        $stmt->bindValue(':primary_ability_id', $data["primary_ability_id"], \PDO::PARAM_INT);
        $stmt->bindValue(':hidden_ability_id', $data["hidden_ability_id"] ?? null, \PDO::PARAM_INT);
        $stmt->bindValue(':primary_type_id', $data["primary_type_id"], \PDO::PARAM_INT);
        $stmt->bindValue(':secondary_type_id', $data["secondary_type_id"] ?? null, \PDO::PARAM_INT);
        $stmt->bindValue(':habitat_id', $data["habitat_id"], \PDO::PARAM_INT);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    /**
     * zoekt naar een pokemon met de meegegeven id
     * @param string $id
     * @return array|false
     */
    public function get(string $id): array|false
    {
        $sql = "SELECT * FROM pokemon WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }


    /**
     * zoekt naar een pokemon met de meegegeven name
     * @param string $name
     * @return array|false
     */
    public function getWithName(string $name): array|false
    {
        $sql = "SELECT * FROM pokemon WHERE name = :name";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);

        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Update informatie over één pokemon in de database
     * @param array $current
     * @param array $new
     * @return int
     * returned int met aantal rijen die gewijzigd zijn
     */
    public function update(array $current, array $new): int
    {
        $sql = "UPDATE pokemon SET
        name = :name,
        height = :height,
        weight = :weight,
        primary_ability_id = :primary_ability_id,
        hidden_ability_id = :hidden_ability_id,
        primary_type_id = :primary_type_id,
        secondary_type_id = :secondary_type_id,
        habitat_id = :habitat_id
        WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new["name"] ?? $current["name"], \PDO::PARAM_STR);
        $stmt->bindValue(":height", $new["height"] ?? $current["height"], \PDO::PARAM_INT);
        $stmt->bindValue(":weight", $new["weight"] ?? $current["weight"], \PDO::PARAM_INT);
        $stmt->bindValue(":primary_ability_id", $new["primary_ability_id"] ?? $current["primary_ability_id"], \PDO::PARAM_INT);
        $stmt->bindValue(":hidden_ability_id", $new["hidden_ability_id"] ?? $current["hidden_ability_id"], \PDO::PARAM_INT);
        $stmt->bindValue(":primary_type_id", $new["primary_type_id"] ?? $current["primary_type_id"], \PDO::PARAM_INT);
        $stmt->bindValue(":secondary_type_id", $new["secondary_type_id"] ?? $current["secondary_type_id"], \PDO::PARAM_INT);
        $stmt->bindValue(":habitat_id", $new["habitat_id"] ?? $current["habitat_id"], \PDO::PARAM_INT);

        $stmt->bindValue(":id", $current["id"], \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * Verwijderd een pokemon met de gegeven id
     * @param string $id
     * @return int
     * returned hoeveel rijen er verwijderd zijn
     */
    public function delete(string $id): int
    {
        $sql = "DELETE FROM pokemon
        WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
