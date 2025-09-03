<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Database;
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
