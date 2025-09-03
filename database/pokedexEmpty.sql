DROP DATABASE IF EXISTS pokedex;

CREATE DATABASE pokedex;

USE pokedex;

CREATE TABLE ability
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT         NULL
);

CREATE TABLE type
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE habitat
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE move
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(100),
    type_id  INT         NOT NULL,
    category VARCHAR(50) NOT NULL,
    power    INT         NULL,
    accuracy INT         NULL,
    FOREIGN KEY (type_id) REFERENCES type (id)
);

CREATE TABLE pokemon
(
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    name               VARCHAR(100)  NOT NULL,
    height             DECIMAL(5, 2) NOT NULL,
    weight             DECIMAL(5, 2) NOT NULL,
    primary_ability_id INT           NOT NULL,
    hidden_ability_id  INT           NULL,
    primary_type_id    INT           NOT NULL,
    secondary_type_id  INT           NULL,
    habitat_id         INT           NOT NULL,
    FOREIGN KEY (primary_ability_id) REFERENCES ability (id),
    FOREIGN KEY (hidden_ability_id) REFERENCES ability (id),
    FOREIGN KEY (primary_type_id) REFERENCES type (id),
    FOREIGN KEY (secondary_type_id) REFERENCES type (id),
    FOREIGN KEY (habitat_id) REFERENCES habitat (id)
);

CREATE TABLE pokemon_move
(
    pokemon_id INT NOT NULL,
    move_id    INT NOT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemon (id),
    FOREIGN KEY (move_id) REFERENCES move (id)
);

-- Ability table
INSERT INTO ability (name, description)
VALUES ('static',
        'If a Pokémon with Static is hit by a move making contact, there is a 30% chance the foe will become paralyzed.'),
       ('lightning-rod',
        'Lightning Rod forces all single-target Electric-type moves - used by any other Pokémon on the field - to target this Pokémon, and with 100% accuracy. This includes the status move Thunder Wave. The ability is most useful in double/triple battles.

        When hit by the move, it deals no damage to the ability-bearer but raises its Special Attack by one stage. Stats can be raised to a maximum of +6 stages each.

        Lightning Rod will activate for an Electric-type Hidden Power, but not Electric-type Judgment.

        The ability is overridden by other Pokémon becoming the center of attention from the moves Follow Me or Rage Powder.');

-- Type table
INSERT INTO type (name)
VALUES ('Normal'),
       ('Fire'),
       ('Water'),
       ('Electric'),
       ('Grass'),
       ('Ice'),
       ('Fighting'),
       ('Poison'),
       ('Ground'),
       ('Flying'),
       ('Psychic'),
       ('Bug'),
       ('Rock'),
       ('Ghost'),
       ('Dragon'),
       ('Dark'),
       ('Steel'),
       ('Fairy');

-- Habitat table
INSERT
INTO habitat (name)
VALUES ('Grassland'),
       ('Forest'),
       ('Water''s-edge'),
       ('Sea'),
       ('Cave'),
       ('Mountain'),
       ('Rough-terrain'),
       ('Urban'),
       ('Rare');

-- main Pokemon table
INSERT INTO pokemon (name,
                     height,
                     weight,
                     primary_ability_id,
                     hidden_ability_id,
                     primary_type_id,
                     secondary_type_id,
                     habitat_id)
VALUES ('Pikachu',
        0.40,
        6.00,
        1,
        2,
        4,
        NULL,
        2);