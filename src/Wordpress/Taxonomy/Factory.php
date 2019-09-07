<?php

namespace Backalley\Wordpress\Taxonomy;

use Backalley\WordPress\Taxonomy\Taxonomy;
use Backalley\Wordpress\AbstractWpObjectFactory;
use Backalley\Wordpress\Taxonomy\Deprecated\CustomTaxonomyArgInterface;
use Backalley\Wordpress\Taxonomy\OptionHandlerInterface;

class Factory extends AbstractWpObjectFactory
{
    /**
     *
     */
    public function create(array $taxonomies): array
    {
        return parent::create($taxonomies);
    }

    /**
     *
     */
    public function build(string $name, array $args): object
    {
        $labels = $args['labels'] ?? [];
        $objectTypes = $args['object_types'];
        $options = $args['options'] ?? [];
        $rewrite = $args['rewrite'] ?? [];

        unset($args['labels'], $args['rewrite'], $args['object_types'], $args['options']);

        $taxonomy = (new Taxonomy($name, $objectTypes))
            ->setArgs($args)
            ->setLabels($labels)
            ->setRewrite($rewrite)
            ->register()
            ->getRegisteredTaxonomy();

        if (isset($this->optionHandlers)) {
            $this->processOptions($options, $taxonomy);
        }

        return $taxonomy;
    }

    /**
     *
     */
    protected function processOptions($options, \WP_Taxonomy $taxonomy)
    {
        foreach ($options as $option => $args) {
            $handler = $this->optionHandlers[$option];

            if (in_array(OptionHandlerInterface::class, class_implements($handler))) {
                $handler::handle($taxonomy, $args);
            } elseif (in_array(CustomTaxonomyArgInterface::class, class_implements($handler))) {  // supports deprecated CustomTaxonomyArgInterface
                $handler::pass($taxonomy, $args);
                add_action('wp_loaded', [$handler, 'run']);
            } else {
                throw new \Exception("I don't know what you mean. Your Argument is invalid.");
            }
        }
    }
}