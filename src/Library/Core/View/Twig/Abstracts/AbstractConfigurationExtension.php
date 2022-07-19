<?php

namespace Leonidas\Library\Core\View\Twig\Abstracts;

use Leonidas\Library\Core\View\Twig\ConfiguredExtension;

abstract class AbstractConfigurationExtension extends ConfiguredExtension
{
    public function __construct()
    {
        $this->config = [
            'token_parsers' => $this->tokenParsers(),
            'node_visitors' => $this->nodeVisitors(),
            'filters' => $this->filters(),
            'tests' => $this->tests(),
            'functions' => $this->functions(),
            'operators' => $this->operators(),
        ];
    }

    protected function tokenParsers(): array
    {
        return [];
    }

    protected function nodeVisitors(): array
    {
        return [];
    }

    protected function filters(): array
    {
        return [];
    }

    protected function tests(): array
    {
        return [];
    }

    protected function functions(): array
    {
        return [];
    }

    protected function operators(): array
    {
        return [];
    }
}
