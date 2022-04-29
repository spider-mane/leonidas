<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\Post\ForcesTemplateTagsTrait;
use WP_Post;

class ForcedPostTemplateTags extends PostTemplateTags implements GetAccessProviderInterface
{
    use ForcesTemplateTagsTrait;

    public function __construct(PostInterface $post, WP_Post $core)
    {
        parent::__construct($post);

        $this->core = $core;
    }
}
