<?php

namespace Leonidas\Contracts\System\Schema;

interface EntityConversionArchiveInterface
{
    public function hasRecords(): bool;

    public function hasRecordOf(object $object): bool;

    public function deleteRecordOf(object $object): void;
}
