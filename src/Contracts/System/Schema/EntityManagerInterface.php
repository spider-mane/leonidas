<?php

namespace Leonidas\Contracts\System\Schema;

interface EntityManagerInterface
{
    public function byId(int $id): ?object;

    public function whereIds(int ...$ids): object;

    public function all(): object;

    public function query(array $args): object;

    public function single(array $args): ?object;

    public function spawn(array $data): object;

    public function insert(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function commit(): void;
}
