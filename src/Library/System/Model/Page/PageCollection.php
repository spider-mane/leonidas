<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Leonidas\Library\System\Model\Page\Abstracts\AbstractPageCollection;

class PageCollection extends AbstractPageCollection implements PageCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    public function __construct(PageInterface ...$pages)
    {
        $this->initKernel($pages);
    }
}
