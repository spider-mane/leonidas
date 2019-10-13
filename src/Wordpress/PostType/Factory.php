<?php

namespace Backalley\Wordpress\PostType;

use Backalley\WordPress\PostType\OptionHandlerInterface;
use Backalley\WordPress\PostType\PostType;
use Backalley\Wordpress\AbstractWpObjectFactory;

class Factory extends AbstractWpObjectFactory
{
    /**
     *
     */
    public function create(array $postTypes): array
    {
        return parent::create($postTypes);
    }

    /**
     *
     */
    public function build(string $name, array $args): object
    {
        $labels = $args['labels'] ?? [];
        $options = $args['options'] ?? [];
        $rewrite = $args['rewrite'] ?? [];

        unset($args['labels'], $args['rewrite'], $args['options']);

        $postType = (new PostType($name))
            ->setArgs($args)
            ->setLabels($labels)
            ->setRewrite($rewrite)
            ->register()
            ->getRegisteredPostType();

        if (isset($this->optionHandlers)) {
            $this->processOptions($options, $postType);
        }

        return $postType;
    }

    /**
     *
     */
    protected function processOptions($options, \WP_Post_Type $postType)
    {
        foreach ($options as $option => $args) {
            $handler = $this->optionHandlers[$option] ?? null;

            if (!$handler) {
                throw new \Exception("There is no registered handler for the {$option} option provided");
            }

            if ($handler && in_array(OptionHandlerInterface::class, class_implements($handler))) {
                $handler::handle($postType, $args);
            } else {
                throw new \Exception("{$handler} is not a valid option handler");
            }
        }
    }
}
