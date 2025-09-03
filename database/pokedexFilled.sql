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

        The ability is overridden by other Pokémon becoming the center of attention from the moves Follow Me or Rage Powder.'),
       ('overgrow', 'Powers up Grass-type moves when the Pokémon is in trouble.'),
       ('chlorophyll', 'Boosts the Pokémon''s Speed stat in harsh sunlight.'),
       ('blaze', 'Powers up Fire-type moves when the Pokémon is in trouble.'),
       ('solar-power', 'Boosts the Sp. Atk stat in harsh sunlight, but HP decreases.'),
       ('torrent', 'Powers up Water-type moves when the Pokémon is in trouble.'),
       ('rain-dish', 'The Pokémon gradually regains HP in rain.'),
       ('shield-dust', 'This Pokémon''s dust blocks the additional effects of attacks taken.'),
       ('compound-eyes', 'The Pokémon''s compound eyes boost its accuracy.'),
       ('swarm', 'Powers up Bug-type moves when the Pokémon is in trouble.'),
       ('keen-eye', 'Prevents other Pokémon from lowering accuracy.'),
       ('tangled-feet', 'Raises evasion if the Pokémon is confused.'),
       ('big-pecks', 'Protects the Pokémon from Defense-lowering attacks.'),
       ('guts', 'It''s so gutsy that having a status condition boosts the Attack stat.'),
       ('hustle', 'Boosts the Attack stat, but lowers accuracy.'),
       ('intimidate', 'The Pokémon intimidates opposing Pokémon upon entering battle, lowering their Attack stat.'),
       ('shed-skin', 'The Pokémon may heal its own status conditions by shedding its skin.'),
       ('wonder-skin', 'Makes status moves more likely to miss.'),
       ('poison-point', 'Contact with the Pokémon may poison the attacker.'),
       ('rivalry', 'Becomes competitive and deals more damage to Pokémon of the same gender.'),
       ('unnerve', 'Unnerves opposing Pokémon and makes them unable to eat Berries.');

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
VALUES ('Bulbasaur', 0.70, 6.90, 3, 4, 5, 8, 2),
       ('Ivysaur', 1.00, 13.00, 3, 4, 5, 8, 2),
       ('Venusaur', 2.00, 100.00, 3, 4, 5, 8, 2),
       ('Pikachu', 0.40, 6.00, 1, 2, 4, NULL, 2),
       ('Charmander', 0.60, 8.50, 5, 6, 2, NULL, 6),
       ('Charmeleon', 1.10, 19.00, 5, 6, 2, NULL, 6),
       ('Charizard', 1.70, 90.50, 5, 6, 2, 10, 6),
       ('Squirtle', 0.50, 9.00, 7, 8, 3, NULL, 3),
       ('Wartortle', 1.00, 22.50, 7, 8, 3, NULL, 3),
       ('Blastoise', 1.60, 85.50, 7, 8, 3, NULL, 3),
       ('Caterpie', 0.30, 2.90, 9, 10, 12, NULL, 2),
       ('Metapod', 0.70, 9.90, 9, NULL, 12, NULL, 2),
       ('Butterfree', 1.10, 32.00, 10, 13, 12, 10, 2),
       ('Weedle', 0.30, 3.20, 9, 10, 12, 8, 2),
       ('Kakuna', 0.60, 10.00, 9, NULL, 12, 8, 2),
       ('Beedrill', 1.00, 29.50, 11, 10, 12, 8, 2),
       ('Pidgey', 0.30, 1.80, 12, 13, 1, 10, 2),
       ('Pidgeotto', 1.10, 30.00, 12, 13, 1, 10, 2),
       ('Pidgeot', 1.50, 39.50, 12, 14, 1, 10, 2),
       ('Rattata', 0.30, 3.50, 15, 16, 1, NULL, 2),
       ('Raticate', 0.70, 18.50, 15, 16, 1, NULL, 2);

-- Move table
INSERT INTO move (name, type_id, category, power, accuracy)
VALUES ('thunder-shock', 4, 'Special', 40, 100),
       ('thunderbolt', 4, 'Special', 90, 100),
       ('thunder', 4, 'Special', 110, 70),
       ('tackle', 1, 'Physical', 40, 100),
       ('quick-attack', 1, 'Physical', 40, 100),
       ('vine-whip', 5, 'Physical', 45, 100),
       ('razor-leaf', 5, 'Physical', 55, 95),
       ('solar-beam', 5, 'Special', 120, 100),
       ('ember', 2, 'Special', 40, 100),
       ('flamethrower', 2, 'Special', 90, 100),
       ('fire-blast', 2, 'Special', 110, 85),
       ('water-gun', 3, 'Special', 40, 100),
       ('bubble-beam', 3, 'Special', 65, 100),
       ('hydro-pump', 3, 'Special', 110, 80),
       ('peck', 10, 'Physical', 35, 100),
       ('wing-attack', 10, 'Physical', 60, 100),
       ('gust', 10, 'Special', 40, 100),
       ('string-shot', 12, 'Status', NULL, 95),
       ('bug-bite', 12, 'Physical', 60, 100),
       ('poison-sting', 8, 'Physical', 15, 100),
       ('acid', 8, 'Special', 40, 100),
       ('sludge-bomb', 8, 'Special', 90, 100);

-- Pokemon moves relationships
INSERT INTO pokemon_move (pokemon_id, move_id)
VALUES (1, 1), (1, 2), (1, 3), (1, 4), (1, 5),
       (2, 6), (2, 7), (2, 8), (2, 4),   
       (3, 6), (3, 7), (3, 8), (3, 4),       
       (4, 6), (4, 7), (4, 8), (4, 4),        
       (5, 9), (5, 10), (5, 11), (5, 4), (5, 5),
       (6, 9), (6, 10), (6, 11), (6, 4), (6, 5),
       (7, 9), (7, 10), (7, 11), (7, 4), (7, 5),
       (8, 12), (8, 13), (8, 14), (8, 4),
       (9, 12), (9, 13), (9, 14), (9, 4),
       (10, 12), (10, 13), (10, 14), (10, 4),
       (11, 18), (11, 4),
       (12, 4),
       (13, 17), (13, 16), (13, 19),
       (14, 20), (14, 18),
       (15, 4),
       (16, 15), (16, 19), (16, 20), (16, 21),
       (17, 15), (17, 16), (17, 17), (17, 4), (17, 5),
       (18, 15), (18, 16), (18, 17), (18, 4), (18, 5),
       (19, 15), (19, 16), (19, 17), (19, 4), (19, 5),
       (20, 4), (20, 5),
       (21, 4), (21, 5);