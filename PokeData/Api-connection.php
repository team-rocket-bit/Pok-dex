<?php
require 'db-connection.php';

// Fetch all Pokémon (names + URLs)
$pokeListUrl = "https://pokeapi.co/api/v2/pokemon?limit=100";
$listResponse = file_get_contents($pokeListUrl);
if ($listResponse === FALSE) {
    die("Error fetching Pokémon list.");
}
$listData = json_decode($listResponse, true);

// Prepare reusable statements
$insertType = $pdo->prepare("INSERT IGNORE INTO type (name) VALUES (:name)");
$insertAbility = $pdo->prepare("INSERT IGNORE INTO ability (name, description) VALUES (:name, :description)");
$insertMove = $pdo->prepare("INSERT IGNORE INTO move (name, type_id, category, power, accuracy) VALUES (:name, :type_id, :category, :power, :accuracy)");
$insertPokemon = $pdo->prepare("INSERT INTO pokemon (name, height, weight, primary_type_id, secondary_type_id, primary_ability_id, hidden_ability_id) 
                                VALUES (:name, :height, :weight, :primary_type_id, :secondary_type_id, :primary_ability_id, :hidden_ability_id)");
$insertPokemonMove = $pdo->prepare("INSERT INTO pokemon_move (pokemon_id, move_id) VALUES (:pokemon_id, :move_id)");

// Loop through Pokémon
foreach ($listData['results'] as $pokemon) {
    $detailsResponse = file_get_contents($pokemon['url']);
    if ($detailsResponse === FALSE) continue;

    $details = json_decode($detailsResponse, true);

    // ---- TYPES ----
    $typeIds = [];
    foreach ($details['types'] as $t) {
        $typeName = $t['type']['name'];
        $insertType->execute([':name' => $typeName]);

        // Get type ID
        $typeId = $pdo->lastInsertId();
        if (!$typeId) {
            $stmt = $pdo->prepare("SELECT id FROM type WHERE name = :name");
            $stmt->execute([':name' => $typeName]);
            $typeId = $stmt->fetchColumn();
        }
        $typeIds[] = $typeId;
    }

    // ---- ABILITIES ----
    $abilityIds = [];
    foreach ($details['abilities'] as $a) {
        $abilityName = $a['ability']['name'];
        $insertAbility->execute([
            ':name' => $abilityName,
            ':description' => null // PokéAPI has descriptions under another endpoint
        ]);

        $abilityId = $pdo->lastInsertId();
        if (!$abilityId) {
            $stmt = $pdo->prepare("SELECT id FROM ability WHERE name = :name");
            $stmt->execute([':name' => $abilityName]);
            $abilityId = $stmt->fetchColumn();
        }
        $abilityIds[] = ['id' => $abilityId, 'is_hidden' => $a['is_hidden']];
    }

    $primaryAbilityId = null;
    $hiddenAbilityId = null;
    foreach ($abilityIds as $a) {
        if ($a['is_hidden']) {
            $hiddenAbilityId = $a['id'];
        } else {
            $primaryAbilityId = $a['id'];
        }
    }

    // ---- POKEMON ----
    $insertPokemon->execute([
        ':name' => $details['name'],
        ':height' => $details['height'],
        ':weight' => $details['weight'],
        ':primary_type_id' => $typeIds[0] ?? null,
        ':secondary_type_id' => $typeIds[1] ?? null,
        ':primary_ability_id' => $primaryAbilityId,
        ':hidden_ability_id' => $hiddenAbilityId
    ]);
    $pokemonId = $pdo->lastInsertId();

    // ---- MOVES ----
    foreach ($details['moves'] as $m) {
        $moveName = $m['move']['name'];
        $insertMove->execute([
            ':name' => $moveName,
            ':type_id' => null,
            ':category' => null,
            ':power' => null,
            ':accuracy' => null
        ]);

        $moveId = $pdo->lastInsertId();
        if (!$moveId) {
            $stmt = $pdo->prepare("SELECT id FROM move WHERE name = :name");
            $stmt->execute([':name' => $moveName]);
            $moveId = $stmt->fetchColumn();
        }

        $insertPokemonMove->execute([
            ':pokemon_id' => $pokemonId,
            ':move_id' => $moveId
        ]);
    }
}

echo "Pokédex database filled successfully!";
