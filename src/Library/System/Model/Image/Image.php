<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use Leonidas\Library\System\Model\Abstracts\Post\FilterablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MimePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableAuthoredPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableCommentablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableDatablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePingablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableTitledTrait;
use Leonidas\Library\System\Model\Abstracts\Post\PolymorphicPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\RestrictablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use WP_Post;

class Image implements ImageInterface
{
    use AllAccessGrantedTrait;
    use FilterablePostModelTrait;
    use LazyLoadableRelationshipsTrait;
    use MimePostModelTrait;
    use MutableAuthoredPostModelTrait;
    use MutableCommentablePostModelTrait;
    use MutableDatablePostModelTrait;
    use MutablePingablePostModelTrait;
    use MutablePostModelTrait;
    use MutableTitledTrait;
    use PolymorphicPostModelTrait;
    use RestrictablePostModelTrait;
    use ValidatesPostTypeTrait;

    public function __construct(
        WP_Post $post,
        AutoInvokerInterface $autoInvoker,
        ?AuthorInterface $author = null,
        ?CommentCollectionInterface $comments = null
    ) {
        $this->assertPostType($post, 'attachment');

        $this->post = $post;
        $this->autoInvoker = $autoInvoker;

        $author && $this->author = $author;
        $comments && $this->comments = $comments;

        $this->getAccessProvider = new ImageTemplateTags($this, $post);
        $this->setAccessProvider = new ImageSetAccessProvider($this);
    }

    public function getSrc(string $size = 'full'): string
    {
        return wp_get_attachment_image_url($this->getId(), $size);
    }

    public function getSrcset(string $size = 'full'): string
    {
        return wp_get_attachment_image_srcset($this->getId(), $size);
    }

    public function getAlt(): string
    {
        return $this->getPostModelMeta('_wp_attachment_image_alt');
    }

    public function setAlt(string $alt): Image
    {
        $this->setPostModelMeta('_wp_attachment_image_alt', $alt);

        return $this;
    }

    public function getCaption(): string
    {
        return $this->post->post_excerpt;
    }

    public function setCaption(string $caption): self
    {
        $this->post->post_excerpt = $caption;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->post->post_content;
    }

    public function setDescription(string $description): self
    {
        $this->post->post_content = $description;

        return $this;
    }

    public function getFileUrl(): string
    {
        return wp_get_attachment_url($this->getId());
    }

    public function getMetadata(): array
    {
        return wp_get_attachment_metadata($this->getId());
    }
}
