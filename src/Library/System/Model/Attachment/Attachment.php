<?php

namespace Leonidas\Library\System\Model\Attachment;

use Leonidas\Contracts\System\Model\Attachment\AttachmentInterface;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\Post\FilterablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MimePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableAuthoredPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableCommentablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableDatablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePingablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\PolymorphicPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\RestrictablePostModelTrait;
use WP_Post;

class Attachment implements AttachmentInterface
{
    use MutableAuthoredPostModelTrait;
    use FilterablePostModelTrait;
    use MimePostModelTrait;
    use MutableCommentablePostModelTrait;
    use MutableDatablePostModelTrait;
    use MutablePingablePostModelTrait;
    use MutablePostModelTrait;
    use PolymorphicPostModelTrait;
    use RestrictablePostModelTrait;

    protected WP_Post $post;

    protected AuthorRepositoryInterface $authorRepository;

    public function __construct(WP_Post $post, AuthorRepositoryInterface $authorRepository)
    {
        $this->post = $post;
        $this->authorRepository = $authorRepository;
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
}
