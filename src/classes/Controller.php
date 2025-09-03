<?php

namespace App;

use Gateway\GatewayInterface;
use Gateway\PokemonGateway;

/**
 * Controller class
 * Handles
 */
class Controller
{
    private GatewayInterface $gateway;

    public function __construct(GatewayInterface $gateway)
    {
        $this->gateway = $gateway;
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
        // Check if ID is numeric or a name
        if (is_numeric($id)) {
            $result = $this->gateway->get($id);
        } else {
            $result = $this->gateway->getWithName($id);
        }

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
            $data = (array)json_decode(file_get_contents("php://input"), true);

            $errors = $this->getValidationErrors($data, false);
            if (!empty($errors)) {
                http_response_code(422);
                echo json_encode(["errors" => $errors]);
                break;
            }

            $rows = $this->gateway->update($result, $data);

            // return success code and message
            echo json_encode(
                [
                "message" => "Data for $id updated",
                "rows" => $rows
                    ]
            );
            break;

        case "DELETE":
            $rows = $this->gateway->delete($id);

            echo json_encode(
                [
                "message" => "Data for $id deleted",
                "rows" => $rows
                    ]
            );
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
            echo json_encode($this->gateway->getAll());
            break;

        case "POST":
            $data = (array)json_decode(file_get_contents("php://input"), true);

            $errors = $this->getValidationErrors($data);
            if (!empty($errors)) {
                http_response_code(422);
                echo json_encode(["errors" => $errors]);
                break;
            }

            $id = $this->gateway->create($data);

            // return success code and message
            http_response_code(201);
            echo json_encode(
                [
                "message" => "Data added",
                "id" => $id
                    ]
            );
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
