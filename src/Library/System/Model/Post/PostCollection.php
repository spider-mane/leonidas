<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Leonidas\Library\System\Model\Post\Abstracts\AbstractPostCollection;

class PostCollection extends AbstractPostCollection implements PostCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    public function __construct(PostInterface ...$posts)
    {
        $this->initKernel($posts);
    }
}
