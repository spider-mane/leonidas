<?php

namespace Leonidas\Library\System\Configuration\Abstracts;

class AbstractModelConfigurationFactory
{
    public const CONTEXTS = ['info', 'core', 'REST', 'public', 'admin'];

    protected string $prefix;

    public function __construct(string $prefix = '')
    {
        $this->prefix = $prefix;
    }

    protected function parseArgs(array $args): array
    {
        $this->mergeContexts($args);
        $this->resolveBaseLabels($args);

        return $args;
    }

    protected function mergeContexts(array &$args): void
    {
        foreach (static::CONTEXTS as $context) {
            $context = '@' . $context;
            $args = $args + ($args[$context] ?? []);

            unset($args[$context]);
        }
    }

    protected function resolveBaseLabels(array &$args): void
    {
        $labels = $args['labels'] ?? [];
        $plural = $args['plural'] ?? null;
        $single = $args['singular'] ?? null;

        $args['plural'] = $plural ?? $labels['name'];
        $args['singular'] = $single ?? $labels['singular_name'] ?? $plural;
    }

    protected function prefix(string $string)
    {
        return $this->prefix . $string;
    }
}
