<?php

namespace Leonidas\Contracts\System\Schema\Term;

use WP_Term_Query;

interface TermEntityManagerInterface
{
    public function select(int $id): object;

    public function whereIds(int ...$ids): object;

    public function selectByTermTaxonomyId(int $termTaxonomyId): object;

    public function whereTermTaxonomyIds(int ...$termTaxonomyIds): object;

    public function selectBySlug(string $slug): object;

    public function whereSlugs(string ...$slugs): object;

    public function whereTaxonomies(string ...$taxonomies): object;

    public function whereParentId(int $parentId): object;

    public function whereObjects(int ...$objects): object;

    public function all(): object;

    public function find(array $queryArgs): object;

    public function query(WP_Term_Query $query): object;

    public function insert(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function commit(): void;
}
