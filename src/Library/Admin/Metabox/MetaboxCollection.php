<?php

namespace Leonidas\Library\Admin\Metabox;

use Leonidas\Contracts\Admin\Components\MetaboxInterface;
use Leonidas\Contracts\Admin\MetaboxCollectionInterface;

class MetaboxCollection implements MetaboxCollectionInterface
{
    /**
     * @var MetaboxInterface[]
     */
    protected $metaboxes = [];

    public function __construct(MetaboxInterface ...$metaboxes)
    {
        array_map([$this, 'addMetabox'], $metaboxes);
    }

    public function getMetaboxes(): array
    {
        return $this->metaboxes;
    }

    public function addMetabox(MetaboxInterface $metabox)
    {
        $this->metaboxes[$metabox->getId()] = $metabox;
    }

    public function hasMetabox(string $metabox): bool
    {
        return isset($this->metaboxes[$metabox]);
    }

    public function getMetabox(string $metabox): MetaboxInterface
    {
        return $this->metaboxes[$metabox];
    }

    public static function with(MetaboxInterface ...$metaboxes): MetaboxCollection
    {
        return new static(...$metaboxes);
    }

    /**
     * @param MetaboxInterface[] $metaboxes
     */
    public static function from(array $metaboxes): MetaboxCollection
    {
        return new static(...$metaboxes);
    }
}
