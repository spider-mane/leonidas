<?php

namespace Leonidas\Library\System\Schema\Abstracts;

abstract class AbstractEntityConversionArchive
{
    protected array $conversions = [];

    protected array $reversions = [];

    public function hasRecords(): bool
    {
        return !empty($this->conversions)
            && !empty($this->reversions);
    }

    public function hasRecordOf(object $entity): bool
    {
        $record = $this->hash($entity);

        return isset($this->conversions[$record])
            || isset($this->reversions[$record]);
    }

    public function deleteRecordOf($entity): void
    {
        $record = $this->hash($entity);

        unset(
            $this->conversions[$record],
            $this->reversions[$record]
        );
    }

    protected function hash($post): string
    {
        return spl_object_hash($post);
    }
}
