<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\ModelConfigurationBuilderInterface;

interface TaxonomyBuilderInterface extends ModelConfigurationBuilderInterface
{
    /**
     * @param list<string> $objectTypes
     *
     * @return $this
     */
    public function objectTypes(?array $objectTypes): static;

    /**
     * @return $this
     */
    public function showInTagCloud(?bool $showInTagCloud): static;

    /**
     * @return $this
     */
    public function showInQuickEdit(?bool $showInQuickEdit): static;

    /**
     * @return $this
     */
    public function showAdminColumn(?bool $showAdminColumn): static;

    /**
     * @return $this
     */
    public function metaBoxCb(null|bool|callable $metaBoxCb): static;

    /**
     * @return $this
     */
    public function metaBoxSanitizeCb(?callable $metaBoxSanitizeCb): static;

    /**
     * @return $this
     */
    public function updateCountCallback(?callable $updateCountCallback): static;

    /**
     * @return $this
     */
    public function defaultTerm(null|string|array $defaultTerm): static;

    /**
     * @return $this
     */
    public function sort(?bool $sort): static;

    /**
     * @return $this
     */
    public function args(?array $args): static;

    public function get(): TaxonomyInterface;
}
