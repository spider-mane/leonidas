<?php

namespace Leonidas\Content\Elements;

use Leonidas\Content\View\ViewContentManagerView;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\MaybeHandlesCsrfTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebContent\Copy\Contracts\ViewContentInterface;

class ViewContentManager implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
    use MaybeHandlesCsrfTrait;
    use RendersWithViewTrait;

    public function __construct(
        protected ?ViewContentInterface $content = null,
        protected array $config = [],
        protected array $alerts = [],
        protected array $attributes = [],
    ) {
        //
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new ViewContentManagerView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'content' => $this->content,
            'config' => $this->config,
            'alerts' => $this->alerts,
            'attributes' => $this->attributes,
        ];
    }
}
