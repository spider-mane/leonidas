<?php

namespace Leonidas\Contracts\Admin\Component\Metabox;

use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Contracts\Controller\FormSubmissionManagerInterface;
use WP_Screen;

interface MetaboxBuilderInterface
{
    /**
     * @return $this
     */
    public function id(string $id): static;

    /**
     * @return $this
     */
    public function title(string $title): static;

    /**
     * @param string|array<string>|WP_Screen $screen
     *
     * @return $this
     */
    public function screen(string|array|WP_Screen $screen): static;

    /**
     * @return $this
     */
    public function context(?string $context): static;

    /**
     * @return $this
     */
    public function priority(?string $priority): static;

    /**
     * @return $this
     */
    public function args(?array $args): static;

    /**
     * @return $this
     */
    public function layout(?MetaboxLayoutInterface $layout): static;

    /**
     * @return $this
     */
    public function inputManager(?FormSubmissionManagerInterface $inputManager): static;

    /**
     * @return $this
     */
    public function policy(?ServerRequestPolicyInterface $policy): static;

    public function get(): MetaboxInterface;
}
