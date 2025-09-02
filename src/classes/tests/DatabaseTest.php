<?php

namespace Tests;

// require test file
// require_once '../Database.php';

use PHPUnit\Framework\TestCase;
use Database\Database;
use PDOException;

class DatabaseTest extends TestCase
{
    protected Database $database;

    protected function setUp(): void
    {
        $this->database = new Database('localhost', 'pokedex', 'bit_academy', 'bit_academy');
    }

    public function testDatabaseConnection()
    {
        // Act
        $result = $this->database->getConnection();

        // Assert
        $this->assertInstanceOf(\PDO::class, $result);
    }

    public function testDatabaseReturnsErrorIfPasswordIsIncorrect()
    {
        $this->expectException(PDOException::class);

        $database = new Database('localhost', 'pokedex', 'fouteUser', 'foutePassword');
        $database->getConnection();
    }
}
