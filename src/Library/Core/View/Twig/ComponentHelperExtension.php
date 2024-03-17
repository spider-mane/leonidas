<?php

namespace Leonidas\Library\Core\View\Twig;

use Performing\TwigComponents\View\ComponentAttributeBag;
use Performing\TwigComponents\View\ComponentSlot;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ComponentHelperExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('extract_attr', $this->extractAttribute(...)),
            new TwigFilter('extract_nullable_attr', $this->extractNullableAttribute(...)),
            new TwigFilter('then_extract_attr', $this->extractAttributeIf(...)),
            new TwigFilter('extract_attr_as_slot', $this->extractAttributeAsSlot(...)),
            new TwigFilter('with_attr', $this->withAttributes(...)),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('new_attr', $this->generateAttributes(...)),
            new TwigFunction('new_slot', $this->generateSlot(...)),
            new TwigFunction('new_slot_if', $this->generateSlotIf(...)),
        ];
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

    protected function extractAttributeAsSlot(ComponentAttributeBag $attributes, string $key): ?ComponentSlot
    {
        $slot = null;

        if ($attributes->has($key)) {
            $slot = new ComponentSlot($attributes->get($key), []);

            unset($attributes[$key]);
        }

        return $slot;
    }

    protected function withAttributes(ComponentAttributeBag $attributes, array $additions): ComponentAttributeBag
    {
        $attributes->setAttributes($attributes->getAttributes() + $additions);

        return $attributes;
    }

    protected function generateAttributes(array $attributes = []): ComponentAttributeBag
    {
        return new ComponentAttributeBag($attributes);
    }

    protected function generateSlot(string $contents = '', array $attributes = []): ComponentSlot
    {
        return new ComponentSlot($contents, $attributes);
    }

    protected function generateSlotIf(?string $contents, array $attributes = []): ?ComponentSlot
    {
        return $contents ? $this->generateSlot($contents, $attributes) : null;
    }
}
