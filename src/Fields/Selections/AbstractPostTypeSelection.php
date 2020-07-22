<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Post;
use WebTheory\Saveyour\Contracts\SuperSelectionProviderInterface;

abstract class AbstractPostTypeSelection extends AbstractPostSuperSelection implements SuperSelectionProviderInterface
{
    /**
     * @var string
     */
    protected $postType;

    /**
     *
     */
    public function __construct(string $postType)
    {
        $this->postType = $postType;
    }

    /**
     * @return WP_Post[]
     */
    public function provideItemsAsRawData(): array
    {
        return get_posts([
            'post_type' => $this->postType,
            'posts_per_page' => -1
        ]);
    }
}
