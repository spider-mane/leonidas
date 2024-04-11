<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeInterface;
use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRepositoryInterface;

class PolyRelatablePostTypeRepository implements PolyRelatablePostTypeRepositoryInterface
{
    /**
     * @var array<string,PolyRelatablePostTypeInterface>
     */
    protected array $relatables;

    /**
     * @var array<string,string>
     */
    protected array $shadows;

    public function get(string $postType): PolyRelatablePostTypeInterface
    {
        return $this->relatables[$postType];
    }

    public function getByShadow(string $shadow): PolyRelatablePostTypeInterface
    {
        return $this->get($this->shadows[$shadow]);
    }

    public function has(string $postType): bool
    {
        return isset($this->relatables[$postType]);
    }

    public function hasByShadow(string $shadow): bool
    {
        return isset($this->shadows[$shadow]);
    }

    public function add(PolyRelatablePostTypeInterface $relatable): void
    {
        $postType = $relatable->getMappedPostType();
        $taxonomy = $relatable->getShadowTaxonomy();

        $this->relatables[$postType] = $relatable;
        $this->shadows[$taxonomy] = $postType;
    }
}
