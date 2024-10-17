<?php

namespace Leonidas\Library\Core\View\Twig;

use Performing\TwigComponents\View\ComponentAttributeBag;
use Performing\TwigComponents\View\ComponentSlot;
use Stringable;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\Config\Deferred\Reference\Mix;

class ComponentBuilderExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('new_attr', $this->generateAttributes(...)),
            new TwigFunction('new_slot', $this->generateSlot(...)),
            new TwigFunction('new_attr_slot', $this->generateAttributeSlot(...)),
            new TwigFunction('new_slot_if', $this->generateSlotIf(...)),
        ];
    }

    public function getFilters()
    {
        return [
            // Attribute Filters
            new TwigFilter('extract_attr', $this->extractAttribute(...)),
            new TwigFilter('extract_nullable_attr', $this->extractNullableAttribute(...)),
            new TwigFilter('then_extract_attr', $this->extractAttributeIf(...)),
            new TwigFilter('extract_attr_as_slot', $this->extractAttributeAsSlot(...)),
            new TwigFilter('with_attr', $this->mergeAttributes(...)),
            new TwigFilter('with_dynamic_attr', $this->mergeDynamicAttributes(...)),
            new TwigFilter('parse_attr', $this->parseAttributes(...)),

            // Slot Filters
            new TwigFilter('attr_fallback', $this->getSlotOrAttribute(...)),
            new TwigFilter('as_attr', $this->asAttributes(...)),
            new TwigFilter('as_dynamic_attr', $this->asDynamicAttributes(...)),
            new TwigFilter('cascade_attr', $this->extractSlotOrComponentAttributes(...), [
                'needs_context' => true
            ])
        ];
    }

    protected function generateAttributes(array $attributes = []): ComponentAttributeBag
    {
        return new ComponentAttributeBag($attributes);
    }

    protected function generateSlot(string $contents = '', array $attributes = []): ComponentSlot
    {
        return new ComponentSlot($contents, $attributes);
    }

    protected function generateAttributeSlot(array $attributes = []): ComponentSlot
    {
        return $this->generateSlot('', $attributes);
    }

    protected function generateSlotIf(?string $contents, array $attributes = []): ?ComponentSlot
    {
        return $contents ? $this->generateSlot($contents, $attributes) : null;
    }

    protected function extractAttribute(ComponentAttributeBag $attributes, string $key, mixed $default = null): mixed
    {
        $value = '';

        if ($attributes->has($key)) {
            $value = $attributes->get($key);

            unset($attributes[$key]);
        }

        return $value ?: $default;
    }

    protected function extractNullableAttribute(ComponentAttributeBag $attributes, string $key, mixed $default = null): mixed
    {
        if ($attributes->has($key)) {
            $value = $attributes->get($key);

            unset($attributes[$key]);
        }

        return $value ?? $default;
    }

    protected function extractAttributeIf(?ComponentAttributeBag $attributes, string $key, mixed $default = null): mixed
    {
        return $attributes
            ? $this->extractAttribute($attributes, $key, $default)
            : null;
    }

    protected function extractAttributeAsSlot(ComponentAttributeBag $attributes, string $key, array $slotAttr = []): ?ComponentSlot
    {
        $slot = null;

        if ($attributes->has($key)) {
            $slot = new ComponentSlot($attributes->get($key), $slotAttr);

            unset($attributes[$key]);
        }

        return $slot;
    }

    protected function getSlotOrAttribute(ComponentSlot $slot, ComponentAttributeBag $attributes, string $key): ComponentSlot
    {
        return $slot->isNotEmpty()
            ? $slot
            : $this->extractAttributeAsSlot($attributes, $key);
    }

    protected function resolveAttributes(?ComponentAttributeBag $attributes, array $entries = []): ComponentAttributeBag
    {
        return $attributes ?? $this->generateAttributes($entries);
    }

    protected function resolveSlotAttributes(?ComponentSlot $slot): ComponentAttributeBag
    {
        return $this->resolveAttributes($slot?->attributes);
    }

    protected function resolveSlot(?ComponentSlot $slot, string $contents = '', array $attributes = []): ComponentSlot
    {
        return $slot ?? $this->generateSlot($contents, $attributes);
    }

    protected function mergeAttributes(?ComponentAttributeBag $attributes, array $extra): ComponentAttributeBag
    {
        return $this->resolveAttributes($attributes)->merge($extra);
    }

    protected function asAttributes(?ComponentSlot $slot, array $extra = []): ComponentAttributeBag
    {
        return $this->mergeAttributes($slot?->attributes, $extra);
    }

    protected function isSimpleAttribute(mixed $value): bool
    {
        return is_numeric($value) || is_string($value);
    }

    protected function isComplexAttributes(mixed $value): bool
    {
        return is_bool($value) || is_array($value) || is_object($value);
    }

    protected function parseAttributes(ComponentAttributeBag $attr, array $extra = []): ComponentAttributeBag
    {
        $output = [];

        foreach ($attr as $key => $value) {
            if ($value) {
                $output[$key] = $value;
            }
        }

        return new ComponentAttributeBag($output + $extra);
    }

    protected function mergeDynamicAttributes(?ComponentAttributeBag $attributes, array $extra): ComponentAttributeBag
    {
        $attributes = $this->resolveAttributes($attributes);
        $simple = [];
        $complex = [];

        foreach ($extra as $key => $value) {
            if ($this->isSimpleAttribute($value)) {
                $simple[$key] = $value;
            } else {
                $complex[$key] = $value;
            }
        }

        // $attributes = $attributes->merge($simple);
        $attributes = new ComponentAttributeBag($attributes->getAttributes() + $extra);

        return $attributes;
    }

    protected function asDynamicAttributes(?ComponentSlot $slot, array $extra = []): ComponentAttributeBag
    {
        return $this->mergeDynamicAttributes($slot?->attributes, $extra);
    }

    protected function extractSlotOrComponentAttributes(
        array $context,
        ?ComponentSlot $slot,
        string $fromSlot,
        string $fromAttr,
        mixed $default = null
    ): mixed {
        return $this->extractAttributesFallback(
            $slot?->attributes,
            $fromSlot,
            $context['attributes'],
            $fromAttr,
            $default
        );
    }

    protected function extractAttributesFallback(
        ?ComponentAttributeBag $preference,
        string $preferenceAttr,
        ComponentAttributeBag $fallback,
        string $fallbackAttr,
        mixed $default,
    ): mixed {
        return $preference
            ? $this->extractAttribute($preference, $preferenceAttr, $default)
            : $this->extractAttribute($fallback, $fallbackAttr, $default);
    }

    protected function cascadeTheAttributes(array $context, ?ComponentSlot $slot, string $fromAttr): mixed
    {
        if ($slot) {
            $attr = $slot->attributes;
            $fromAttr = 'x-value';
        }

        return $this->extractAttribute($attr, $fromAttr);
    }
}
