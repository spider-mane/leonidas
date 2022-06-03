<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\HierarchicalModelRepositoryTrait;
use Leonidas\Library\System\Model\Abstracts\Term\AbstractTermEntityRepository;

class CategoryRepository extends AbstractTermEntityRepository implements CategoryRepositoryInterface
{
    use HierarchicalModelRepositoryTrait;

    public function select(int $id): ?CategoryInterface
    {
        return $this->manager->select($id);
    }

    public function selectSlug(string $slug): ?CategoryInterface
    {
        return $this->manager->selectSlug($slug);
    }

    public function whereIds(int ...$ids): CategoryCollectionInterface
    {
        return $this->manager->whereIds(...$ids);
    }

    public function whereObjectId(int $id): CategoryCollection
    {
        return $this->manager->whereObjectIds($id);
    }

    public function wherePost(PostInterface $post): CategoryCollection
    {
        return $this->manager->whereObjectIds($post->getId());
    }

    public function whereParent(CategoryInterface $parent): CategoryCollection
    {
        return $this->manager->whereParentId($parent->getId());
    }

    public function all(): CategoryCollection
    {
        return $this->manager->all();
    }

    public function insert(CategoryInterface $category): void
    {
        $this->manager->insert($this->extractData($category));
    }

    public function update(CategoryInterface $category): void
    {
        $this->manager->update(
            $category->getId(),
            $this->extractData($category)
        );
    }

    protected function extractData(CategoryInterface $category): array
    {
        return [
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'description' => $category->getDescription(),
            'parent' => $this->getParentId($category),
        ];
    }
}
