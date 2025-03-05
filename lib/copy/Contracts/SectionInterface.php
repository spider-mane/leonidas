<?php

namespace WebContent\Copy\Contracts;

interface SectionInterface extends ViewDataInterface
{
    // public function getId(): mixed;

    public function getName(): string;

    public function getDescription(): string;

    public function getReference(): string;

    public function getMain(): CopyInterface;

    /**
     * @return list<CopyInterface>
     */
    public function getDetails(): array;
}
