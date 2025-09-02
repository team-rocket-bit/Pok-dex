<?php

declare(strict_types=1);

use App\Database;
use App\Controller;
use App\ErrorHandler;
use App\PokedexGateway;

// include autoloader
include_once './vendor/autoload.php';

// error handler
set_exception_handler([ErrorHandler::class, 'handleException']);

// stuurt alle requests in JSON terug
header("Content-type: application/json; chartset=UTF-8");

$uri = str_replace('/pokemon/Pok-dex', "", $_SERVER['REQUEST_URI']);
$parts = explode("/", $uri);

// allowed api calls
$allowedCollections = [
    'ability',
    'habitat',
    'move',
    'pokemon',
    'type',
];

// error response voor foute api calls
$id = $parts[2] ?? null;
if (!in_array($parts[1], $allowedCollections)) {
    http_response_code(404);
    die('Enter a valid api call');
}

// database connectie
$database = new Database('localhost', 'pokedex', 'bit_academy', 'bit_academy');

$gateway = new PokedexGateway($database);

$controller = new Controller($gateway);

$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);