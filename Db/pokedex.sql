DROP DATABASE IF EXISTS pokedex;

CREATE DATABASE pokedex;

CREATE TABLE pokemon (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Species VARCHAR(100) NOT NULL,
    Height DECIMAL(5,2) NOT NULL,
    Weight DECIMAL(5,2) NOT NULL,
    Primary_ability VARCHAR(100) NOT NULL,
    Hidden_ability VARCHAR(100),
    Primary_type_id INT NOT NULL,
    Secondary_type INT,
    Habitat_id INT NOT NULL
);

INSERT INTO pokemon (
    Name, Species, Height, Weight, Primary_ability, Hidden_ability, Primary_type_id, Secondary_type, Habitat_id
)
VALUES (
    'Pikachu', 'Mouse Pokémon', 0.40, 6.00, 'Static', 'Lightning Rod', 13, NULL, 3
);


CREATE TABLE ability (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Ability_name VARCHAR(100),
    Pokemon_Id INT,
    Discription TEXT(200)
);


