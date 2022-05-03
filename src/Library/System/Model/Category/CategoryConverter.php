<?php

namespace Leonidas\Library\System\Model\Category;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use WP_Term;

class CategoryConverter implements TermConverterInterface
{
    protected CategoryRepositoryInterface $categoryRepository;

    protected PostRepositoryInterface $postRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, PostRepositoryInterface $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function convert(WP_Term $term): CategoryInterface
    {
        return new Category(
            $term,
            $this->postRepository,
            $this->categoryRepository
        );
    }

    public function revert(object $entity): WP_Term
    {
        if ($entity instanceof CategoryInterface) {
            return get_term($entity->getId(), 'category');
        }

        throw new InvalidArgumentException(
            '$entity must be an instance of ' . CategoryInterface::class
        );
    }
}
