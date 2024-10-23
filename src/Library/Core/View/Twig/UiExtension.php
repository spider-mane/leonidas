<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\Context\AccessLimiter;
use WebTheory\Context\ValueRevolver;

class UiExtension extends AbstractExtension implements ExtensionInterface
{
    public function getFunctions()
    {
        return [
            new TwigFunction('rotate', $this->rotate(...)),
            new TwigFunction('limit', $this->limit(...)),
            new TwigFunction('inject', $this->inject(...), [
                'needs_context' => true
            ]),
            new TwigFunction('update', $this->update(...), [
                'needs_context' => true
            ])
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('remove', $this->remove(...)),
            // new TwigFilter('extract', $this->extract(...))
        ];
    }

    protected function rotate(string ...$values): ValueRevolver
    {
        return new ValueRevolver(...$values);
    }

    protected function limit(array|object $subject): AccessLimiter
    {
        return new AccessLimiter($subject);
    }

    protected function remove(object|array $composite, string $key): array
    {
        unset($composite[$key]);

        return $composite;
    }

    protected function extract(object|array &$composite, string $key): mixed
    {
        $val = $composite[$key] ?? null;

        unset($composite[$key]);

        return $val;
    }

    protected function inject(array &$context, string $name, mixed $value): void
    {
        $context[$name] ??= $value;
    }

    protected function update(array &$context, string $name, mixed $value): void
    {
        $context[$name] = $value;
    }
}
