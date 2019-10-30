<?php

namespace WebTheory\Leonidas;

use WebTheory\GuctilityBelt\Concerns\ClassResolverTrait;
use WebTheory\Leonidas\Contracts\AdminConfigHandlerInerface as ConfigHandler;

class AdminConfig
{
    use ClassResolverTrait;

    /**
     *
     */
    protected $namespaces;

    /**
     *
     */
    protected $handlers;

    public const NAMESPACES = [
        'webtheory.wordpress' => __NAMESPACE__ . '\\ConfigHandlers',
    ];

    public const HANDLERS = [];

    protected const CONVENTION = '%sConfigHandler';

    /**
     *
     */
    public function __construct(array $handlers = [], array $namespaces = [])
    {
        $this->namespaces = $namespaces + static::NAMESPACES;
        $this->handlers = $handlers + static::HANDLERS;
    }

    /**
     *
     */
    public function run(array $config)
    {
        foreach ($config as $option => $args) {

            $handler = $this->handlers[$option] ?? $this->getClass($option);

            if ($handler && in_array(ConfigHandler::class, class_implements($handler))) {
                $handler::handle($args);
            } else {
                throw new \Exception("{$option} is not recognized as a valid configuration option.");
            }
        }
    }
}
