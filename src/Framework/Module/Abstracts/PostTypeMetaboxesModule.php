<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCollectionInterface;
use Leonidas\Contracts\Admin\Registrar\MetaboxRegistrarInterface;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\Traits\CreatesAdminNoticesTrait;
use Leonidas\Hooks\TargetsAddMetaBoxesXPostTypeHook;
use Leonidas\Hooks\TargetsEditFormTopHook;
use Leonidas\Hooks\TargetsSavePostXPostTypeHook;
use Psr\Http\Message\ServerRequestInterface;
use WP_Post;

abstract class PostTypeMetaboxesModule extends Module implements ModuleInterface
{
    use CreatesAdminNoticesTrait;
    use TargetsAddMetaBoxesXPostTypeHook;
    use TargetsEditFormTopHook;
    use TargetsSavePostXPostTypeHook;

    protected string $postType;

    protected function getPostType(): string
    {
        return $this->postType ??= $this->postType();
    }

    public function hook(): void
    {
        $this->targetAddMetaBoxesXPostTypeHook();
        $this->targetEditFormTopHook();
        $this->targetSavePostXPostTypeHook();
    }

    protected function doAddMetaBoxesXPostTypeAction(WP_Post $post): void
    {
        $request = $this->getServerRequest()->withAttribute('post', $post);

        $this->registerMetaboxes($request);
    }

    protected function doEditFormTopAction(WP_Post $post): void
    {
        if ($this->isMatchingPostType($post->post_type)) {
            $request = $this->getServerRequest()->withAttribute('post', $post);

            echo $this->renderCsrfField($request);
        }
    }

    protected function doSavePostXPostTypeAction(int $postId, WP_Post $post, bool $update): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('post_id', $postId)
            ->withAttribute('post', $post)
            ->withAttribute('update', $update);

        $this->processSubmittedFormData($request);
    }

    protected function isMatchingPostType(string $postType): bool
    {
        return $this->getPostType() === $postType;
    }

    protected function registerMetaboxes(ServerRequestInterface $request): void
    {
        $this->metaboxRegistrar()->registerMany($this->metaboxes(), $request);
    }

    protected function renderCsrfField(ServerRequestInterface $request): ?string
    {
        return $this->token()->renderField();
    }

    protected function processSubmittedFormData(ServerRequestInterface $request): void
    {
        foreach ($this->metaboxes()->getMetaboxes() as $metabox) {
            $metabox->processInput($request);
        }
    }

    protected function token(): ?CsrfManagerInterface
    {
        return $this->csrfRepository()->get("update_{$this->postType()}");
    }

    protected function metaboxRegistrar(): MetaboxRegistrarInterface
    {
        return $this->getService(MetaboxRegistrarInterface::class);
    }

    protected function csrfRepository(): CsrfManagerRepositoryInterface
    {
        return $this->getService(CsrfManagerRepositoryInterface::class);
    }

    abstract protected function postType(): string;

    abstract protected function metaboxes(): MetaboxCollectionInterface;
}
