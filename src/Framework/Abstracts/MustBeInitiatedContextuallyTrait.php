<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use RuntimeException;

trait MustBeInitiatedContextuallyTrait
{
    use FluentlySetsPropertiesTrait;
    use ConvertsCaseTrait;

    protected bool $isInitiated = false;

    protected array $initiatedContexts = [];

    protected function isInitiated(): bool
    {
        return $this->isInitiated;
    }

    protected function contextIsInitiated(string $context): bool
    {
        return in_array($context, $this->initiatedContexts);
    }

    protected function isFullyInitiated(): bool
    {
        static $resolved = [];

        if (!$resolved) {
            $suffix = 'RequiredProperties';

            foreach (get_class_methods($this) as $method) {
                if (str_ends_with($method, $suffix)) {
                    $resolved[] = $this->convert(
                        str_replace($suffix, '', $method)
                    )->toSnake();
                }
            }
        }

        $contexts = array_unique(
            [...$this->initiationContexts(), ...$resolved]
        );

        foreach ($contexts as $context) {
            if (!$this->contextIsInitiated($context)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return $this
     */
    protected function init(string $context): static
    {
        if ($this->contextIsInitiated($context)) {
            return $this;
        }

        $contexts = $this->initiationContexts();
        $resolved = $contexts[$context] ?? null;

        if (!$resolved) {
            $method = [$this, $this->suffixCamel('RequiredProperties', $context)];

            if (method_exists($this, $method[1]) && is_callable($method)) {
                $resolved = $method();
            } else {
                $class = static::class;

                throw new RuntimeException(
                    "Could not resolve initiation for context \"{$context}.\" Make sure it's defined in
                    \"initiationContexts()\" return value or that \"{$method[1]}()\" is present in class \"{$class}.\""
                );
            }
        }

        $this->maybeSet(...(array) $resolved);

        $this->isInitiated = true;
        $this->initiatedContexts[] = $context;

        return $this;
    }

    /**
     * @return array<string, string|array<string>>
     */
    protected function initiationContexts(): array
    {
        return [];
    }
}
