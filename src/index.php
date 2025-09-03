<?php

declare(strict_types=1);

use App\Database;
use App\Controller;
use App\ErrorHandler;
use Gateway\AbilityGateway;
use Gateway\GatewayInterface;
use Gateway\HabitatGateway;
use Gateway\MoveGateway;
use Gateway\PokemonGateway;
use Gateway\TypeGateway;

// include autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// error handler
set_exception_handler([ErrorHandler::class, 'handleException']);

// ontvang requests in JSON
header("Content-type: application/json; chartset=UTF-8");

$uri = str_replace('/pokemon/Pok-dex', "", $_SERVER['REQUEST_URI']);
$parts = explode("/", $uri);

// toegestane api calls
$allowedCollections = [
    'ability',
    'habitat',
    'move',
    'pokemon',
    'type',
];

// error response voor foute api calls
if (!in_array($parts[1], $allowedCollections)) {
    http_response_code(404);
    die('Enter a valid api call');
}

$id = $parts[2] ?? null;

// database connectie
$user = 'bit_academy';
$pass = 'bit_academy';

$database = new Database('localhost', 'pokedex', $user, $pass);

// geef de juiste Gateway mee aan Controller
$gateway = chooseGateway($parts[1], $database);

$controller = new Controller($gateway);

$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);

function chooseGateway(string $uri, Database $database): GatewayInterface
{
    switch ($uri) {
    case 'ability':
        return new AbilityGateway($database);
    case 'move':
        return new MoveGateway($database);
    case 'type':
        return new TypeGateway($database);
    case 'habitat':
        return new HabitatGateway($database);
    default:
        return new PokemonGateway($database);
    }
}
