<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use WP_Term;

class CategoryCollection implements CategoryCollectionInterface
{
    protected array $categories;

    public function __construct(CategoryInterface ...$categories)
    {
        $this->categories = $categories;
    }

    public function all(): array
    {
        return $this->categories;
    }

    public static function adapt(array $categories): CategoryCollection
    {
        return new static(...array_map(
            fn (WP_Term $category) => new Category($category),
            $categories
        ));
    }
}
