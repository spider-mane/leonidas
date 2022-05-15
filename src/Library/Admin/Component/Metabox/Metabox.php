<?php

namespace Leonidas\Library\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\MetaboxInterface;
use Leonidas\Contracts\Admin\Component\MetaboxLayoutInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Core\Http\Policies\NoPolicy;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class Metabox implements MetaboxInterface
{
    use CanBeRestrictedTrait;

    protected string $id;

    protected string $title;

    /**
     * @var string|string[]|WP_Screen
     */
    protected $screen;

    protected string $context = 'advanced';

    protected string $priority = 'default';

    protected array $args;

    public function __construct(
        string $id,
        string $title,
        string $screen,
        ?string $context = null,
        ?string $priority = null,
        array $args = [],
        MetaboxLayoutInterface $layout,
        ?ServerRequestPolicyInterface $policy = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->layout = $layout;
        $this->screen = $screen;
        $this->context = $context ?? $this->context;
        $this->priority = $priority ?? $this->priority;
        $this->args = $args;
        $this->layout = $layout;
        $this->policy = $policy ?? new NoPolicy();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get screen
     *
     * @return string|string[]|WP_Screen
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * Get context
     *
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * Get args
     *
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * Get layout
     *
     * @return MetaboxLayoutInterface
     */
    public function getLayout(): MetaboxLayoutInterface
    {
        return $this->layout;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->layout->renderComponent($request);
    }
}
