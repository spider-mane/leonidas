<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Hooks\TargetsEditFormTopHook;
use Psr\Http\Message\ServerRequestInterface;
use WP_Post;

abstract class PostEditFormCsrfModule extends Module implements ModuleInterface
{
    use TargetsEditFormTopHook;

    public function hook(): void
    {
        $this->targetEditFormTopHook();
    }

    protected function doEditFormTopAction(WP_Post $post): void
    {
        if ($this->isMatchingPostType($post->post_type)) {
            $this->renderCsrfField(
                $this->getServerRequest()->withAttribute('post', $post)
            );
        }
    }

    private function isMatchingPostType(string $postType): bool
    {
        $targeted = $this->postTypes();

        return empty($targeted) || in_array($postType, $targeted);
    }

    private function renderCsrfField(ServerRequestInterface $request): void
    {
        echo $this->getCsrfField()->renderField();
    }

    protected function getCsrfField(): CsrfManagerInterface
    {
        return $this->repository()->get($this->field());
    }

    abstract protected function postTypes(): array;

    abstract protected function repository(): CsrfManagerRepositoryInterface;

    abstract protected function field(): string;
}
