<?php

namespace Leonidas\Library\Core\Taxonomy;

use Leonidas\Library\Core\AbstractWpObjectFactory;
use Leonidas\Contracts\Options\TaxonomyOptionHandlerInterface;
use Leonidas\Library\Core\Taxonomy\Taxonomy;

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
            $handler = $this->optionHandlers[$option] ?? null;

            if (!$handler) {
                throw new \Exception("There is no registered handler for the {$option} option provided");
            }

            if ($handler && in_array(TaxonomyOptionHandlerInterface::class, class_implements($handler))) {
                $handler::handle($taxonomy, $args);
            } else {
                throw new \Exception("{$handler} is not a valid option handler");
            }
        }
    }
}
