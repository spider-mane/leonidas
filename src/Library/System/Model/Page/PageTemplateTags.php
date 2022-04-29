<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\Post\ForcesTemplateTagsTrait;
use WP_Post;

class PageTemplateTags extends GlobalPageTemplateTags implements GetAccessProviderInterface
{
    use ForcesTemplateTagsTrait;

    public function __construct(PageInterface $post, WP_Post $core)
    {
        parent::__construct($post);

        $this->core = $core;
    }
}
