<?php

namespace WebContent\Copy\Contracts;

interface ViewContentInterface extends ViewDataInterface
{
    public function getHero(): CopyInterface;

    /**
     * @return list<SectionInterface>
     */
    public function getSections(): array;
}
