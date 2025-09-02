
<?php

require 'db-connection.php';

$apiUrl = "https://pokeapi.co/api/v2/pokemon-habitat";


$response = file_get_contents($apiUrl);
if ($response === FALSE) {
    die("Error occurred while fetching API data.");
}
$data = json_decode($response, true);
if ($data === null) {
    die("Error decoding JSON data.");
}
$fileSaved = file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
if ($fileSaved === false) {
    die("Error saving data to file.");
}

$stmt = $pdo->prepare("INSERT IGNORE INTO habitat (name) VALUES (:name)");

foreach ($data['results'] as $habitat) {
    $stmt->execute([':name' => $habitat['name']]);
}
echo "Data fetched and saved successfully.";
?>