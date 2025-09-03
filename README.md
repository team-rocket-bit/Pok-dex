# Pokédex Team Rocket
Teamleden: __Dymoreno, Giorgio, Jadon en Jenebi__

## Doel:
Wij bouwen een API in PHP voor een pokédex met de criteria van de personages uit de [Deep Dive](https://bitacademy.notion.site/Deep-Dive-Pok-mon-4c6febe20a2c4184843165486f846f9f)

 - Link naar repo: https://github.com/team-rocket-bit/Pok-dex
 - Swagger editor: https://editor.swagger.io/

## Planning
| Persoon/Tijd | Di 9:00-11:00 | Di 11:00-13:00 | Di 13:00-15:00 | Di 15:00-17:00 | Wo 9:00-11:00 | Wo 11:00-13:00 | Wo 13:00-14:00 | Wo 15:00-17:00 | Do 9:00-11:00 | Do 11:00-13:00 |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Dymoreno | Story 2 (4u, hoog) | Story 2 (4u, hoog) | Story 5 (6u, hoog) | Story 5 (6u, hoog) | (afwezig) | (afwezig) | (afwezig) | (afwezig) |  |  |
| Giorgio | Story 2 (4u, hoog) | Story 2 (4u, hoog) | Story 5 (6u, hoog) | Story 5 (6u, hoog) | Story 5 (6u, hoog) | Story 6(6u hoog) | Story 6(6u hoog) | Story 6(6u hoog) | Presentatie voor-bereiding | Presentatie voor-bereiding |
| Jadon | (afwezig) | (afwezig) | (afwezig) | (afwezig) | (afwezig) | (afwezig) | (afwezig) | (afwezig) |  |  |
| Jenebi | Story 5 (8u, hoog) | Story 5 (8u, hoog) | Story 5 (8u, hoog) | Story 5 (8u, hoog) | Story 5 (8u, hoog) | Story 5 (8u, hoog) | Story 5 (8u, hoog) | Story 5 (8u, hoog) | Presentatie voor-bereiding | Presentatie voor-bereiding |

[Link naar google docs](https://docs.google.com/document/d/1w8imA5vnc0cpgdo6g6WI5FmB_3q7YbcyOnsT8uq8q6Q/edit?usp=sharing)
[Link naar presentatie](https://docs.google.com/presentation/d/1_Tm76PjbSLC9WeDnxenGs82tIJmYchhgHLmXnMsdu5c/edit?usp=sharing)

## Requirements
1. Zorg ervoor dat je PHP en Composer geinstalleerd hebt
2. MySQL omgeving als PHPMyAdmin
3. Het is handig als je een client als Postman, Swagger of HTTPie hebt

## Installatie
__1.__ Clone deze repo:
```
https://github.com/team-rocket-bit/Pok-dex.git
```
__2.__ Run deze commands uit om de dependencies te installeren:
```
cd Pok-dex && composer install
```

__3.__ Zet de inhoud van `pokedexFilled.sql`(aangeraden) of `pokedexEmpty.sql` in een Database genaamd `pokedex`


## Usage & Functionaliteiten
__1.__ Zoek in `src/index.php` naar `$user` en `$pass` (line 45), en voer jouw MySQL username en wachtwoord in

__2.__ Voer in je Postman/client de gewenste requests uit.
Bijvoorbeeld: `GET | localhost/pad/naar/repo/pokemon` -> stuurt alle informatie over de opgeslagen pokemon terug
 - Om alle API-endpoints te zien, bezoek dan de [swagger editor](https://editor.swagger.io/) en kopieer de inhoud van de .swagger.yml file in de editor

(!) Voor deze API is het mogelijk om informatie op te vragen, toe te voegen, te wijzigen en te verwijderen. __Ga voorzichtig met de data om!__

## Tech-stack
 - Logica volledig in (Object-georienteerde) PHP-PDO
 - MySQL
 - Tests geschreven in PHPUnit m.b.v. [guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle) dependency
