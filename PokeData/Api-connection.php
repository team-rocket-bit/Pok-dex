
<?php

require 'db-connection.php';


$pokeListUrl = "https://pokeapi.co/api/v2/pokemon?limit=100"; //Pokemon api endpoint met een limit van max 100 pokemon
$listResponse = file_get_contents($pokeListUrl);
if ($listResponse === false) {
    die("Error fetching Pokémon list.");
}
$listData = json_decode($listResponse, true);

//prepared statements om de database te vullen
$insertType = $pdo->prepare("INSERT IGNORE INTO type (name) VALUES (:name)");
$insertAbility = $pdo->prepare("INSERT IGNORE INTO ability (name, description) VALUES (:name, :description)");
$insertMove = $pdo->prepare("INSERT IGNORE INTO move (name, type_id, category, power, accuracy) VALUES (:name, :type_id, :category, :power, :accuracy)");
$insertPokemon = $pdo->prepare("INSERT INTO pokemon (name, height, weight, primary_type_id, secondary_type_id, primary_ability_id, hidden_ability_id, image_id) 
                                VALUES (:name, :height, :weight, :primary_type_id, :secondary_type_id, :primary_ability_id, :hidden_ability_id, :image_id)");
$insertPokemonMove = $pdo->prepare("INSERT INTO pokemon_move (pokemon_id, move_id) VALUES (:pokemon_id, :move_id)");
$insertImages = $pdo->prepare("INSERT INTO images(back_default, back_female, back_shiny, back_shiny_female, front_default, front_female, front_shiny, front_shiny_female)
                               VALUES (:back_default, :back_female, :back_shiny, :back_shiny_female, :front_default, :front_female, :front_shiny, :front_shiny_female)");
                        
foreach ($listData['results'] as $pokemon) {
    $detailsResponse = file_get_contents($pokemon['url']);
    if ($detailsResponse === false) {
        continue;
    }

    $details = json_decode($detailsResponse, true);  

    
    $typeIds = [];
    foreach ($details['types'] as $t) {
        $typeName = $t['type']['name'];
        $insertType->execute([':name' => $typeName]);

        
        $typeId = $pdo->lastInsertId();
        if (!$typeId) {
            $stmt = $pdo->prepare("SELECT id FROM type WHERE name = :name");
            $stmt->execute([':name' => $typeName]);
            $typeId = $stmt->fetchColumn();
        }
        $typeIds[] = $typeId;
    }

    
    $abilityIds = [];
    foreach ($details['abilities'] as $a) {
        $abilityName = $a['ability']['name'];
        $insertAbility->execute([
            ':name' => $abilityName,
            ':description' => null
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


    $insertImages->execute([
    ':back_default'      => $details['sprites']['back_default'] ?? null,
    ':back_female'       => $details['sprites']['back_female'] ?? null,
    ':back_shiny'        => $details['sprites']['back_shiny'] ?? null,
    ':back_shiny_female' => $details['sprites']['back_shiny_female'] ?? null,
    ':front_default'     => $details['sprites']['front_default'] ?? null,
    ':front_female'      => $details['sprites']['front_female'] ?? null,
    ':front_shiny'       => $details['sprites']['front_shiny'] ?? null,
    ':front_shiny_female' => $details['sprites']['front_shiny_female'] ?? null
    ]);
    $imageId = $pdo->lastInsertId();
   
    $insertPokemon->execute([
    ':name' => $details['name'],
    ':height' => $details['height'],
    ':weight' => $details['weight'],
    ':primary_type_id' => $typeIds[0] ?? null,
    ':secondary_type_id' => $typeIds[1] ?? null,
    ':primary_ability_id' => $primaryAbilityId,
    ':hidden_ability_id' => $hiddenAbilityId,
    ':image_id' => $imageId
    ]);

    $pokemonId = $pdo->lastInsertId();

   
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
