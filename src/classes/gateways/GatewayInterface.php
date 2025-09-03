<?php

namespace Gateway;

interface GatewayInterface
{
    public function __construct(\App\Database $database);

    public function getAll(): array;

    public function create(array $data): string;

    public function get(string $id): array|false;

    public function getWithName(string $name): array|false;

    public function update(array $current, array $new): int;

    public function delete(string $id): int;
}
