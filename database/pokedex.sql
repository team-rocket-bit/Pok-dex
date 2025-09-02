DROP DATABASE IF EXISTS pokedex;

CREATE DATABASE pokedex;

USE pokedex;


CREATE TABLE ability (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NULL,
    description TEXT NULL
);

CREATE TABLE hidden_ability (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NULL,
    description TEXT NULL
);

CREATE TABLE type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NULL
);

CREATE TABLE habitat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NULL
);

CREATE TABLE move (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    type_id INT NULL,
    category VARCHAR(50) NULL,
    power INT NULL,
    accuracy INT NULL,
    FOREIGN KEY (type_id) REFERENCES type(id)   
);

CREATE TABLE pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NULL,
    species VARCHAR(100) NULL,
    height DECIMAL(5,2) NULL,
    weight DECIMAL(5,2) NULL,
    primary_ability_id INT NULL,
    hidden_ability_id INT NULL,
    primary_type_id INT NULL,
    secondary_type_id INT NULL,
    habitat_id INT NULL,
    FOREIGN KEY (primary_ability_id) REFERENCES ability(id),
    FOREIGN KEY (hidden_ability_id) REFERENCES ability(id),
    FOREIGN KEY (primary_type_id) REFERENCES type(id),
    FOREIGN KEY (secondary_type_id) REFERENCES type(id),
    FOREIGN KEY (habitat_id) REFERENCES habitat(id)
);

CREATE TABLE pokemon_move (
    pokemon_id INT NULL,
    move_id INT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemon(id),
    FOREIGN KEY (move_id) REFERENCES move(id)
);
