<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\Post\PoweredByModelQueryKernelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Post\Abstracts\AbstractPostCollection;
use WP_Query;

class PostQuery extends AbstractPostCollection implements PostCollectionInterface
{
    use ValidatesPostTypeTrait;
    use PoweredByModelQueryKernelTrait;

    public function __construct(WP_Query $query, PostConverterInterface $converter)
    {
        $this->assertPostTypeOnQuery($query, 'post');
        $this->initKernel($query, $converter);
    }
}
