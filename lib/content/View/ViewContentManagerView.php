<?php

namespace Leonidas\Content\View;

use Leonidas\Contracts\Ui\ViewInterface;
use WebContent\Copy\Contracts\ViewContentInterface;
use WebTheory\Html\Traits\ElementConstructorTrait;

class ViewContentManagerView implements ViewInterface
{
    use ElementConstructorTrait;

    private const JSON_HTML = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;

    public function render(array $data): string
    {
        return $this->root('div', [
            'class' => ['leonidas-view-content-editor'],
            'data-content' => $this->encodeData($data['content']),
            'data-alerts' => $this->encodeData($data['alerts'] ?? null),
            'data-config' => $this->encodeData($data['config'] ?? null),
        ] + $data['attributes'] ?? []);
    }

    protected function root(string $tag, array $attributes = [], string $inner = ''): string
    {
        return $this->tag(
            'div',
            ['leonidas-base' => true],
            $this->tag($tag, $attributes, $inner)
        );
    }

    protected function encodeData(mixed $data)
    {
        return json_encode($data, static::JSON_HTML);
    }
}
