<?php

namespace Leonidas\Contracts\System\Model;

interface MutableTermModelInterface extends TermModelInterface
{
    public function setName(string $name): self;

    public function setSlug(string $slug): self;

    public function setTaxonomyId(int $taxonomyId): self;

    public function setGroup(int $group): self;

    public function setFilter(string $name): self;
}
