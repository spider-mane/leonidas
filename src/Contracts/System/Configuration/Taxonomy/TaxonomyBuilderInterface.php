<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeBuilderInterface;

interface TaxonomyBuilderInterface extends BaseSystemModelTypeBuilderInterface
{
    public function objectTypes(string ...$objectTypes): self;

    public function showTagCloud(?bool $showInTagCloud): self;

    public function showInQuickEdit(?bool $showInQuickEdit): self;

    public function showAdminColumn(?bool $showAdminColumn): self;

    /**
     * @param null|bool|callable $metaBoxCb
     */
    public function metaBoxCb($metaBoxCb): self;

    public function metaBoxSanitizeCb(?callable $metaBoxSanitizeCb): self;

    public function updateCountCallback(?callable $updateCountCallback): self;

    /**
     * @param null|string|array $defaultTerm
     */
    public function defaultTerm($defaultTerm): self;

    public function sort(?bool $sort): self;

    public function args(?array $args): self;

    public function get(): TaxonomyInterface;
}
