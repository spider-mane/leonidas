<?php

namespace WebTheory\Leonidas\Framework;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Core\Auth\Nonce;
use WebTheory\Leonidas\Admin\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use WebTheory\Leonidas\Framework\AbstractModule;
use WebTheory\Leonidas\Framework\WpExtension;
use WebTheory\Leonidas\Admin\Metabox\Metabox;
use WebTheory\Leonidas\Admin\Traits\ExpectsPostTrait;

abstract class AbstractPostMetaBoxLoader extends AbstractModule
{
    use ExpectsPostTrait;

    /**
     * id
     *
     * @var string
     */
    protected $id;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $postType;

    /**
     * context
     *
     * @var string
     */
    protected $context = 'normal';

    /**
     * priority
     *
     * @var string
     */
    protected $priority = 'default';

    /**
     * callbackArgs
     *
     * @var array
     */
    protected $callbackArgs;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Nonce
     */
    protected $nonce;

    /**
     * @var Metabox
     */
    protected $metabox;

    /**
     * @var PostMetaBoxFormSubmissionManager
     */
    protected $form;

    /**
     *
     */
    public function __construct(WpExtension $extension)
    {
        parent::__construct($extension);

        $this->config = $this->config();
        $this->nonce = $this->createNonce();
        $this->metabox = $this->createMetaBox();
        $this->form = $this->createFormSubmissionManager();
    }

    /**
     *
     */
    public function hook()
    {
        add_action("add_meta_boxes_{$this->postType}", [$this, 'register']);
        add_action("save_post_{$this->postType}", [$this, 'save'], null, 3);
    }

    /**
     * Callback function to add metabox to admin ui
     *
     * @param $post
     */
    public function register()
    {
        add_meta_box(
            $this->id,
            $this->title,
            [$this, 'render'],
            $this->screen,
            $this->context,
            $this->priority,
            $this->callbackArgs
        );

        return $this;
    }

    /**
     *
     */
    public function render()
    {
        $this->metabox->setNonce($this->nonce);
    }

    /**
     *
     */
    abstract public function save();

    /**
     *
     */
    abstract protected function config(): array;

    /**
     *
     */
    abstract protected function createNonce(): Nonce;

    /**
     *
     */
    abstract protected function createMetaBox(): Metabox;

    /**
     *
     */
    abstract protected function getFieldMap(): array;

    /**
     *
     */
    abstract protected function createFormSubmissionManager(): PostMetaBoxFormSubmissionManager;

    /**
     *
     */
    abstract protected function getFormFieldControllers(ServerRequestInterface $request);
}
