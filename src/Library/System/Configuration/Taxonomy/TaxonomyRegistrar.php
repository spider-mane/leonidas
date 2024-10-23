<?php

namespace Leonidas\Library\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyInterface;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyRegistrarInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractModelConfigurationRegistrar;

class TaxonomyRegistrar extends AbstractModelConfigurationRegistrar implements TaxonomyRegistrarInterface
{
    protected ?TaxonomyOptionHandlerCollectionInterface $optionHandlers = null;

    public function __construct(?TaxonomyOptionHandlerCollectionInterface $optionHandlers = null)
    {
        $this->optionHandlers = $optionHandlers;
    }

    public function registerOne(TaxonomyInterface $taxonomy)
    {
        $registered = register_taxonomy(
            $name = $taxonomy->getName(),
            $types = $taxonomy->getObjectTypes(),
            $this->getArgs($taxonomy)
        );

        foreach ($types as $type) {
            register_taxonomy_for_object_type($name, $type);
        }

        $registered->extra = $taxonomy->getExtra();

        if (isset($this->optionHandlers)) {
            $this->registerOptions($taxonomy);
        }
    }

    public function registerMany(TaxonomyInterface ...$taxonomies)
    {
        foreach ($taxonomies as $taxonomy) {
            $this->registerOne($taxonomy);
        }
    }

    protected function getArgs(TaxonomyInterface $taxonomy)
    {
        $args = [
            // core
            "default_term" => $taxonomy->getDefaultTerm(),
            "update_count_callback" => $taxonomy->getUpdateCountCallback(),
            "sort" => $taxonomy->shouldBeSorted(),
            "args" => $taxonomy->getArgs(),

            // web
            "show_tagcloud" => $taxonomy->isAllowedInTagCloud(),

            // admin
            "show_in_menu" => $taxonomy->isAllowedInMenu(),
            "show_in_quick_edit" => $taxonomy->isAllowedInQuickEdit(),
            "show_admin_column" => $taxonomy->canHaveAdminColumn(),
            "meta_box_cb" => $taxonomy->getMetaBoxCb(),
            "meta_box_sanitize_cb" => $taxonomy->getMetaBoxSanitizeCb(),
        ] + $this->getBaseArgs($taxonomy);

        return array_filter($args, fn ($arg) => $arg !== null);
    }

    protected function registerOptions(TaxonomyInterface $taxonomy)
    {
        foreach ($taxonomy->getExtra() as $option => $value) {
            if ($this->optionHandlers->has($option)) {
                $this->optionHandlers->get($option)->handle($taxonomy, $value);
            }

            throw $this->unregisteredOptionException($option);
        }
    }
}
