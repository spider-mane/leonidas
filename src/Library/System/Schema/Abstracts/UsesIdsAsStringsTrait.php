<?php

namespace Leonidas\Library\System\Schema\Abstracts;

trait UsesIdsAsStringsTrait
{
    /**
     * @return numeric-string
     */
    protected function stringifyId(int $id): string
    {
        return (string) $id;
    }

    /**
     * @return list<numeric-string>
     */
    protected function stringifyIds(int ...$ids): array
    {
        return array_map($this->stringifyId(...), $ids);
    }

    /**
     * @param int|iterable<int> $idx
     *
     * @return numeric-string|list<numeric-string>
     */
    protected function stringifyIdx(int|iterable $idx): string|array
    {
        return is_int($idx)
            ? $this->stringifyId($idx)
            : $this->stringifyIds(...$idx);
    }

    /**
     * @param numeric-string $id
     */
    protected function normalizeId(string $id): int
    {
        return (int) $id;
    }

    /**
     * @param numeric-string $ids
     *
     * @return list<int>
     */
    protected function normalizeIds(string ...$ids): array
    {
        return array_map($this->normalizeId(...), $ids);
    }

    /**
     * @param numeric-string|iterable<numeric-string> $idx
     *
     * @return int|list<int>
     */
    protected function normalizeIdx(string|iterable $idx): int|array
    {
        return is_string($idx)
            ? $this->normalizeId($idx)
            : $this->normalizeIds(...$idx);
    }
}
