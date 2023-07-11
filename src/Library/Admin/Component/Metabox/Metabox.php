<?php

namespace Leonidas\Library\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Component\Metabox\Layout\SegmentedLayout;
use Leonidas\Library\Core\Http\Policy\NoPolicy;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Contracts\Controller\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Contracts\Report\ProcessedFormReportInterface;
use WebTheory\Saveyour\Controller\FormSubmissionManager;
use WP_Screen;

class Metabox implements MetaboxInterface
{
    use CanBeRestrictedTrait;

    protected string $id;

    protected string $title;

    /**
     * @var string|array<string>|WP_Screen
     */
    protected string|array|WP_Screen $screen;

    protected string $context = 'advanced';

    protected string $priority = 'default';

    protected array $args;

    protected MetaboxLayoutInterface $layout;

    protected FormSubmissionManagerInterface $inputManager;

    public function __construct(
        string $id,
        string $title,
        string|array|WP_Screen $screen,
        ?string $context = null,
        ?string $priority = null,
        array $args = [],
        ?MetaboxLayoutInterface $layout = null,
        ?ServerRequestPolicyInterface $policy = null,
        ?FormSubmissionManagerInterface $inputManager = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->screen = $screen;
        $this->context = $context ?? $this->context;
        $this->priority = $priority ?? $this->priority;
        $this->args = $args;

        $this->layout = $layout ?? new SegmentedLayout();
        $this->policy = $policy ?? new NoPolicy();
        $this->inputManager = $inputManager ?? new FormSubmissionManager([]);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getScreen(): string|array|WP_Screen
    {
        return $this->screen;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->layout->renderComponent($request);
    }

    public function processInput(ServerRequestInterface $request): ?ProcessedFormReportInterface
    {
        return $this->inputManager->process($request);
    }
}
