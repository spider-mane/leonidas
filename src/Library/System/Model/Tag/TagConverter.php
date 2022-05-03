<?php

namespace Leonidas\Library\System\Model\Tag;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use WP_Term;

class TagConverter implements TermConverterInterface
{
    protected PostRepositoryInterface $postRepository;

    protected string $taxonomyPrefix = '';

    public function __construct(PostRepositoryInterface $postRepository, string $taxonomyPrefix = '')
    {
        $this->postRepository = $postRepository;
        $this->taxonomyPrefix = $taxonomyPrefix;
    }

    public function convert(WP_Term $term): Tag
    {
        return new Tag($term, $this->postRepository, $this->taxonomyPrefix);
    }

    public function revert(object $entity): WP_Term
    {
        if ($entity instanceof TagInterface) {
            return get_term($entity->getId(), 'post_tag');
        }

        throw new InvalidArgumentException(
            '$entity must be an instance of ' . TagInterface::class
        );
    }
}
