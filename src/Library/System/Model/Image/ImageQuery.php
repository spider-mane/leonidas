<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\Image\ImageCollectionInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\Post\PoweredByModelQueryKernelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Image\Abstracts\AbstractImageCollection;
use WP_Query;

class ImageQuery extends AbstractImageCollection implements ImageCollectionInterface
{
    use PoweredByModelQueryKernelTrait;
    use ValidatesPostTypeTrait;

    public function __construct(WP_Query $query, PostConverterInterface $converter)
    {
        $this->assertPostTypeOnQuery($query, 'attachment');
        $this->initKernel($query, $converter);
    }
}
