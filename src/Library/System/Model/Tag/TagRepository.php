<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\Term\AbstractTermEntityRepository;

class TagRepository extends AbstractTermEntityRepository implements TagRepositoryInterface
{
    public function select(int $id): TagInterface
    {
        return $this->manager->select($id);
    }

    public function selectBySlug(string $slug): TagInterface
    {
        return $this->manager->selectBySlug($slug);
    }

    public function withObjectId(int $id): TagCollectionInterface
    {
        return $this->manager->whereObjectIds($id);
    }

    public function withPost(PostInterface $post): TagCollectionInterface
    {
        return $this->manager->whereObjectIds($post->getId());
    }

    public function all(): TagCollectionInterface
    {
        return $this->manager->all();
    }

    public function insert(TagInterface $tag): void
    {
        $this->manager->insert($this->extractData($tag));
    }

    public function update(TagInterface $tag): void
    {
        $this->manager->update($tag->getId(), $this->extractData($tag));
    }

    protected function extractData(TagInterface $tag): array
    {
        return [
            'name' => $tag->getName(),
            'slug' => $tag->getSlug(),
            'description' => $tag->getDescription(),
        ];
    }
}
