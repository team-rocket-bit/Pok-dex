<?php

declare(strict_types=1);

// include de database
include_once './vendor/autoload.php';

use Database\Database;

$database = new Database('localhost', 'pokedex', 'bit_academy', 'bit_academy');
$database->getConnection();

var_dump($_SERVER['REQUEST_URI']);
