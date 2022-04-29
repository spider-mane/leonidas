<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\PostEntityManager;
use WP_Query;

class PostRepository implements PostRepositoryInterface
{
    protected PostEntityManager $manager;

    public function __construct(PostConverterInterface $converter, PostCollectionFactory $factory)
    {
        $this->manager = new PostEntityManager('post', $converter, $factory);
    }

    public function select(int $id): ?PostInterface
    {
        return $this->manager->select($id);
    }

    public function whereIds(int ...$ids): PostCollectionInterface
    {
        return $this->manager->whereIds(...$ids);
    }

    public function selectByName(string $name): ?PostInterface
    {
        return $this->manager->selectByName($name);
    }

    public function whereNames(string ...$names): PostCollectionInterface
    {
        return $this->manager->whereNames(...$names);
    }

    public function all(): PostCollectionInterface
    {
        return $this->manager->all();
    }

    public function whereAuthor(AuthorInterface $author): PostCollectionInterface
    {
        return $this->manager->whereUserAndStatus($author->getId(), 'publish');
    }

    public function whereAuthorDrafts(AuthorInterface $author): PostCollectionInterface
    {
        return $this->manager->whereUserAndStatus($author->getId(), 'draft');
    }

    public function whereAuthorAll(AuthorInterface $author): PostCollectionInterface
    {
        return $this->manager->whereUser($author->getId());
    }

    public function whereStatus(PostStatusInterface $status): PostCollectionInterface
    {
        return $this->manager->whereStatus($status->getName());
    }

    public function find(array $args): PostCollectionInterface
    {
        return $this->manager->find($args);
    }

    public function query(WP_Query $query): PostCollectionInterface
    {
        return $this->manager->query($query);
    }

    public function insert(PostInterface $post): void
    {
        $this->manager->insert($this->extractData($post));
    }

    public function update(PostInterface $post): void
    {
        $this->manager->update($post->getId(), $this->extractData($post));
    }

    public function delete(int $postId): void
    {
        $this->manager->delete($postId);
    }

    public function trash(int $postId): void
    {
        $this->manager->trash($postId);
    }

    protected function extractData(PostInterface $post): array
    {
        $dateFormat = PostEntityManager::DATE_FORMAT;

        $post->applyFilter('db');

        return [
            'post_author' => $post->getAuthor()->getId(),
            'post_date' => $post->getDate()->format($dateFormat),
            'post_date_gmt' => $post->getDate()->format($dateFormat),
            'post_content' => $post->getContent(),
            'post_title' => $post->getTitle(),
            'post_excerpt' => $post->getExcerpt(),
            'post_status' => $post->getStatus()->getName(),
            'comment_status' => $post->getCommentStatus(),
            'ping_status' => $post->getPingStatus(),
            'post_password' => $post->getPassword(),
            'post_name' => $post->getName(),
            'to_ping' => $post->getPingQueue(),
            'pinged' => $post->hasBeenPinged(),
            'post_modified' => $post->getDate()->format($dateFormat),
            'post_modified_gmt' => $post->getDate()->format($dateFormat),
            'post_mime_type' => $post->getMimeType(),
            'menu_order' => $post->getMenuOrder(),
            'guid' => $post->getGuid()->getHref(),
            'post_category' => $post->getCategories()->extract('id'),
            'tags_input' => $post->getTags()->extract('id'),
            'tax_input' => $this->extractTaxInput($post),
            'meta_input' => $this->extractMetaInput($post),
        ];
    }

    protected function extractTaxInput(PostInterface $post): array
    {
        return [];
    }

    protected function extractMetaInput(PostInterface $post): array
    {
        return [];
    }
}
