<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class UtilExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('nest_merge', $this->nestMerge(...)),
            new TwigFilter('deep_merge', $this->deepMerge(...)),
        ];
    }

    public function getFunctions()
    {
        return [];
    }

    protected function nestMerge(iterable ...$composites): array
    {
        return array_merge_recursive(
            ...array_map($this->iterableToArray(...), $composites)
        );
    }

    protected function deepMerge(iterable ...$composites)
    {
        array_walk_recursive($composites, $this->maybeCastToArray(...));

        return array_merge_recursive(...$composites);
    }

    protected function maybeCastToArray(mixed &$value, bool $preserveKeys = true): void
    {
        $value = $this->maybeGetAsArray($value, $preserveKeys);
    }

    protected function maybeGetAsArray(mixed $value, bool $preserveKeys = true): mixed
    {
        return is_iterable($value)
            ? $this->iterableToArray($value, $preserveKeys)
            : $value;
    }

    protected function iterableToArray(iterable $value, $preserveKeys = true): array
    {
        return is_array($value)
            ? ($preserveKeys ? $value : array_values($value))
            : iterator_to_array($value, $preserveKeys);
    }
}
