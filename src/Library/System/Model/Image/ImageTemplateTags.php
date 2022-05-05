<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Library\System\Model\Abstracts\Post\UsesTemplateTagsTrait;
use WP_Post;

class ImageTemplateTags extends ImageGetAccessProvider implements GetAccessProviderInterface
{
    use UsesTemplateTagsTrait;

    public function __construct(ImageInterface $image, WP_Post $core)
    {
        parent::__construct($image);
        $this->stashPostObject($core);
    }

    protected function resolvedGetters(ImageInterface $image): array
    {
        return [
            'id' => $this->templateTag('the_ID'),
            'title' => $this->templateTag('the_title'),
            'description' => $this->templateTag('the_content'),
            'caption' => $this->templateTag('the_excerpt'),
            'guid' => $this->templateTag('the_guid'),
            'hasExcerpt' => $this->function('has_excerpt'),
            'has_excerpt' => $this->function('has_excerpt'),
            'passwordRequired' => $this->function('post_password_required'),
        ] + parent::resolvedGetters($image);
    }
}
