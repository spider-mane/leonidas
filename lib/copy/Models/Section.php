<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\CopyInterface;
use WebContent\Copy\Contracts\SectionInterface;

class Section implements SectionInterface
{
    /**
     * @param list<CopyInterface> $details
     */
    public function __construct(
        protected string $name,
        protected string $description,
        protected string $reference,
        protected CopyInterface $main,
        protected array $details
    ) {
        //
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getMain(): CopyInterface
    {
        return $this->main;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'reference' => $this->getReference(),
            'description' => $this->getDescription(),
            'content' => [
                'main' => $this->getMain(),
                'details' => $this->getDetails()
            ]
        ];
    }
}
