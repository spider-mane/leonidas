<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\Post\PoweredByModelQueryKernelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Page\Abstracts\AbstractPageCollection;
use WP_Query;

class PageQuery extends AbstractPageCollection implements PageCollectionInterface
{
    use PoweredByModelQueryKernelTrait;
    use ValidatesPostTypeTrait;

    public function __construct(WP_Query $query, PostConverterInterface $converter)
    {
        $this->assertPostTypeOnQuery($query, 'page');
        $this->initKernel($query, $converter);
    }
}
