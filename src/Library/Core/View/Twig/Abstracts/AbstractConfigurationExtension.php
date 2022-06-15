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

    abstract protected function tokenParsers(): array;

    abstract protected function nodeVisitors(): array;

    abstract protected function filters(): array;

    abstract protected function tests(): array;

    abstract protected function functions(): array;

    abstract protected function operators(): array;
}
