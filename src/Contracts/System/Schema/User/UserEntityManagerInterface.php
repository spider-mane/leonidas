<?php

namespace Leonidas\Contracts\System\Schema\User;

use WP_User_Query;

interface UserEntityManagerInterface
{
    public function select(int $id): object;

    public function whereIds(int ...$ids): object;

    public function selectByLogin(string $login): object;

    public function whereLogins(string ...$logins): object;

    public function selectByEmail(string $email): object;

    public function whereEmails(string ...$emails): object;

    public function selectByNicename(string $nicename): object;

    public function whereNicenames(string ...$nicenames): object;

    public function all(): object;

    public function find(array $queryArgs): object;

    public function query(WP_User_Query $query): object;

    public function insert(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function commit(): void;
}
