<?php

namespace Leonidas\Library\Domain\Interfaces;

interface PostTypeInterface
{
    public function getSlug(): string;

    public function getName(): string;

    public function getDescription(): string;

    public function isHierarchical(): bool;

    public function getCapabilityType(): string;

    public function getCapabilities(): array;

    public function getTaxonomies(): array;

    public function hasArchive(): bool;
}
