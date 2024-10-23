<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\AttachmentEntityManagerInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\QueryContextResolverInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\RelatablePostKeyInterface;

class AttachmentEntityManager extends PostEntityManager implements AttachmentEntityManagerInterface
{
    public function __construct(
        protected readonly string $mimeType,
        PostConverterInterface $postConverter,
        EntityCollectionFactoryInterface $collectionFactory,
        RelatablePostKeyInterface $keyResolver,
        ?QueryFactoryInterface $queryFactory = null,
        ?QueryContextResolverInterface $contextResolver = null,
        array $entryMap = []
    ) {
        parent::__construct(
            'attachment',
            $postConverter,
            $collectionFactory,
            $keyResolver,
            $queryFactory,
            $contextResolver,
            $entryMap
        );
    }

    public function byAttachedToPost(int $id): ?object
    {
        return $this->single(['post_parent' => $id]);
    }

    public function whereAttachedToPost(int $id): object
    {
        return $this->query(['post_parent' => $id]);
    }

    protected function getInputSpecialKeys(): array
    {
        return [
            'file' => null,
            'metadata' => null,
        ] + parent::getInputSpecialKeys();
    }

    protected function doInputActions(int $id, array $data): void
    {
        if ($file = $data['file']) {
            update_attached_file($id, $file);
        }

        if ($metadata = $data['metadata']) {
            wp_update_attachment_metadata($id, $metadata);
        }

        parent::doInputActions($id, $data);
    }

    protected function getDefaultEntries(): array
    {
        return [
            'file' => 'meta:_wp_attached_file',
            'alt' => 'meta:_wp_attachment_image_alt',
            'metadata' => 'meta:_wp_attachment_metadata',
        ] + parent::getDefaultEntries();
    }

    protected function normalizeQueryArgs($args): array
    {
        return [
            'post_mime_type' => $this->mimeType,
        ] + parent::normalizeQueryArgs($args) + [
            'post_status' => 'inherit',
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ];
    }
}
