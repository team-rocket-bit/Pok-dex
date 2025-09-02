<?php

$host = "127.0.0.1";
$db = "pokedex";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$data = "mysql:host=$host;dbname=$db;charset=$charset";
$optie = [
    pdo::ATTR_ERRMODE => pdo::ERRMODE_EXCEPTION,
    pdo::ATTR_DEFAULT_FETCH_MODE => pdo::FETCH_ASSOC,
    pdo::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, $optie);
} catch (PDOException $err) {
    echo "Kan niet connecten met Database. " . $err->getMessage();
    exit();
}
