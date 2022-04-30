<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Leonidas\Library\System\Model\Post\Abstracts\AbstractPostCollection;

class PostCollection extends AbstractPostCollection implements PostCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'name';

    protected const COLLECTION_IS_MAP = true;

    public function __construct(PostInterface ...$posts)
    {
        $this->initKernel($posts);
    }

    public function getByName(string $name): ?PostInterface
    {
        return $this->kernel->fetch($name);
    }

    public function containsName(string $name): bool
    {
        return $this->kernel->contains($name);
    }
}
