<?php

namespace Leonidas\Library\System\Model\Abstracts\Term;

trait MutableTermModelTrait
{
    use TermModelTrait;

    public function setName(string $name): self
    {
        $this->term->name = $name;

        return $this;
    }

    public function setSlug(string $slug): self
    {
        $this->term->slug = $slug;

        return $this;
    }

    public function setTaxonomyId(int $taxonomyId): self
    {
        $this->term->term_taxonomy_id = $taxonomyId;

        return $this;
    }

    public function setGroup(int $group): self
    {
        $this->term->term_group = $group;

        return $this;
    }
}
