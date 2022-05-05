<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use WP_Post;
use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;

abstract class AbstractPostTypeSelection extends AbstractPostSelectionProvider implements SelectionProviderInterface
{
    /**
     * @var string
     */
    protected $postType;

    public function __construct(string $postType)
    {
        $this->postType = $postType;
    }

    /**
     * @return WP_Post[]
     */
    public function provideSelectionsData(): array
    {
        return get_posts([
            'post_type' => $this->postType,
            'posts_per_page' => -1,
        ]);
    }
}
