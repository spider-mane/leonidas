<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Admin\Loader\MetaboxLoaderInterface;
use Leonidas\Contracts\Admin\MetaboxCollectionInterface;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Framework\Modules\Traits\CreatesAdminNoticesTrait;
use Leonidas\Framework\Modules\Traits\HasExtraConstructionTrait;
use Leonidas\Library\Admin\Loaders\MetaboxLoader;
use Leonidas\Library\Core\Auth\Nonce;
use Leonidas\Library\Core\Http\Form\Authenticators\CsrfCheck;
use Leonidas\Library\Core\Http\Form\Authenticators\NoAutosave;
use Leonidas\Library\Core\Http\Form\Authenticators\Permissions\EditPost;
use Leonidas\Traits\Hooks\TargetsAddMetaBoxesXPostTypeHook;
use Leonidas\Traits\Hooks\TargetsEditFormTopHook;
use Leonidas\Traits\Hooks\TargetsSavePostXPostTypeHook;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormProcessingCacheInterface;
use WebTheory\Saveyour\Contracts\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Controllers\FormSubmissionManager;
use WP_Post;

abstract class AbstractPostTypeMetaboxesModule extends AbstractModule
{
    use CreatesAdminNoticesTrait;
    use HasExtraConstructionTrait;
    use TargetsAddMetaBoxesXPostTypeHook;
    use TargetsEditFormTopHook;
    use TargetsSavePostXPostTypeHook;

    protected string $postType;

    protected MetaboxCollectionInterface $metaboxCollection;

    protected function afterConstruction(): void
    {
        $this->postType = $this->postType();
    }

    protected function getPostType(): string
    {
        return $this->postType;
    }

    protected function getMetaboxCollection(): MetaboxCollectionInterface
    {
        return $this->metaboxCollection;
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

            echo $this->renderCsrfToken($request);
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
        return $this->postType === $postType;
    }

    protected function initMetaboxCollection(): MetaboxCollectionInterface
    {
        return $this->metaboxCollection = $this->metaboxes();
    }

    protected function registerMetaboxes(ServerRequestInterface $request): void
    {
        $this->metaboxLoader()->registerMany($this->initMetaboxCollection(), $request);
    }

    protected function renderCsrfToken(ServerRequestInterface $request): ?string
    {
        return ($nonce = $this->token()) ? $nonce->renderField() : null;
    }

    protected function processSubmittedFormData(ServerRequestInterface $request): void
    {
        $this->postFormProcessing($this->form()->process($request), $request);
    }

    protected function printMetabox(WP_Post $post, array $metabox): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('post', $post)
            ->withAttribute('metabox', $metabox);

        echo $this->getMetaboxCollection()
            ->getMetabox($metabox['id'])
            ->renderComponent($request);
    }

    protected function form(): FormSubmissionManagerInterface
    {
        $manager = new FormSubmissionManager();

        foreach ($this->formFields() as $field) {
            $manager->addField($field);
        }

        $manager->addValidator('user_cannot_edit', new EditPost());

        if ($this->allowAutosave()) {
            $manager->addValidator('no_autosave', new NoAutosave());
        }

        if ($token = $this->token()) {
            $manager->addValidator('invalid_request', new CsrfCheck($token));
        }

        return $manager;
    }

    protected function token(): ?CsrfManagerInterface
    {
        $prefix = $this->getExtension()->getPrefix();
        $user = get_current_user();
        $taxonomy = $this->getPostType();

        $name = "{$prefix}_{$user}_update_{$taxonomy}_nonce";
        $action = "{$prefix}_{$user}_update_{$taxonomy}";

        return new Nonce($name, $action);
    }

    protected function metaboxLoader(): MetaboxLoaderInterface
    {
        return new MetaboxLoader($this->callbackMethod('printMetabox'));
    }

    protected function allowAutosave(): bool
    {
        return false;
    }

    protected function postFormProcessing(FormProcessingCacheInterface $form, ServerRequestInterface $request): void
    {
        //
    }

    abstract protected function postType(): string;

    abstract protected function metaboxes(): MetaboxCollectionInterface;

    /**
     * @return FormFieldControllerInterface[]
     */
    abstract protected function formFields(): array;
}
