<?php

namespace App;

class Controller
{
    private $pokedexGateway;
    public function __construct(PokedexGateway $pokedexGateway)
    {
        $this->pokedexGateway = $pokedexGateway;
    }

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            $this->processResourceRequest($method, $id);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id): void
    {
        $result = $this->pokedexGateway->get($id);

        if (!$result) {
            http_response_code(404);
            echo json_encode(["Message" => "Data not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($result);
                break;

            case "PUT":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data, false);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->pokedexGateway->update($result, $data);

                // return success code and message
                echo json_encode([
                    "message" => "Data for $id updated",
                    "rows" => $rows
                ]);
                break;

            case "DELETE":
                $rows = $this->pokedexGateway->delete($id);

                echo json_encode([
                    "message" => "Data for $id deleted",
                    "rows" => $rows
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, PUT, DELETE");
        }
    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->pokedexGateway->getAll());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->pokedexGateway->create($data);

                // return success code and message
                http_response_code(201);
                echo json_encode([
                    "message" => "Data added",
                    "id" => $id
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];

        if ($is_new && empty($data["name"])) {
            $errors[] = "name is required";
        }

        $intVariables = [
            'height',
            'weight',
            'primary_ability_id',
            'hidden_ability_id',
            'primary_type_id',
            'secondary_type_id',
            'habitat_id'
        ];

        foreach ($intVariables as $variable) {
            if (array_key_exists($variable, $data)) {
                if (filter_var($data[$variable], FILTER_VALIDATE_INT) === false) {
                    $errors[] = $variable . " must be an integer";
                }
            }
        }

        return $errors;
    }
}
