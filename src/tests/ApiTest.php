<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Test API endpoints
 * Voegt een pokemon toe, leest de info,
 * update de info en verwijdert de row weer
 */
class ApiTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://deep.dives/pokemon/Pok-dex/'
        ]);
    }

    public function testApiReturnsCorrectStatusCode()
    {
        // Arrange
        $response = $this->client->request('GET', 'pokemon');

        // Act
        $result = $response->getStatusCode();

        // Assert
        $this->assertEquals(200, $result);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPostAddsRowToDatabase(): void
    {
        // Arrange
        $data = [
            "name" => "Test_subject",
            "height" => 200,
            "weight" => 80,
            "primary_ability_id" => 1,
            "primary_type_id" => 4,
            "habitat_id" => 1
        ];

        // Act
        $response = $this->client->request('POST', 'pokemon', [
            'json' => $data,  // stuurt JSON data via request body
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $jsonResult = $response->getBody()->getContents();
        $result = json_decode($jsonResult, true);

        // Assert
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals("Data added", $result['message']);
        $this->assertArrayHasKey('id', $result);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testApiReturnsCorrectData(): void
    {
        // Act
        $response = $this->client->request('GET', 'pokemon/' . $this->getLastPokemonId());

        $jsonResult = $response->getBody()->getContents();
        $result = json_decode($jsonResult, true);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        // echo var_dump($this->getLastPokemonId());
        $this->assertEquals('Test_subject', $result['name']);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPutAltersDatabaseRowInformation(): void
    {
        // Arrange
        $data = [
            "name" => "PUT_Name_Test",
        ];

        // Act
        $response = $this->client->request('PUT', 'pokemon/' . $this->getLastPokemonId(), [
            'json' => $data,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $jsonResult = $response->getBody()->getContents();
        $result = json_decode($jsonResult, true);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Data for " . $this->getLastPokemonId() . " updated", $result['message']);
    }

    public function testDeleteRemovesRowFromDatabase(): void
    {
        // Arrange
        $deletedId = $this->getLastPokemonId();

        // Act
        $response = $this->client->request('DELETE', 'pokemon/' . $this->getLastPokemonId());
        $jsonResult = $response->getBody()->getContents();
        $result = json_decode($jsonResult, true);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Data for " . $deletedId . " deleted", $result['message']);
    }

    private function getLastPokemonId(): int
    {
        $response = $this->client->request('GET', 'pokemon');
        $data = json_decode($response->getBody()->getContents(), true);
        return (int)max(array_column($data, 'id'));
    }
}
