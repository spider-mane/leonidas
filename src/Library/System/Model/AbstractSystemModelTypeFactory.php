<?php

namespace Leonidas\Library\System\Model;

class AbstractSystemModelTypeFactory
{
    protected string $prefix;

    public function __construct(string $prefix = '')
    {
        $this->prefix = $prefix;
    }

    protected function parseArgs($args): array
    {
        $labels = $args['labels'] ?? [];
        $plural = $args['plural'] ?? null;
        $single = $args['singular'] ?? null;

        $args['plural'] = $plural ?? $labels['name'];
        $args['singular'] = $single ?? $labels['singular_name'] ?? $plural;

        return $args;
    }

    protected function prefix(string $string)
    {
        return $this->prefix . $string;
    }
}
