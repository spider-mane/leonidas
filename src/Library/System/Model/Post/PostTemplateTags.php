<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\Post\UsesTemplateTagsTrait;
use WP_Post;

class PostTemplateTags extends PostGetAccessProvider implements GetAccessProviderInterface
{
    use UsesTemplateTagsTrait;

    public function __construct(PostInterface $post, WP_Post $core)
    {
        parent::__construct($post);
        $this->stashPostObject($core);
    }

    protected function resolvedGetters(PostInterface $post): array
    {
        return [
            'id' => $this->templateTag('the_ID'),
            'title' => $this->templateTag('the_title'),
            'content' => $this->templateTag('the_content'),
            'excerpt' => $this->templateTag('the_excerpt'),
            'guid' => $this->templateTag('the_guid'),
            'hasExcerpt' => $this->function('has_excerpt'),
            'has_excerpt' => $this->function('has_excerpt'),
            'passwordRequired' => $this->function('post_password_required'),
        ] + parent::resolvedGetters($post);
    }
}
