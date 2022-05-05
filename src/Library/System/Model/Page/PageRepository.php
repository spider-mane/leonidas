<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\HierarchicalModelRepositoryTrait;
use Leonidas\Library\System\Model\Abstracts\Post\AbstractPostEntityRepository;
use Leonidas\Library\System\Schema\Post\PostEntityManager;

class PageRepository extends AbstractPostEntityRepository implements PageRepositoryInterface
{
    use HierarchicalModelRepositoryTrait;

    public function select(int $id): ?PageInterface
    {
        return $this->manager->select($id);
    }

    public function whereIds(int ...$ids): PageCollectionInterface
    {
        return $this->manager->whereIds(...$ids);
    }

    public function selectByName(string $name): ?PageInterface
    {
        return $this->manager->selectByName($name);
    }

    public function whereNames(string ...$names): PageCollectionInterface
    {
        return $this->manager->whereNames(...$names);
    }

    public function whereParent(?PageInterface $parent): PageCollectionInterface
    {
        return $this->manager->whereParentId($parent->getId());
    }

    public function whereParentId(int $parentId): PageCollectionInterface
    {
        return $this->manager->whereParentId($parentId);
    }

    public function query(array $args): PageCollectionInterface
    {
        return $this->manager->query($args);
    }

    public function all(): PageCollectionInterface
    {
        return $this->manager->all();
    }

    public function insert(PageInterface $page): void
    {
        $this->manager->insert($this->extractData($page));
    }

    public function update(PageInterface $page): void
    {
        $this->manager->update($page->getId(), $this->extractData($page));
    }

    protected function extractData(PageInterface $page): array
    {
        $dateFormat = PostEntityManager::DATE_FORMAT;

        $page->applyFilter('db');

        return [
            'post_author' => $page->getAuthor()->getId(),
            'post_date' => $page->getDate()->format($dateFormat),
            'post_date_gmt' => $page->getDate()->format($dateFormat),
            'post_content' => $page->getContent(),
            'post_title' => $page->getTitle(),
            'post_status' => $page->getStatus()->getName(),
            'post_parent' => $this->getParentId($page),
            'comment_status' => $page->getCommentStatus(),
            'ping_status' => $page->getPingStatus(),
            'to_ping' => $page->getToBePinged(),
            'pinged' => $page->getPinged(),
            'post_password' => $page->getPassword(),
            'post_name' => $page->getName(),
            'post_modified' => $page->getDate()->format($dateFormat),
            'post_modified_gmt' => $page->getDate()->format($dateFormat),
            'post_mime_type' => $page->getMimeType(),
            'menu_order' => $page->getMenuOrder(),
            'guid' => $page->getGuid()->getHref(),
            'tax_input' => $this->extractTaxInput($page),
            'meta_input' => $this->extractMetaInput($page),
        ];
    }

    protected function extractTaxInput(PageInterface $page): array
    {
        return [];
    }

    protected function extractMetaInput(PageInterface $page): array
    {
        return [];
    }
}
