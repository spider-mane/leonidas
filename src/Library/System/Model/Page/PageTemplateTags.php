<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\Post\UsesTemplateTagsTrait;
use WP_Post;

class PageTemplateTags extends PageGetAccessProvider implements GetAccessProviderInterface
{
    use UsesTemplateTagsTrait;

    public function __construct(PageInterface $post, WP_Post $core)
    {
        parent::__construct($post);
        $this->stashPostObject($core);
    }

    protected function resolvedGetters(PageInterface $page): array
    {
        return [
            'id' => $this->templateTag('the_ID'),
            'title' => $this->templateTag('the_title'),
            'content' => $this->templateTag('the_content'),
            'guid' => $this->templateTag('the_guid'),
            'passwordRequired' => $this->function('post_password_required'),
        ] + parent::resolvedGetters($page);
    }
}
